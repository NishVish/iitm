<?php

namespace App\Http\Controllers\Ai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Ai\RagServicesTrainer;
use App\Http\Controllers\Ai\RagServicesQuery;

class RagApi extends Controller
{
    private RagServicesTrainer $trainer;
    private RagServicesQuery $query;

    private string $dbPath;
    private string $ragPath;
    private string $model;


    public function __construct(
        RagServicesTrainer $ragTrainer,
        RagServicesQuery $ragQuery,


    ) {
        $this->trainer = $ragTrainer;
        $this->query = $ragQuery;
        $this->ragPath = storage_path('app/rag');
        $this->dbPath = $this->ragPath . '/data.sqlite3';
        $this->ragTestDbPath = $this->ragPath . '/ragtest.sqlite3';
        $this->model = config('ai.model');
        $this->ragtrainer = new RagServicesTrainer();

    }

    public function ask(Request $request)
    {
        return $this->query->ask($request);
    }
    public function askdirect($question)
    {
        return $this->query->ask(new Request(), $question);

        dd("hello");

    }
    public function train()
    {
        return $this->trainer->train();
    }
    public function trainbylink($link)
    {
        return $this->trainer->trainbylink($link);
    }


    public function ragTest()
    {
        $dbPath = storage_path('app/rag/data.sqlite3');

        if (!file_exists($dbPath)) {
            return response()->json([
                'status' => false,
                'message' => 'DB not found',
                'path' => $dbPath
            ]);
        }

        $sqlite = new \SQLite3($dbPath);

        // STEP 1: Get ALL data (debug only)
        $result = $sqlite->query("SELECT * FROM embeddings"); // change table name if needed

        $allData = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $allData[] = $row;
        }

        // STEP 2: Basic mismatch detection (simple sanity check)
        $issues = [];

        foreach ($allData as $i => $row) {

            if (!isset($row['content']) || trim($row['content']) === '') {
                $issues[] = "Row {$i} has empty content";
            }

            if (!isset($row['file_name'])) {
                $issues[] = "Row {$i} missing file_name";
            }

            if (strlen($row['content'] ?? '') < 20) {
                $issues[] = "Row {$i} content too small (bad chunking)";
            }
        }

        $sqlite->close();

        return response()->json([
            'status' => true,
            'total_rows' => count($allData),
            'sample_data' => array_slice($allData, 0, 5),
            'issues_found' => $issues
        ]);
    }

    public function test()
    {
    }
    public function ragresource()
    {
        return $this->trainer->updateData2();
    }


    public function porcess()
    {

        //     learining_resoures
//     html,txt,urls,pdf 
// read the resource path 

        // use all the document 
// do emmbedding and chunking and
// remove the old sqlite entires and store in new data in sqlite

        //     update learing details 



    }
    public function ragapi()
    {
        echo '<!DOCTYPE html>
<html>
<head>
    <title>RAG API</title>
</head>
<body>

    <h1>RAG API</h1>

    <ul>
        <li><a href="' . url('/api/ai/rag/ask') . '">Ask API</a></li>
        <li><a href="' . url('/api/ai/rag/update-data') . '">Update Data API</a></li>
        <li><a href="' . url('/api/ai/rag/test') . '">Test API</a></li>
    </ul>

    <hr>

    <h2>Test Ask API</h2>

    <form method="POST" action="' . url('/api/ai/rag/ask') . '">
        <label>Question:</label><br>
        <input type="text" name="question" value="What is IITM?" style="width:400px;"><br><br>

        <button type="submit">Send</button>
    </form>

</body>
</html>';
    }

}