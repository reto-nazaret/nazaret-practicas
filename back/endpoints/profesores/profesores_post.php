<?php

// Include necessary files
require_once 'config.php';
require_once 'db.php';

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if required data is provided
    $data = json_decode(file_get_contents("php://input"), true);

    // Check if all required data is provided
    if (!isset($data['dni']) ||
        !isset($data['nombre']) ||
        !isset($data['apellidos'])) {
        http_response_code(400);
        echo json_encode(['message' => 'Bad request. Missing required data', 'created' => false]);
        exit();
    }

    // Extract data from request
    $dni = $data['dni'];
    $nombre = $data['nombre'];
    $apellidos = $data['apellidos'];

    // Insert new profesor into database
    $conn = connectDB();
    $sql = "INSERT INTO profesores (dni, nombre, apellidos) VALUES ('$dni', '$nombre', '$apellidos')";
    if ($conn->query($sql) === TRUE) {
        $newProfesorId = $conn->insert_id;
        echo json_encode(['message' => 'Profesor created successfully', 'created' => true, 'id' => $newProfesorId]);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Error creating profesor: ' . $conn->error, 'created' => false]);
    }

    $conn->close();
}

?>
