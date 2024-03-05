<?php

// Include necessary files
require_once 'db.php';

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if required data is provided
    $data = json_decode(file_get_contents("php://input"), true);

    // Check if all required data is provided
    if (!isset($data['id_alumno']) ||
        !isset($data['id_centro_trabajo']) ||
        !isset($data['id_responsable']) || 
        !isset($data['id_tutor']) || 
        !isset($data['id_tipo_practica']) || 
        !isset($data['fecha_inicio']) || 
        !isset($data['fecha_fin'])) {
        http_response_code(400);
        echo json_encode(['message' => 'Bad request. Missing required data', 'created' => false]);
        exit();
    }

    // Extract data from request
    $id_alumno = $data['id_alumno'];
    $id_centro_trabajo = $data['id_centro_trabajo'];
    $id_responsable = $data['id_responsable'];
    $id_tutor = $data['id_tutor'];
    $id_tipo_practica = $data['id_tipo_practica'];
    $fecha_inicio = $data['fecha_inicio'];
    $fecha_fin = $data['fecha_fin'];

    // Insert new practica into database
    $conn = connectDB();
    $sql = "INSERT INTO practicas (id_alumno, id_centro_trabajo, id_responsable, id_tutor, id_tipo_practica, fecha_inicio, fecha_fin) 
            VALUES ($id_alumno, $id_centro_trabajo, $id_responsable, $id_tutor, $id_tipo_practica, '$fecha_inicio', '$fecha_fin')";
    if ($conn->query($sql) === TRUE) {
        $newPracticaId = $conn->insert_id;
        echo json_encode(['message' => 'Practica created successfully', 'created' => true, 'id' => $newPracticaId]);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Error creating practica: ' . $conn->error, 'created' => false]);
    }

    $conn->close();
}

?>
