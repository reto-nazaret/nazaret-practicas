<?php

// Include necessary files
require_once 'db.php';

// Handle PUT request
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Check if required data is provided
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data['id']) ||
        !isset($data['id_alumno']) ||
        !isset($data['id_centro_trabajo']) ||
        !isset($data['id_responsable']) || 
        !isset($data['id_tutor']) || 
        !isset($data['id_tipo_practica']) || 
        !isset($data['fecha_inicio']) || 
        !isset($data['fecha_fin'])) {
        http_response_code(400);
        echo json_encode(['message' => 'Bad request. Missing required data', 'updated' => false]);
        exit();
    }

    // Extract data from request
    $id = $data['id'];
    $id_alumno = $data['id_alumno'];
    $id_centro_trabajo = $data['id_centro_trabajo'];
    $id_responsable = $data['id_responsable'];
    $id_tutor = $data['id_tutor'];
    $id_tipo_practica = $data['id_tipo_practica'];
    $fecha_inicio = $data['fecha_inicio'];
    $fecha_fin = $data['fecha_fin'];

    // Update practica in the database
    $conn = connectDB();
    $sql = "UPDATE practicas SET 
            id_alumno = $id_alumno, 
            id_centro_trabajo = $id_centro_trabajo, 
            id_responsable = $id_responsable, 
            id_tutor = $id_tutor, 
            id_tipo_practica = $id_tipo_practica, 
            fecha_inicio = '$fecha_inicio', 
            fecha_fin = '$fecha_fin'
            WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'Practica updated successfully', 'updated' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Error updating practica: ' . $conn->error, 'updated' => false]);
    }

    $conn->close();
}

?>
