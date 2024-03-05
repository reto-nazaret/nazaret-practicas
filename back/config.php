<?php

// Database configuration

// para el local
//define('DB_HOST', 'localhost');
//define('DB_USERNAME', 'root');
//define('DB_PASSWORD', '');
//define('DB_NAME', 'test_1_nazaprak');

// produccion DINAHOSTING
define('DB_HOST', '82.98.171.68');
define('DB_USERNAME', 'issam');
define('DB_PASSWORD', '@@Test24');
define('DB_NAME', 'nazaret_practicas');


// JWT configuration
define('JWT_SECRET', 'your_secret_key');
define('JWT_EXPIRATION_TIME', 2592000); // Expiration time in seconds (1 month)

?>
