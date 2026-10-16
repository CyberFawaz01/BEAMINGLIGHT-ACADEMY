<?php
/**
 * Database connection.
 * For local setup, copy db-config.example.php to db-config.local.php and edit it.
 * db-config.local.php is intentionally ignored by Git so credentials stay local.
 */
$configFile = __DIR__ . '/db-config.local.php';
$config = file_exists($configFile) ? require $configFile : [];

$host = $config['host'] ?? (getenv('DB_HOST') ?: 'localhost');
$user = $config['user'] ?? (getenv('DB_USER') ?: 'root');
$password = $config['password'] ?? (getenv('DB_PASSWORD') ?: '');
$db = $config['database'] ?? (getenv('DB_NAME') ?: 'schoolwebsite_database');

$con = mysqli_connect($host, $user, $password, $db);
if (!$con) {
    error_log('Database connection failed: ' . mysqli_connect_error());
    http_response_code(500);
    exit('Unable to connect to the database. Check your local database configuration.');
}
mysqli_set_charset($con, 'utf8mb4');
?>
