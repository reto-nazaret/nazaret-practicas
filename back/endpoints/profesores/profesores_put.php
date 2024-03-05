<?php

// Include necessary files
require_once 'config.php';
require_once 'db.php';

// Handle PUT request
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Check if required data is provided
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data['id']) ||
        !isset($data['dni']) ||
        !isset($data['nombre']) ||
        !isset($data['apellidos'])) {
        http_response_code(400);
        echo json_encode(['message' => 'Bad request. Missing required data', 'updated' => false]);
        exit();
    }

    // Extract data from request
    $id = $data['id'];
    $dni = $data['dni'];
    $nombre = $data['nombre'];
    $apellidos = $data['apellidos'];

    // Update profesor in the database
    $conn = connectDB();
    $sql = "UPDATE profesores SET 
            dni = '$dni', 
            nombre = '$nombre', 
            apellidos = '$apellidos'
            WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'Profesor updated successfully', 'updated' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Error updating profesor: ' . $conn->error, 'updated' => false]);
    }

    $conn->close();
}

?>
