<?php

// Include necessary files
require_once 'db.php';

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if required data is provided
    $data = json_decode(file_get_contents("php://input"), true);

    // Check if all required data is provided
    if (!isset($data['nif']) ||
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
        !isset($data['numero_trabajadores'])) {
        http_response_code(400);
        echo json_encode(['message' => 'Bad request. Missing required data', 'created' => false]);
        exit();
    }

    // Extract data from request
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

    // Insert new empresa into database
    $conn = connectDB();
    $sql = "INSERT INTO empresas (nif, pais, razonSocial, titularidad, tipo_entidad, territorio, municipio, direccion, codigo_postal, telefono, fax, cnae, numero_trabajadores) 
            VALUES ('$nif', '$pais', '$razonSocial', '$titularidad', '$tipo_entidad', '$territorio', '$municipio', '$direccion', '$codigo_postal', '$telefono', '$fax', '$cnae', $numero_trabajadores)";
    if ($conn->query($sql) === TRUE) {
        $newEmpresaId = $conn->insert_id;
        echo json_encode(['message' => 'Empresa created successfully', 'created' => true, 'id' => $newEmpresaId]);
    } else {
        echo json_encode(['message' => 'Error creating empresa: ' . $conn->error, 'created' => false]);
    }

    $conn->close();
}

?>
