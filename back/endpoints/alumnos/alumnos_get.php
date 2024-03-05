<?php

// Include necessary files
require_once 'db.php';

// Check if ID and filter are provided in the request
$id = $_GET['id'] ?? '';
$filter = $_GET['filter'] ?? '';

// Initialize response variables
$success = false;
$alumnos = null;
$alumno = null;

// Get alumno(s) from the database
$conn = connectDB();
if (!empty($id)) {
    // Get alumno by ID
    $sql = "SELECT a.id, a.dni, a.nombre, a.apellidos, a.poblacion, a.email, a.otra_titulacion, a.vehiculo, a.ingles, a.euskera, a.otros_idiomas, a.id_ciclo, c.nombre AS nombre_ciclo
        FROM alumnos a
        INNER JOIN ciclos c ON a.id_ciclo = c.id
        WHERE a.id = $id";
    // $sql = "SELECT * FROM alumnos WHERE id = $id";
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
                //verify the specific ones 
                if ($key === "nombreCompleto") {
                    $filterSQL .= " AND CONCAT(a.nombre, ' ', a.apellidos) LIKE '%$value%'";
                } else {
                    $filterSQL .= " AND $key LIKE '%$value%'";
                }
            } elseif (is_numeric($value)) {
                // Handle numeric values with =
                $filterSQL .= " AND $key = $value";
            } elseif (is_bool($value)) {
                // Convert boolean value to 0 or 1 and handle with =
                $boolValue = $value ? 1 : 0;
                $filterSQL .= " AND $key = $boolValue";
            }
        }
    }

    // Get all alumnos with filter if provided
    $sql = "SELECT a.id, a.dni, a.nombre, a.apellidos, a.poblacion, a.email, a.otra_titulacion, a.vehiculo, a.ingles, a.euskera, a.otros_idiomas, c.id AS id_ciclo, c.nombre AS nombre_ciclo
        FROM alumnos a
        INNER JOIN ciclos c ON a.id_ciclo = c.id
        WHERE 1" . $filterSQL;

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $alumnos = [];
        while ($row = $result->fetch_assoc()) {
            $alumnos[] = convertRowToAlumno($row);
        }
        $success = true;
    }
}

// Prepare and return response
if (!empty($id)) {
    $response = [
        'success' => $success,
        'alumno' => $alumno
    ];
} else {
    $response = [
        'success' => $success,
        'alumnos' => $alumnos
    ];
}

echo json_encode($response);

$conn->close();

// Function to convert row data to alumno object
function convertRowToAlumno($row) {
    return [
        'id' => $row['id'],
        'dni' => $row['dni'],
        'nombre' => $row['nombre'],
        'apellidos' => $row['apellidos'],
        'poblacion' => $row['poblacion'],
        'email' => $row['email'],
        'otra_titulacion' => $row['otra_titulacion'],
        'vehiculo' => $row['vehiculo'],
        'ingles' => $row['ingles'],
        'euskera' => $row['euskera'],
        'otros_idiomas' => $row['otros_idiomas'],
        'ciclo' => [
            'id' => $row['id_ciclo'],
            'nombre' => $row['nombre_ciclo']
        ]
    ];
}

?>
