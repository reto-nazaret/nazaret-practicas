<?php

// Include necessary files
require_once 'db.php';

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if required data is provided
    $data = json_decode(file_get_contents("php://input"), true);

    // Check if all required data is provided
    if (!isset($data['dni']) ||
        !isset($data['nombre']) ||
        !isset($data['apellidos']) || 
        !isset($data['poblacion']) || 
        !isset($data['email']) || 
        !isset($data['otra_titulacion']) || 
        !isset($data['vehiculo']) ||
        !isset($data['ingles']) ||
        !isset($data['euskera']) ||
        !isset($data['otros_idiomas']) ||
        !isset($data['id_ciclo'])) {
        http_response_code(400);
        echo json_encode(['message' => 'Bad request. Missing required data', 'created' => false]);
        exit();
    }

    // Extract data from request
    $dni = $data['dni'];
    $nombre = $data['nombre'];
    $apellidos = $data['apellidos'];
    $poblacion = $data['poblacion'];
    $email = $data['email'];
    $otra_titulacion = $data['otra_titulacion'];
    $vehiculo = $data['vehiculo'];
    $ingles = $data['ingles'];
    $euskera = $data['euskera'];
    $otros_idiomas = $data['otros_idiomas'];
    $id_ciclo = $data['id_ciclo'];

    // Insert new alumno into database
    $conn = connectDB();
    $sql = "INSERT INTO alumnos (dni, nombre, apellidos, poblacion, email, otra_titulacion, vehiculo, ingles, euskera, otros_idiomas, id_ciclo) 
            VALUES ('$dni', '$nombre', '$apellidos', '$poblacion', '$email', '$otra_titulacion', $vehiculo, '$ingles', '$euskera', '$otros_idiomas', $id_ciclo)";
    // die($sql);
    if ($conn->query($sql) === TRUE) {
        $newAlumnoId = $conn->insert_id;
        echo json_encode(['message' => 'Alumno created successfully', 'created' => true, 'id' => $newAlumnoId]);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Error creating alumno: ' . $conn->error, 'created' => false]);
    }

    $conn->close();
}

?>
