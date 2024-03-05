<?php

// Include necessary files
require_once 'db.php';

// Handle DELETE request
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Check if ID is provided in the request
    $id = $_GET['id'] ?? '';

    // Validate ID
    if (empty($id)) {
        http_response_code(400);
        echo json_encode(['message' => 'Bad request. ID is required', 'deleted' => false]);
        exit();
    }

    // Delete practica from the database
    $conn = connectDB();
    $sql = "DELETE FROM practicas WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'Practica deleted successfully', 'deleted' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Error deleting practica: ' . $conn->error, 'deleted' => false]);
    }

    $conn->close();
}

?>
