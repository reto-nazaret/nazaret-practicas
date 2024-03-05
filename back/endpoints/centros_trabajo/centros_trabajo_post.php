<?php

// Include necessary files
require_once 'db.php';

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if required data is provided
    $data = json_decode(file_get_contents("php://input"), true);

    // Check if all required data is provided
    if (!isset($data['id_empresa']) ||
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
        !isset($data['numero_trabajadores'])) {
        http_response_code(400);
        echo json_encode(['message' => 'Bad request. Missing required data', 'created' => false]);
        exit();
    }

    // Extract data from request
    $id_empresa = $data['id_empresa'];
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

    // Insert new alumno into database
    $conn = connectDB();
    $sql = "INSERT INTO centros_trabajo (id_empresa, denominacion, pais, territorio, municipio, codigo_postal, direccion, telefono, telefono2, fax, email, actividad, numero_trabajadores) 
            VALUES ('$id_empresa', '$denominacion', '$pais', '$territorio', '$municipio', '$codigo_postal', '$direccion', '$telefono', '$telefono2', '$fax', '$email', '$actividad', '$numero_trabajadores')";
    // die($sql);
    if ($conn->query($sql) === TRUE) {
        $newCentroId = $conn->insert_id;
        echo json_encode(['message' => 'Alumno created successfully', 'created' => true, 'id' => $newCentroId]);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Error creating alumno: ' . $conn->error, 'created' => false]);
    }

    $conn->close();
}

?>


