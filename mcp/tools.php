<?php

require_once "db.php";


function dashboard()
{
    global $conn;

    $result=[];


    $tables=[
        "tradevisitor",
        "exhibitor",
        "badges"
    ];


    foreach($tables as $table)
    {

        $sql="SELECT COUNT(*) total FROM $table";

        $query=$conn->query($sql);

        $row=$query->fetch_assoc();

        $result[$table]=$row["total"];

    }


    return $result;

}




function search_trade_visitor($name)
{

    global $conn;


    $stmt=$conn->prepare(
        "SELECT *
        FROM tradevisitor
        WHERE name LIKE ?
        LIMIT 50"
    );


    $search="%".$name."%";


    $stmt->bind_param(
        "s",
        $search
    );


    $stmt->execute();


    return $stmt
        ->get_result()
        ->fetch_all(MYSQLI_ASSOC);

}




function search_exhibitor($company)
{

    global $conn;


    $stmt=$conn->prepare(
        "SELECT *
        FROM exhibitor
        WHERE company_name LIKE ?
        LIMIT 50"
    );


    $search="%".$company."%";


    $stmt->bind_param(
        "s",
        $search
    );


    $stmt->execute();


    return $stmt
        ->get_result()
        ->fetch_all(MYSQLI_ASSOC);

}


?>