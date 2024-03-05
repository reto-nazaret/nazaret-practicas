<?php

// Include necessary files
require_once 'db.php';

// Handle DELETE request
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Check if id is provided in the request
    if (!isset($_GET['id'])) {
        http_response_code(400);
        echo json_encode(['message' => 'Bad request. Missing empresa id', 'deleted' => false]);
        exit();
    }

    $id = $_GET['id'];
    $conn = connectDB();

    // Check if the empresa exists
    $checkSql = "SELECT * FROM empresas WHERE id = $id";
    $result = $conn->query($checkSql);
    if ($result->num_rows === 0) {
        http_response_code(404);
        echo json_encode(['message' => 'Empresa not found', 'deleted' => false]);
        exit();
    }

    // Delete the empresa
    $deleteSql = "DELETE FROM empresas WHERE id = $id";
    if ($conn->query($deleteSql) === TRUE) {
        echo json_encode(['message' => 'Empresa deleted successfully', 'deleted' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Error deleting empresa: ' . $conn->error, 'deleted' => false]);
    }

    $conn->close();
}

?>
