<?php

// Include necessary files
require_once 'db.php';

// Handle PUT request
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Check if required data is provided
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data['id']) ||
        !isset($data['dni']) ||
        !isset($data['nombre']) ||
        !isset($data['apellidos']) || 
        !isset($data['email']) || 
        !isset($data['poblacion']) || 
        !isset($data['otra_titulacion']) || 
        !isset($data['vehiculo']) || 
        !isset($data['ingles']) ||
        !isset($data['euskera']) ||
        !isset($data['otros_idiomas']) ||    
        !isset($data['id_ciclo'])) {
        http_response_code(400);
        echo json_encode(['message' => 'Bad request. Missing required data', 'updated' => false]);
        exit();
    }

    // Extract data from request
    $id = $data['id'];
    $dni = $data['dni'];
    $nombre = $data['nombre'];
    $apellidos = $data['apellidos'];
    $email = $data['email'];
    $poblacion = $data['poblacion'];
    $otra_titulacion = $data['otra_titulacion'];
    $vehiculo = $data['vehiculo'];
    $ingles = $data['ingles'];
    $euskera = $data['euskera'];
    $otros_idiomas = $data['otros_idiomas'];
    $id_ciclo = $data['id_ciclo'];

    // Update alumno in the database
    $conn = connectDB();
    $sql = "UPDATE alumnos SET 
            dni = '$dni', 
            nombre = '$nombre', 
            apellidos = '$apellidos', 
            email = '$email', 
            poblacion = '$poblacion', 
            otra_titulacion = '$otra_titulacion', 
            vehiculo = $vehiculo,
            ingles = '$ingles',
            euskera = '$euskera',
            otros_idiomas = '$otros_idiomas',
            id_ciclo = $id_ciclo
            WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'Alumno updated successfully', 'updated' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Error updating alumno: ' . $conn->error, 'updated' => false]);
    }

    $conn->close();
}

?>
