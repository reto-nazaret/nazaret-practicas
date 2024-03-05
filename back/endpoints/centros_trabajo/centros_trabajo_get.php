<?php

// Include necessary files
require_once 'db.php';

// Check if ID and filter are provided in the request
$id = $_GET['id'] ?? '';
$filter = $_GET['filter'] ?? '';

// Initialize response variables
$success = false;
$centros_trabajo = null;
$centro_trabajo = null;

// Get centro(s) de trabajo from the database
$conn = connectDB();
if (!empty($id)) {
    // Get centro de trabajo by ID
    $sql = "SELECT ct.id, ct.denominacion, ct.pais, ct.territorio, ct.municipio, ct.codigo_postal, ct.direccion, ct.telefono, ct.telefono2, ct.fax, ct.email, ct.actividad, ct.numero_trabajadores, e.id AS empresa_id, e.nif AS empresa_nif, e.pais AS empresa_pais, e.razonSocial AS empresa_razonSocial, e.titularidad AS empresa_titularidad, e.tipo_entidad AS empresa_tipo_entidad, e.territorio AS empresa_territorio, e.municipio AS empresa_municipio, e.direccion AS empresa_direccion, e.codigo_postal AS empresa_codigo_postal, e.telefono AS empresa_telefono, e.fax AS empresa_fax, e.cnae AS empresa_cnae, e.numero_trabajadores AS empresa_numero_trabajadores
        FROM centros_trabajo ct
        INNER JOIN empresas e ON ct.id_empresa = e.id
        WHERE ct.id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $centro_trabajo = convertRowToCentroTrabajo($row);
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
                if ($key === 'denominacion') {
                    $key = 'ct.denominacion';
                } elseif ($key === 'codigo_postal') {
                    $key = 'ct.codigo_postal';
                }
                $filterSQL .= " AND $key LIKE '%$value%'";
            } elseif (is_numeric($value)) {
                // Handle numeric values with =
                if ($key === 'id_empresa') {
                    $key = 'ct.id_empresa'; // !!!! HAY QUE PREGNTAR SOBRE ESTO
                }
                $filterSQL .= " AND $key = $value";
            } elseif (is_bool($value)) {
                // Convert boolean value to 0 or 1 and handle with =
                $boolValue = $value ? 1 : 0;
                $filterSQL .= " AND $key = $boolValue";
            }
        }
    }

    // Get all centros de trabajo with filter if provided
    $sql = "SELECT ct.id, ct.denominacion, ct.pais, ct.territorio, ct.municipio, ct.codigo_postal, ct.direccion, ct.telefono, ct.telefono2, ct.fax, ct.email, ct.actividad, ct.numero_trabajadores, e.id AS empresa_id, e.nif AS empresa_nif, e.pais AS empresa_pais, e.razonSocial AS empresa_razonSocial, e.titularidad AS empresa_titularidad, e.tipo_entidad AS empresa_tipo_entidad, e.territorio AS empresa_territorio, e.municipio AS empresa_municipio, e.direccion AS empresa_direccion, e.codigo_postal AS empresa_codigo_postal, e.telefono AS empresa_telefono, e.fax AS empresa_fax, e.cnae AS empresa_cnae, e.numero_trabajadores AS empresa_numero_trabajadores
        FROM centros_trabajo ct
        INNER JOIN empresas e ON ct.id_empresa = e.id
        WHERE 1" . $filterSQL;

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $centros_trabajo = [];
        while ($row = $result->fetch_assoc()) {
            $centros_trabajo[] = convertRowToCentroTrabajo($row);
        }
        $success = true;
    }
}

// Prepare and return response
if (!empty($id)) {
    $response = [
        'success' => $success,
        'centro_trabajo' => $centro_trabajo
    ];
} else {
    $response = [
        'success' => $success,
        'centros_trabajo' => $centros_trabajo
    ];
}

echo json_encode($response);

$conn->close();

// Function to convert row data to centro de trabajo object
function convertRowToCentroTrabajo($row) {
    return [
        'id' => $row['id'],
        'denominacion' => $row['denominacion'],
        'pais' => $row['pais'],
        'territorio' => $row['territorio'],
        'municipio' => $row['municipio'],
        'codigo_postal' => $row['codigo_postal'],
        'direccion' => $row['direccion'],
        'telefono' => $row['telefono'],
        'telefono2' => $row['telefono2'],
        'fax' => $row['fax'],
        'email' => $row['email'],
        'actividad' => $row['actividad'],
        'numero_trabajadores' => $row['numero_trabajadores'],
        'empresa' => [
            'id' => $row['empresa_id'],
            'nif' => $row['empresa_nif'],
            'pais' => $row['empresa_pais'],
            'razonSocial' => $row['empresa_razonSocial'],
            'titularidad' => $row['empresa_titularidad'],
            'tipo_entidad' => $row['empresa_tipo_entidad'],
            'territorio' => $row['empresa_territorio'],
            'municipio' => $row['empresa_municipio'],
            'direccion' => $row['empresa_direccion'],
            'codigo_postal' => $row['empresa_codigo_postal'],
            'telefono' => $row['empresa_telefono'],
            'fax' => $row['empresa_fax'],
            'cnae' => $row['empresa_cnae'],
            'numero_trabajadores' => $row['empresa_numero_trabajadores']
        ]
    ];
}

?>
