<?php
require_once "headers.php";
header("Access-Control-Allow-Method: GET");


if ($_SERVER['REQUEST_METHOD'] == "GET") {
    
    $query = "SELECT * FROM `posts`";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $data  = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode($data);
    } else {
        $data = [
            "status" => http_response_code(404),
            "message" => "No Posts To Display",
        ];
        echo json_encode($data);
    }
} else {
    $data = [
        "status" => http_response_code(405),
        "message" => "Method Not Allowed",
    ];
    echo json_encode($data);
}
