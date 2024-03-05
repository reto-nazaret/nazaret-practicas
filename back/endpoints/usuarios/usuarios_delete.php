<?php

// Include necessary files
require_once 'config.php';
require_once 'db.php';

// Handle DELETE request
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Check if id is provided in the request
    if (!isset($_GET['id'])) {
        http_response_code(400);
        echo json_encode(['message' => 'Bad request. Missing usuario id']);
        exit();
    }

    $id = $_GET['id'];
    $conn = connectDB();

    // Check if the usuario exists
    $checkSql = "SELECT * FROM usuarios WHERE id = $id";
    $result = $conn->query($checkSql);
    if ($result->num_rows === 0) {
        http_response_code(404);
        echo json_encode(['message' => 'Usuario not found']);
        exit();
    }

    // Delete the usuario
    $deleteSql = "DELETE FROM usuarios WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'Usuario updated successfully', 'deleted' => false]);
    } else {
        echo json_encode(['message' => 'Error updating usuario: ' . $conn->error, 'deleted' => true]);
    }

    $conn->close();
}

?>
