<?php

// Include necessary files
require_once 'db.php';

// Function to convert row data to usuario object
function convertRowToUsuario($row) {
    return [
        'id' => $row['id'],
        'username' => $row['username'],
        'nombre' => $row['nombre'],
        'apellidos' => $row['apellidos'],
        'email' => $row['email'],
        'telefono' => $row['telefono'],
        'usuario_tipo' => [
            'id' => $row['id_tipo_usuario'],
            'nombre' => $row['nombre_tipo_usuario']
        ]
    ];
}

// Check if ID and filter are provided in the request
$id = $_GET['id'] ?? '';
$filter = $_GET['filter'] ?? '';

// Initialize response variables
$success = false;
$usuarios = null;
$usuario = null;

// Get usuario(s) from the database
$conn = connectDB();
if (!empty($id)) {
    // Get usuario by ID
    $sql = "SELECT u.*, tu.nombre AS nombre_tipo_usuario 
            FROM usuarios u 
            INNER JOIN tipos_usuarios tu ON u.id_tipo_usuario = tu.id 
            WHERE u.id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the first row
        $row = $result->fetch_assoc();
        // Convert row data to usuario object
        $usuario = convertRowToUsuario($row);
        $success = true;
    }
} else {
    // Build filter SQL if provided
    $filterSQL = '';
    if (!empty($filter)) {
        $filterArray = json_decode($filter, true);
        foreach ($filterArray as $key => $value) {
            if (is_string($value)) {
                // Handle string values with LIKE "%VALUE%"
                $filterSQL .= " AND u.$key LIKE '%$value%'";
            } elseif (is_numeric($value)) {
                // Handle numeric values with =
                $filterSQL .= " AND u.$key = $value";
            } elseif (is_bool($value)) {
                // Convert boolean value to 0 or 1 and handle with =
                $boolValue = $value ? 1 : 0;
                $filterSQL .= " AND u.$key = $boolValue";
            }
        }
    }

    // Get all usuarios with filter if provided
    $sql = "SELECT u.*, tu.nombre AS nombre_tipo_usuario 
            FROM usuarios u 
            INNER JOIN tipos_usuarios tu ON u.id_tipo_usuario = tu.id 
            WHERE 1" . $filterSQL;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $usuarios = [];
        while ($row = $result->fetch_assoc()) {
            // Convert each row data to usuario object
            $usuarios[] = convertRowToUsuario($row);
        }
        $success = true;
    }
}

// Prepare and return response
if (!empty($id)) {
    $response = [
        'success' => $success,
        'usuario' => $usuario
    ];
} else {
    $response = [
        'success' => $success,
        'usuarios' => $usuarios
    ];
}

echo json_encode($response);

$conn->close();

?>
