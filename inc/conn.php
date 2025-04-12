<?php 
session_start();

define("SERVERNAME" , "localhost");
define("USERNAME" , "root");
define("PASSWORD" , "");
define("DBNAME" , "blog");

$conn = mysqli_connect(SERVERNAME , USERNAME , PASSWORD , DBNAME); 
if(!$conn):
    echo mysqli_connect_error();
endif; 

?>