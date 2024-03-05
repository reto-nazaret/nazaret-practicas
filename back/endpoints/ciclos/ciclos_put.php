<?php

// Include necessary files
require_once 'db.php';

// Handle PUT request
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Check if required data is provided
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data['id']) || !isset($data['nombre'])) {
        http_response_code(400);
        echo json_encode(['message' => 'Bad request. Missing required data', 'updated' => false]);
        exit();
    }

    // Extract data from request
    $id = $data['id'];
    $nombre = $data['nombre'];

    // Update ciclo in the database
    $conn = connectDB();
    $sql = "UPDATE ciclos SET nombre = '$nombre' WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'Ciclo updated successfully', 'updated' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Error updating ciclo: ' . $conn->error, 'updated' => false]);
    }

    $conn->close();
}

?>
