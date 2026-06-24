<?php

namespace App\Http\Controllers\Ai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Ai\RagServices;

class RagApi extends Controller
{
    private RagServices $rag;

    public function __construct(RagServices $rag)
    {
        $this->rag = $rag;
    }

    public function ask(Request $request)
    {

        return $this->rag->ask($request);
    }

    public function updateData()
    {
        return $this->rag->updateData();
    }

    public function ragTest()
    {
        return $this->rag->ragTest();
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