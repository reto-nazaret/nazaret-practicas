<?php

// Include necessary files
require_once 'db.php';

// Handle GET request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check if id is provided in the request
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $conn = connectDB();

        // Get the ciclo by ID
        $sql = "SELECT * FROM ciclos WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows === 0) {
            http_response_code(404);
            echo json_encode(['message' => 'Ciclo not found', 'ciclo' => null]);
            exit();
        }

        $ciclo = $result->fetch_assoc();
        echo json_encode(['message' => 'Ciclo found', 'ciclo' => $ciclo]);
    } else {
        // Get all ciclos
        $conn = connectDB();

        $sql = "SELECT * FROM ciclos";
        $result = $conn->query($sql);

        $ciclos = [];
        while ($row = $result->fetch_assoc()) {
            $ciclos[] = $row;
        }

        echo json_encode(['message' => 'Ciclos found', 'ciclos' => $ciclos]);
    }

    $conn->close();
}

?>
