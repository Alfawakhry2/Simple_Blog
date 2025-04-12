<?php
require_once "headers.php";
header("Access-Control-Allow-Method: GET");

$uri = $_SERVER['REQUEST_URI'];
$uri_arr = explode('/' , $uri);
if(is_numeric(end($uri_arr))){
    $id = end($uri_arr);
}else{
    $data = [
        "status" => http_response_code(505),
        "message" => "Not Allowed",
    ];
    echo json_encode($data);
    exit(0);
}
if ($_SERVER['REQUEST_METHOD'] == "GET" ) {
    
    $query = "SELECT * FROM `posts` WHERE `id` = '$id'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 1) {
        $data  = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode($data);
    } else {
        $data = [
            "status" => http_response_code(404),
            "message" => "Post Not Found !",
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
