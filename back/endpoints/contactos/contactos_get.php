<?php

// Include necessary files
require_once 'db.php';

// Handle GET request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check if ID is provided in the request
    $id = $_GET['id'] ?? '';

    // Initialize response variables
    $success = false;
    $contacto = null;
    $contactos = null;

    // Get contacto(s) from the database
    $conn = connectDB();
    if (!empty($id)) {
        // Get contacto by ID
        $sql = "SELECT c.id, c.nif, c.nombre, c.apellidos, c.telefono, c.movil, c.fax, c.email, c.departamento, c.responsable, c.id_centro, 
                ce.denominacion AS centro_denominacion, ce.pais AS centro_pais, ce.territorio AS centro_territorio, ce.municipio AS centro_municipio,
                ce.codigo_postal AS centro_codigo_postal, ce.direccion AS centro_direccion, ce.telefono AS centro_telefono, ce.telefono2 AS centro_telefono2, 
                ce.fax AS centro_fax, ce.email AS centro_email, ce.actividad AS centro_actividad, ce.numero_trabajadores AS centro_numero_trabajadores,
                e.id AS empresa_id, e.nif AS empresa_nif, e.pais AS empresa_pais, e.razonSocial AS empresa_razonSocial, e.titularidad AS empresa_titularidad,
                e.tipo_entidad AS empresa_tipo_entidad, e.territorio AS empresa_territorio, e.municipio AS empresa_municipio, e.direccion AS empresa_direccion,
                e.codigo_postal AS empresa_codigo_postal, e.telefono AS empresa_telefono, e.fax AS empresa_fax, e.cnae AS empresa_cnae, e.numero_trabajadores AS empresa_numero_trabajadores
                FROM contactos c
                INNER JOIN centros_trabajo ce ON c.id_centro = ce.id
                INNER JOIN empresas e ON ce.id_empresa = e.id
                WHERE c.id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $contacto = convertRowToContacto($row);
            $success = true;
        }
    } else {
        // Get all contactos
        $sql = "SELECT c.id, c.nif, c.nombre, c.apellidos, c.telefono, c.movil, c.fax, c.email, c.departamento, c.responsable, c.id_centro, 
                ce.denominacion AS centro_denominacion, ce.pais AS centro_pais, ce.territorio AS centro_territorio, ce.municipio AS centro_municipio,
                ce.codigo_postal AS centro_codigo_postal, ce.direccion AS centro_direccion, ce.telefono AS centro_telefono, ce.telefono2 AS centro_telefono2, 
                ce.fax AS centro_fax, ce.email AS centro_email, ce.actividad AS centro_actividad, ce.numero_trabajadores AS centro_numero_trabajadores,
                e.id AS empresa_id, e.nif AS empresa_nif, e.pais AS empresa_pais, e.razonSocial AS empresa_razonSocial, e.titularidad AS empresa_titularidad,
                e.tipo_entidad AS empresa_tipo_entidad, e.territorio AS empresa_territorio, e.municipio AS empresa_municipio, e.direccion AS empresa_direccion,
                e.codigo_postal AS empresa_codigo_postal, e.telefono AS empresa_telefono, e.fax AS empresa_fax, e.cnae AS empresa_cnae, e.numero_trabajadores AS empresa_numero_trabajadores
                FROM contactos c
                INNER JOIN centros_trabajo ce ON c.id_centro = ce.id
                INNER JOIN empresas e ON ce.id_empresa = e.id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $contactos = [];
            while ($row = $result->fetch_assoc()) {
                $contactos[] = convertRowToContacto($row);
            }
            $success = true;
        }
    }

    // Prepare and return response
    if (!empty($id)) {
        $response = [
            'success' => $success,
            'contacto' => $contacto
        ];
    } else {
        $response = [
            'success' => $success,
            'contactos' => $contactos
        ];
    }

    echo json_encode($response);

    $conn->close();
}

// Function to convert row data to contacto object
function convertRowToContacto($row) {
    return [
        'id' => $row['id'],
        'nif' => $row['nif'],
        'nombre' => $row['nombre'],
        'apellidos' => $row['apellidos'],
        'telefono' => $row['telefono'],
        'movil' => $row['movil'],
        'fax' => $row['fax'],
        'email' => $row['email'],
        'departamento' => $row['departamento'],
        'responsable' => $row['responsable'],
        'centro_trabajo' => [
            'id' => $row['id_centro'],
            'denominacion' => $row['centro_denominacion'],
            'pais' => $row['centro_pais'],
            'territorio' => $row['centro_territorio'],
            'municipio' => $row['centro_municipio'],
            'codigo_postal' => $row['centro_codigo_postal'],
            'direccion' => $row['centro_direccion'],
            'telefono' => $row['centro_telefono'],
            'telefono2' => $row['centro_telefono2'],
            'fax' => $row['centro_fax'],
            'email' => $row['centro_email'],
            'actividad' => $row['centro_actividad'],
            'numero_trabajadores' => $row['centro_numero_trabajadores'],
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
        ]
    ];
}

?>
