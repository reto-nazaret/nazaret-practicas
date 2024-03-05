<?php

// Include necessary files
require_once 'db.php';

// Handle GET request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check if ID is provided in the request
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $conn = connectDB();

        // Get profesor by ID
        $sql = "SELECT * FROM profesores WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $profesor = $result->fetch_assoc();
            echo json_encode(['success' => true, 'profesor' => $profesor]);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Profesor not found', 'success' => false]);
        }

        $conn->close();
    } else {
        // Check if filtering options are provided
        $filter = $_GET['filter'] ?? '';

        // Initialize response variables
        $success = false;
        $profesores = null;

        // Get all profesores with filter if provided
        $conn = connectDB();
        if (!empty($filter)) {
            $filterSQL = '';
            $filterArray = json_decode($filter, true);
            foreach ($filterArray as $key => $value) {
                if ($key === "nombreCompleto") {
                    $filterSQL .= " AND CONCAT(nombre, ' ', apellidos) LIKE '%$value%'";
                } else {
                    $filterSQL .= " AND $key LIKE '%$value%'";
                }
            }
            $sql = "SELECT * FROM profesores WHERE 1" . $filterSQL;
        } else {
            $sql = "SELECT * FROM profesores";
        }

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $profesores = [];
            while ($row = $result->fetch_assoc()) {
                $profesores[] = $row;
            }
            $success = true;
        }

        // Prepare and return response
        echo json_encode(['success' => $success, 'profesores' => $profesores]);

        $conn->close();
    }
}

?>
