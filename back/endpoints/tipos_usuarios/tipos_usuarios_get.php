<?php

// Include necessary files
require_once 'db.php';

// Handle GET request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check if ID is provided in the request
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $conn = connectDB();

        // Retrieve the tipo_usuario by ID
        $sql = "SELECT * FROM tipos_usuarios WHERE id = $id";
        $result = $conn->query($sql);

        // Check if tipo_usuario exists
        if ($result->num_rows > 0) {
            $tipo_usuario = $result->fetch_assoc();
            echo json_encode(['success' => true, 'tipo_usuario' => $tipo_usuario]);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Tipo usuario not found', 'success' => false]);
        }

        $conn->close();
    } else {
        // Retrieve all tipos_usuarios
        $conn = connectDB();
        $sql = "SELECT * FROM tipos_usuarios";
        $result = $conn->query($sql);

        // Check if tipos_usuarios exist
        if ($result->num_rows > 0) {
            $tipos_usuarios = [];
            while ($row = $result->fetch_assoc()) {
                $tipos_usuarios[] = $row;
            }
            echo json_encode(['success' => true, 'tipos_usuarios' => $tipos_usuarios]);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'No tipos usuarios found', 'success' => false]);
        }

        $conn->close();
    }
}

?>
