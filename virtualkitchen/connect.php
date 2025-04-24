<?php

$host = 'localhost'; 
$dbname = 'u_240125594_vkitchen_db'; 
$username = 'u-240125594'; 
$password = 'N928HtFddQwoEeL'; 


$conn = new mysqli($host, $username, $password, $dbname);


if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
echo 'Connected successfully!';
?>
