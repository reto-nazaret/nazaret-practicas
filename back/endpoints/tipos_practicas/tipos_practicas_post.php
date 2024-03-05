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

    // Insert new tipo_practica into database
    $conn = connectDB();
    $sql = "INSERT INTO tipos_practicas (nombre) VALUES ('$nombre')";
    if ($conn->query($sql) === TRUE) {
        $newTipoPracticaId = $conn->insert_id;
        echo json_encode(['message' => 'Tipo_practica created successfully', 'created' => true, 'id' => $newTipoPracticaId]);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Error creating tipo_practica: ' . $conn->error, 'created' => false]);
    }

    $conn->close();
}

?>
