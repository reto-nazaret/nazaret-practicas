<?php

// Include necessary files
require_once 'db.php';

// Handle PUT request
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Check if required data is provided
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data['id']) ||
        !isset($data['nif']) ||
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
        echo json_encode(['message' => 'Bad request. Missing required data', 'updated' => false]);
        exit();
    }

    // Extract data from request
    $id = $data['id'];
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

    // Update contacto in the database
    $conn = connectDB();
    $sql = "UPDATE contactos SET 
            nif = '$nif', 
            nombre = '$nombre', 
            apellidos = '$apellidos', 
            telefono = '$telefono', 
            movil = '$movil', 
            fax = '$fax',
            email = '$email',
            departamento = '$departamento',
            responsable = $responsable,
            id_centro = $id_centro
            WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'Contacto updated successfully', 'updated' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Error updating contacto: ' . $conn->error, 'updated' => false]);
    }

    $conn->close();
}

?>
