<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "park_db";

// Opens a connection to a MySQL server
$conn = mysqli_connect($servername, $username, $password, $database);
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}