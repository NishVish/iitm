<?php

header("Content-Type: application/json");

require_once "tools.php";

try {

    $input = file_get_contents("php://input");

    $request = json_decode($input, true);

    $tool = $request["tool"] ?? "";

    switch ($tool) {


        case "dashboard":

            echo json_encode([
                "status"=>"success",
                "data"=>dashboard()
            ]);

        break;


        case "search_trade_visitor":

            echo json_encode([
                "status"=>"success",
                "data"=>search_trade_visitor(
                    $request["name"] ?? ""
                )
            ]);

        break;


        case "search_exhibitor":

            echo json_encode([
                "status"=>"success",
                "data"=>search_exhibitor(
                    $request["company"] ?? ""
                )
            ]);

        break;


        default:

            echo json_encode([
                "status"=>"error",
                "message"=>"Unknown tool"
            ]);

    }


}
catch(Exception $e){

    echo json_encode([
        "status"=>"error",
        "message"=>$e->getMessage()
    ]);

}

?>