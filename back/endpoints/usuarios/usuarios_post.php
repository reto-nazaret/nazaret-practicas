<?php

// Include necessary files
require_once 'config.php';
require_once 'db.php';

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if required data is provided
    $data = json_decode(file_get_contents("php://input"), true);

    // add here only the required data
    if (!isset($data['username']) ||
        !isset($data['nombre']) ||
        !isset($data['apellidos']) || 
        !isset($data['email']) || 
        !isset($data['contrasena']) || 
        !isset($data['id_tipo_usuario'])) {
        http_response_code(400);
        echo json_encode(['message' => 'Bad request. Missing required data']);
        exit();
    }

    // Extract data from request
    $username = $data['username'];
    $nombre = $data['nombre'];
    $apellidos = $data['apellidos'];
    $email = $data['email'];
    $contrasena = $data['contrasena'];
    $id_tipo_usuario = $data['id_tipo_usuario'];

    // Hash the password
    $hashedPassword = hash('sha256', $contrasena);

    // Insert new usuario into database
    $conn = connectDB();
    $sql = "INSERT INTO usuarios (username, nombre, apellidos, contrasena, id_tipo_usuario) 
    VALUES ('$username', '$nombre', '$apellidos', '$hashedPassword', $id_tipo_usuario)";
    if ($conn->query($sql) === TRUE) {
        $newUsuarioId = $conn->insert_id;
        echo json_encode(['message' => 'Usuario created successfully','created' => true, 'id' => $newUsuarioId]);
    } else {
        echo json_encode(['message' => 'Error creating usuario: ' . $conn->error, 'created' => false]);
    }

    $conn->close();
}

?>
