<?php

// Include necessary files
require_once 'db.php';

// Check if ID is provided in the request
if (isset($_GET['id'])) {
    // Retrieve a single tipo_practica by ID
    $id = $_GET['id'];
    $conn = connectDB();

    $sql = "SELECT * FROM tipos_practicas WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows === 0) {
        http_response_code(404);
        echo json_encode(['message' => 'Tipo practica not found', 'success' => true]);
        exit();
    }

    $tipo_practica = $result->fetch_assoc();
    echo json_encode(['success' => true, 'tipo_practica' => $tipo_practica]);
    $conn->close();
} else {
    // Retrieve all tipo_practicas
    $conn = connectDB();

    $sql = "SELECT * FROM tipos_practicas";
    $result = $conn->query($sql);

    if ($result->num_rows === 0) {
        echo json_encode(['success' => true, 'message' => 'No tipo practicas found']);
        exit();
    }

    $tipo_practicas = [];
    while ($row = $result->fetch_assoc()) {
        $tipo_practicas[] = $row;
    }

    echo json_encode(['success' => true, 'tipo_practicas' => $tipo_practicas]);
    $conn->close();
}
