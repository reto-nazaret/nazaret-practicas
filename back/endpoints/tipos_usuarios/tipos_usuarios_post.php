<?php

// Include necessary files
require_once 'db.php';

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if required data is provided
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['nombre'])) {
        http_response_code(400);
        echo json_encode(['message' => 'Bad request. Missing nombre', 'created' => false]);
        exit();
    }

    // Extract data from request
    $nombre = $data['nombre'];

    // Insert new tipo_usuario into database
    $conn = connectDB();
    $sql = "INSERT INTO tipos_usuarios (nombre) VALUES ('$nombre')";
    if ($conn->query($sql) === TRUE) {
        $newTipoUsuarioId = $conn->insert_id;
        echo json_encode(['message' => 'Tipo usuario created successfully', 'created' => true, 'id' => $newTipoUsuarioId]);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Error creating tipo usuario: ' . $conn->error, 'created' => false]);
    }

    $conn->close();
}

?>
