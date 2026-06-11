<?php

namespace App\Http\Controllers\Utility;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;

class DocumentationController extends Controller
{
    public function index()
    {
        return view("utility.documentation.index");
    }
    public function documentlist()
    {
        $data = [
            "data_operation" => [
                "title" => "Data Operation",
                "description" => "Basic data handling operations like create, read, update, delete (CRUD).",
                "methods" => ["create", "read", "update", "delete"]
            ],
            "collection" => [
                "title" => "Collection",
                "description" => "Handles grouping and managing multiple records or objects.",
                "methods" => ["list_all", "filter", "group_by", "sort"]
            ],
            "updation" => [
                "title" => "Updation",
                "description" => "Rules and logic for updating existing data safely.",
                "methods" => ["update_by_id", "bulk_update", "partial_update", "validate_before_update"]
            ],
            "cross_validation" => [
                "title" => "Cross Validation",
                "description" => "Validates data consistency across multiple modules or tables.",
                "methods" => ["check_dependencies", "validate_relations", "verify_integrity", "sync_validation"]
            ]
        ];

        return json_encode($data);
    }
    public function pdftotextaction(Request $request)
    {

        $file = $request->file('pdf_file');
        $pdfText = '';

        if ($file) {
            $parser = new Parser();
            $pdf = $parser->parseFile($file->getPathname());
            $pdfText = $pdf->getText();
        }

        return view('utility.pdftotext', compact('pdfText'));
    }

    public function texttopdf()
    {
        return view("utility.texttopdf");
    }


}