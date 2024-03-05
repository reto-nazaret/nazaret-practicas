<?php

// Include necessary files
require_once 'db.php';

// Handle PUT request
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Check if required data is provided
    $data = json_decode(file_get_contents("php://input"), true);
    if (
        !isset($data['id']) ||
        !isset($data['nif']) ||
        !isset($data['pais']) ||
        !isset($data['razonSocial']) ||
        !isset($data['titularidad']) ||
        !isset($data['tipo_entidad']) ||
        !isset($data['territorio']) ||
        !isset($data['municipio']) ||
        !isset($data['direccion']) ||
        !isset($data['codigo_postal']) ||
        !isset($data['telefono']) ||
        !isset($data['fax']) ||
        !isset($data['cnae']) ||
        !isset($data['numero_trabajadores'])
    ) {
        http_response_code(400);
        echo json_encode(['message' => 'Bad request. Missing required data', 'updated' => false]);
        exit();
    }

    // Extract data from request
    $id = $data['id'];
    $nif = $data['nif'];
    $pais = $data['pais'];
    $razonSocial = $data['razonSocial'];
    $titularidad = $data['titularidad'];
    $tipo_entidad = $data['tipo_entidad'];
    $territorio = $data['territorio'];
    $municipio = $data['municipio'];
    $direccion = $data['direccion'];
    $codigo_postal = $data['codigo_postal'];
    $telefono = $data['telefono'];
    $fax = $data['fax'];
    $cnae = $data['cnae'];
    $numero_trabajadores = $data['numero_trabajadores'];

    // Update empresa in the database
    $conn = connectDB();
    $sql = "UPDATE empresas SET 
            nif = '$nif', 
            pais = '$pais', 
            razonSocial = '$razonSocial', 
            titularidad = '$titularidad', 
            tipo_entidad = '$tipo_entidad', 
            territorio = '$territorio', 
            municipio = '$municipio', 
            direccion = '$direccion', 
            codigo_postal = '$codigo_postal', 
            telefono = '$telefono', 
            fax = '$fax', 
            cnae = '$cnae', 
            numero_trabajadores = $numero_trabajadores
            WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'Empresa updated successfully', 'updated' => true]);
    } else {
        echo json_encode(['message' => 'Error updating empresa: ' . $conn->error, 'updated' => false]);
    }

    $conn->close();
}
