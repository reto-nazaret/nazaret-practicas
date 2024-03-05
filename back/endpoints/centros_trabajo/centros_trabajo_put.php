<?php

// Include necessary files
require_once 'db.php';

// Handle PUT request
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Check if required data is provided
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data['id']) ||
        !isset($data['denominacion']) ||
        !isset($data['pais']) ||
        !isset($data['territorio']) ||
        !isset($data['municipio']) ||
        !isset($data['codigo_postal']) ||
        !isset($data['direccion']) ||
        !isset($data['telefono']) ||
        !isset($data['telefono2']) ||
        !isset($data['fax']) ||
        !isset($data['email']) ||
        !isset($data['actividad']) ||
        !isset($data['numero_trabajadores']) ||
        !isset($data['id_empresa'])) {
        http_response_code(400);
        echo json_encode(['message' => 'Bad request. Missing required data', 'updated' => false]);
        exit();
    }

    // Extract data from request
    $id = $data['id'];
    $denominacion = $data['denominacion'];
    $pais = $data['pais'];
    $territorio = $data['territorio'];
    $municipio = $data['municipio'];
    $codigo_postal = $data['codigo_postal'];
    $direccion = $data['direccion'];
    $telefono = $data['telefono'];
    $telefono2 = $data['telefono2'];
    $fax = $data['fax'];
    $email = $data['email'];
    $actividad = $data['actividad'];
    $numero_trabajadores = $data['numero_trabajadores'];
    $id_empresa = $data['id_empresa'];

    // Update alumno in the database
    $conn = connectDB();
    $sql = "UPDATE alumnos SET 
            denominacion = '$denominacion', 
            pais = '$pais', 
            territorio = '$territorio', 
            municipio = '$municipio', 
            codigo_postal = '$codigo_postal', 
            direccion = '$direccion', 
            telefono = '$telefono', 
            telefono2 = '$telefono2', 
            fax = '$fax',
            email = '$email',
            actividad = '$actividad',
            numero_trabajadores = '$numero_trabajadores',
            id_empresa = $id_empresa
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
