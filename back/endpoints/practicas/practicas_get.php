<?php

// Include necessary files
require_once 'db.php';

// Check if ID and filter are provided in the request
$id = $_GET['id'] ?? '';
$filter = $_GET['filter'] ?? '';

// Initialize response variables
$success = false;
$practica = null;
$practicas = null;

// Get practica(s) from the database
$conn = connectDB();
if (!empty($id)) {
    // Get practica by ID
    $sql = "SELECT p.id, p.fecha_inicio, p.fecha_fin,
            a.id AS alumno_id, a.dni AS alumno_dni, a.nombre AS alumno_nombre, a.apellidos AS alumno_apellidos, 
            a.poblacion AS alumno_poblacion, a.email AS alumno_email, a.otra_titulacion AS alumno_otra_titulacion, 
            a.vehiculo AS alumno_vehiculo, a.ingles AS alumno_ingles, a.euskera AS alumno_euskera, 
            a.otros_idiomas AS alumno_otros_idiomas, 
            c.id AS ciclo_id, c.nombre AS ciclo_nombre,
            ct.id AS centro_trabajo_id, ct.denominacion AS centro_trabajo_denominacion, ct.pais AS centro_trabajo_pais,
            ct.territorio AS centro_trabajo_territorio, ct.municipio AS centro_trabajo_municipio, 
            ct.codigo_postal AS centro_trabajo_codigo_postal, ct.direccion AS centro_trabajo_direccion, 
            ct.telefono AS centro_trabajo_telefono, ct.telefono2 AS centro_trabajo_telefono2, ct.fax AS centro_trabajo_fax, 
            ct.email AS centro_trabajo_email, ct.actividad AS centro_trabajo_actividad, 
            ct.numero_trabajadores AS centro_trabajo_numero_trabajadores,
            e.id AS empresa_id, e.nif AS empresa_nif, e.pais AS empresa_pais, e.razonSocial AS empresa_razonSocial, 
            e.titularidad AS empresa_titularidad, e.tipo_entidad AS empresa_tipo_entidad, e.territorio AS empresa_territorio, 
            e.municipio AS empresa_municipio, e.direccion AS empresa_direccion, e.codigo_postal AS empresa_codigo_postal, 
            e.telefono AS empresa_telefono, e.fax AS empresa_fax, e.cnae AS empresa_cnae, 
            e.numero_trabajadores AS empresa_numero_trabajadores,
            res.id AS responsable_id, res.nif AS responsable_nif, res.nombre AS responsable_nombre, 
            res.apellidos AS responsable_apellidos, res.telefono AS responsable_telefono, res.movil AS responsable_movil, 
            res.fax AS responsable_fax, res.email AS responsable_email, res.departamento AS responsable_departamento,
            t.id AS tutor_id, t.dni AS tutor_dni, t.nombre AS tutor_nombre, t.apellidos AS tutor_apellidos,
            tp.id AS tipo_practica_id, tp.nombre AS tipo_practica_nombre
            FROM practicas p
            INNER JOIN alumnos a ON p.id_alumno = a.id
            INNER JOIN ciclos c ON a.id_ciclo = c.id
            INNER JOIN centros_trabajo ct ON p.id_centro_trabajo = ct.id
            INNER JOIN empresas e ON ct.id_empresa = e.id
            INNER JOIN contactos res ON p.id_responsable = res.id
            INNER JOIN profesores t ON p.id_tutor = t.id
            INNER JOIN tipos_practicas tp ON p.id_tipo_practica = tp.id
            WHERE p.id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $practica = convertRowToPractica($row);
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

    // Get all practicas with filter if provided
    $sql = "SELECT p.id, p.fecha_inicio, p.fecha_fin,
            a.id AS alumno_id, a.dni AS alumno_dni, a.nombre AS alumno_nombre, a.apellidos AS alumno_apellidos, 
            a.poblacion AS alumno_poblacion, a.email AS alumno_email, a.otra_titulacion AS alumno_otra_titulacion, 
            a.vehiculo AS alumno_vehiculo, a.ingles AS alumno_ingles, a.euskera AS alumno_euskera, 
            a.otros_idiomas AS alumno_otros_idiomas, 
            c.id AS ciclo_id, c.nombre AS ciclo_nombre,
            ct.id AS centro_trabajo_id, ct.denominacion AS centro_trabajo_denominacion, ct.pais AS centro_trabajo_pais,
            ct.territorio AS centro_trabajo_territorio, ct.municipio AS centro_trabajo_municipio, 
            ct.codigo_postal AS centro_trabajo_codigo_postal, ct.direccion AS centro_trabajo_direccion, 
            ct.telefono AS centro_trabajo_telefono, ct.telefono2 AS centro_trabajo_telefono2, ct.fax AS centro_trabajo_fax, 
            ct.email AS centro_trabajo_email, ct.actividad AS centro_trabajo_actividad, 
            ct.numero_trabajadores AS centro_trabajo_numero_trabajadores,
            e.id AS empresa_id, e.nif AS empresa_nif, e.pais AS empresa_pais, e.razonSocial AS empresa_razonSocial, 
            e.titularidad AS empresa_titularidad, e.tipo_entidad AS empresa_tipo_entidad, e.territorio AS empresa_territorio, 
            e.municipio AS empresa_municipio, e.direccion AS empresa_direccion, e.codigo_postal AS empresa_codigo_postal, 
            e.telefono AS empresa_telefono, e.fax AS empresa_fax, e.cnae AS empresa_cnae, 
            e.numero_trabajadores AS empresa_numero_trabajadores,
            res.id AS responsable_id, res.nif AS responsable_nif, res.nombre AS responsable_nombre, 
            res.apellidos AS responsable_apellidos, res.telefono AS responsable_telefono, res.movil AS responsable_movil, 
            res.fax AS responsable_fax, res.email AS responsable_email, res.departamento AS responsable_departamento,
            t.id AS tutor_id, t.dni AS tutor_dni, t.nombre AS tutor_nombre, t.apellidos AS tutor_apellidos,
            tp.id AS tipo_practica_id, tp.nombre AS tipo_practica_nombre
            FROM practicas p
            INNER JOIN alumnos a ON p.id_alumno = a.id
            INNER JOIN ciclos c ON a.id_ciclo = c.id
            INNER JOIN centros_trabajo ct ON p.id_centro_trabajo = ct.id
            INNER JOIN empresas e ON ct.id_empresa = e.id
            INNER JOIN contactos res ON p.id_responsable = res.id
            INNER JOIN profesores t ON p.id_tutor = t.id
            INNER JOIN tipos_practicas tp ON p.id_tipo_practica = tp.id
            WHERE 1" . $filterSQL;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $practicas = [];
        while ($row = $result->fetch_assoc()) {
            $practicas[] = convertRowToPractica($row);
        }
        $success = true;
    }
}

// Prepare and return response
if (!empty($id)) {
    $response = [
        'success' => $success,
        'practica' => $practica
    ];
} else {
    $response = [
        'success' => $success,
        'practicas' => $practicas
    ];
}

echo json_encode($response);

$conn->close();

// Function to convert row data to practica object
function convertRowToPractica($row) {
    return [
        'id' => $row['id'],
        'fecha_inicio' => $row['fecha_inicio'],
        'fecha_fin' => $row['fecha_fin'],
        'alumno' => [
            'id' => $row['alumno_id'],
            'dni' => $row['alumno_dni'],
            'nombre' => $row['alumno_nombre'],
            'apellidos' => $row['alumno_apellidos'],
            'poblacion' => $row['alumno_poblacion'],
            'email' => $row['alumno_email'],
            'otra_titulacion' => $row['alumno_otra_titulacion'],
            'vehiculo' => $row['alumno_vehiculo'],
            'ingles' => $row['alumno_ingles'],
            'euskera' => $row['alumno_euskera'],
            'otros_idiomas' => $row['alumno_otros_idiomas'],
            'ciclo' => [
                'id' => $row['ciclo_id'],
                'nombre' => $row['ciclo_nombre'],
            ],
        ],
        'centro_trabajo' => [
            'id' => $row['centro_trabajo_id'],
            'denominacion' => $row['centro_trabajo_denominacion'],
            'pais' => $row['centro_trabajo_pais'],
            'territorio' => $row['centro_trabajo_territorio'],
            'municipio' => $row['centro_trabajo_municipio'],
            'codigo_postal' => $row['centro_trabajo_codigo_postal'],
            'direccion' => $row['centro_trabajo_direccion'],
            'telefono' => $row['centro_trabajo_telefono'],
            'telefono2' => $row['centro_trabajo_telefono2'],
            'fax' => $row['centro_trabajo_fax'],
            'email' => $row['centro_trabajo_email'],
            'actividad' => $row['centro_trabajo_actividad'],
            'numero_trabajadores' => $row['centro_trabajo_numero_trabajadores'],
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
                'numero_trabajadores' => $row['empresa_numero_trabajadores'],
            ],
        ],
        'responsable' => [
            'id' => $row['responsable_id'],
            'nif' => $row['responsable_nif'],
            'nombre' => $row['responsable_nombre'],
            'apellidos' => $row['responsable_apellidos'],
            'telefono' => $row['responsable_telefono'],
            'movil' => $row['responsable_movil'],
            'fax' => $row['responsable_fax'],
            'email' => $row['responsable_email'],
            'departamento' => $row['responsable_departamento'],
        ],
        'tutor' => [
            'id' => $row['tutor_id'],
            'dni' => $row['tutor_dni'],
            'nombre' => $row['tutor_nombre'],
            'apellidos' => $row['tutor_apellidos'],
        ],
        'tipo_practica' => [
            'id' => $row['tipo_practica_id'],
            'nombre' => $row['tipo_practica_nombre'],
        ],
    ];
}

?>
