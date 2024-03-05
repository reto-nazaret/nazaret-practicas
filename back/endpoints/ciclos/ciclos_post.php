<?php

// Include necessary files
require_once 'db.php';

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if required data is provided
    $data = json_decode(file_get_contents("php://input"), true);

    // Check if all required data is provided
    if (!isset($data['nombre'])) {
        http_response_code(400);
        echo json_encode(['message' => 'Bad request. Missing required data', 'created' => false]);
        exit();
    }

    // Extract data from request
    $nombre = $data['nombre'];

    // Insert new ciclo into database
    $conn = connectDB();
    $sql = "INSERT INTO ciclos (nombre) VALUES ('$nombre')";
    if ($conn->query($sql) === TRUE) {
        $newCicloId = $conn->insert_id;
        echo json_encode(['message' => 'Ciclo created successfully', 'created' => true, 'id' => $newCicloId]);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Error creating ciclo: ' . $conn->error, 'created' => false]);
    }

    $conn->close();
}

?>
