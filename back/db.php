<?php

require_once 'config.php';

function connectDB() {
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

function executeQuery($query) {
    $conn = connectDB();
    $result = $conn->query($query);
    $conn->close();
    return $result;
}

?>
