<?php

// Include necessary files
require_once 'db.php';

// Handle DELETE request
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Check if required data is provided
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data['id'])) {
        http_response_code(400);
        echo json_encode(['message' => 'Bad request. Missing required data', 'deleted' => false]);
        exit();
    }

    // Extract data from request
    $id = $data['id'];

    // Delete contacto from the database
    $conn = connectDB();
    $sql = "DELETE FROM contactos WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'Contacto deleted successfully', 'deleted' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Error deleting contacto: ' . $conn->error, 'deleted' => false]);
    }

    $conn->close();
}

?>
