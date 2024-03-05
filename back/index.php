<?php

// Include necessary files
require_once 'jwt.php';
require_once 'config.php';

// Define allowed endpoints
$allowedEndpoints = ['usuarios', 'tipos_usuarios', 'idiomas', 'tipos_practicas', 'tipos_usuario', 'practicas', 'alumnos', 'profesores', 'ciclos', 'empresas', 'centros_trabajo', 'contactos']; // Add more endpoints as needed

// Get request method and endpoint from the URL
$requestMethod = $_SERVER['REQUEST_METHOD'];
$endpoint = $_GET['endpoint'] ?? '';

// Check if the endpoint is allowed
if (!in_array($endpoint, $allowedEndpoints) && $endpoint !== 'login') {
    http_response_code(404);
    echo json_encode(['message' => 'Endpoint not found']);
    exit();
}

// Handle login endpoint separately
if ($endpoint === 'login') {
    require_once 'login.php';
    exit();
}

// Check if JWT exists and is valid for all other endpoints
$headers = apache_request_headers();
$jwt = $headers['Authorization'] ?? '';

if (!$jwt || !verifyJWT($jwt)) {
    http_response_code(401);
    echo json_encode(['message' => 'Unauthorized']);
    exit();
}

// Include endpoint handler based on the request method
switch ($requestMethod) {
    case 'GET':
        require_once "endpoints/{$endpoint}/{$endpoint}_get.php";
        break;
    case 'POST':
        require_once "endpoints/{$endpoint}/{$endpoint}_post.php";
        break;
    case 'PUT':
        require_once "endpoints/{$endpoint}/{$endpoint}_put.php";
        break;
    case 'DELETE':
        require_once "endpoints/{$endpoint}/{$endpoint}_delete.php";
        break;
    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method not allowed']);
        break;
}

?>
