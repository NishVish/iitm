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

    public function __construct(
        RagServicesTrainer $ragTrainer,
        RagServicesQuery $ragQuery
    ) {
        $this->trainer = $ragTrainer;
        $this->query = $ragQuery;
    }

    public function ask(Request $request)
    {
        return $this->query->ask($request);
    }

    public function train()
    {
        return $this->trainer->train();
    }

    public function ragTest()
    {
        return $this->query->ragTest();
    }

    public function ragresource()
    {
        return $this->trainer->updateData2();
    }


public function porcess(){

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