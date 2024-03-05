<?php

// Include necessary files
require_once 'config.php';
require_once 'db.php';

// Handle login endpoint separately
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle login logic here
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Check if username and password are provided
    if (empty($username) || empty($password)) {
        http_response_code(400);
        echo json_encode(['loggedIn' => false, 'usuario' => null]);
        exit();
    }

    // Connect to the database
    $conn = connectDB();

    // Hash the received password using SHA-256
    $hashedPassword = hash('sha256', $password);

    // Prepare and execute SQL query
    $sql = "SELECT u.id, u.username, u.nombre, u.apellidos, u.id_tipo_usuario, tu.nombre AS nombre_tipo_usuario 
    FROM usuarios u 
    INNER JOIN tipos_usuarios tu ON u.id_tipo_usuario = tu.id 
    WHERE username = '$username' AND contrasena = '$hashedPassword'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the first row from the result
        $row = $result->fetch_assoc();
        
        // Convert row data to usuario object
        $usuario = convertRowToUsuario($row);

        // Generate JWT for the usuario
        $userData = ['username' => $username];
        $token = generateJWT($userData);

        // Assign token to the usuario object
        $usuario['token'] = $token;

        // Prepare and return response
        echo json_encode(['loggedIn' => true, 'usuario' => $usuario]);
    } else {
        // User not found or invalid credentials
        http_response_code(401);
        echo json_encode(['loggedIn' => false, 'usuario' => null]);
    }

    // Close database connection
    $conn->close();
} else {
    // Invalid request method
    http_response_code(405);
    echo json_encode(['message' => 'Method not allowed']);
}

// Function to convert row data to usuario object
function convertRowToUsuario($row) {
    return [
        'id' => $row['id'],
        'username' => $row['username'],
        'nombre' => $row['nombre'],
        'apellidos' => $row['apellidos'],
        'usuario_tipo' => [
            'id' => $row['id_tipo_usuario'],
            'nombre' => $row['nombre_tipo_usuario']
        ]
    ];
}

?>
