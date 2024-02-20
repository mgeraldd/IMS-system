<?php
$servername = "localhost";
$database_username = "root";
$database_password = "";
$database_name = "foodieDB";
//$database_name = "epiz_34248798_mpesa_app";

$database_connection = new mysqli($servername, $database_username, $database_password, $database_name);
if($database_connection->error){
    echo "Error connecting the database";
}else{
    //echo "Connection successful.";
}
?>