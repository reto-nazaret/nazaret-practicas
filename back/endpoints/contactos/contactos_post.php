<?php

// Include necessary files
require_once 'db.php';

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if required data is provided
    $data = json_decode(file_get_contents("php://input"), true);

    // Check if all required data is provided
    if (!isset($data['nif']) ||
        !isset($data['nombre']) ||
        !isset($data['apellidos']) || 
        !isset($data['id_centro']) ||
        !isset($data['telefono']) ||
        !isset($data['movil']) ||
        !isset($data['fax']) ||
        !isset($data['email']) ||
        !isset($data['departamento']) ||
        !isset($data['responsable'])) {
        http_response_code(400);
        echo json_encode(['message' => 'Bad request. Missing required data', 'created' => false]);
        exit();
    }

    // Extract data from request
    $nif = $data['nif'];
    $nombre = $data['nombre'];
    $apellidos = $data['apellidos'];
    $id_centro = $data['id_centro'];
    $telefono = $data['telefono'];
    $movil = $data['movil'];
    $fax = $data['fax'];
    $email = $data['email'];
    $departamento = $data['departamento'];
    $responsable = $data['responsable'] ? 1 : 0; // Convert to 0 or 1

    // Insert new contacto into database
    $conn = connectDB();
    $sql = "INSERT INTO contactos (nif, nombre, apellidos, telefono, movil, fax, email, departamento, responsable, id_centro) 
            VALUES ('$nif', '$nombre', '$apellidos', '$telefono', '$movil', '$fax', '$email', '$departamento', $responsable, $id_centro)";
    if ($conn->query($sql) === TRUE) {
        $newContactoId = $conn->insert_id;
        echo json_encode(['message' => 'Contacto created successfully', 'created' => true, 'id' => $newContactoId]);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Error creating contacto: ' . $conn->error, 'created' => false]);
    }

    $conn->close();
}

?>
