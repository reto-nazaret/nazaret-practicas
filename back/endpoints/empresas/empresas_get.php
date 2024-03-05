<?php

// Include necessary files
require_once 'db.php';

// Check if ID and filter are provided in the request
$id = $_GET['id'] ?? '';
$filter = $_GET['filter'] ?? '';

// Initialize response variables
$success = false;
$empresas = null;
$empresa = null;

// Get alumno(s) from the database
$conn = connectDB();
if (!empty($id)) {
    // Get alumno by ID
    $sql = "SELECT * FROM empresas WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $alumno = convertRowToAlumno($row);
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
                $filterSQL .= " AND $key LIKE '%$value%'";
                
            }
            // elseif (is_numeric($value)) {
            //     // Handle numeric values with =
            //     $filterSQL .= " AND $key = $value";
            // }
            // elseif (is_bool($value)) {
            //     // Convert boolean value to 0 or 1 and handle with =
            //     $boolValue = $value ? 1 : 0;
            //     $filterSQL .= " AND $key = $boolValue";
            // }
        }
    }

    // Get all alumnos with filter if provided
    $sql = "SELECT * FROM empresas WHERE 1" . $filterSQL;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $empresas = [];
        while ($row = $result->fetch_assoc()) {
            $empresas[] = $row;
        }
        $success = true;
    }
}

// Prepare and return response
if (!empty($id)) {
    $response = [
        'success' => $success,
        'empresa' => $empresa
    ];
} else {
    $response = [
        'success' => $success,
        'empresas' => $empresas
    ];
}

echo json_encode($response);

$conn->close();



?>
