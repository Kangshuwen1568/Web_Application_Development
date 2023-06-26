<?php
// used to connect to the database
$host = "localhost";
$db_name = "shuwen";
$username = "shuwen";
$password = "]Iz1m6G)IXE-8_fx";

try {
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // show error
    echo "";
}
// show error
catch (PDOException $exception) {
    echo "Connection error: " . $exception->getMessage();
}
