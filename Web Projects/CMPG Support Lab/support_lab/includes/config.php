<?php
// Servidor donde se encuentra la base de datos
$servername = "localhost";
// Nombre de usuario de la base de datos
$username = "root";
// Contraseña de la base de datos
$password = "";
// Nombre de la base de datos
$dbname = "cmpg_support_lab";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES   => false,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_PERSISTENT         => true,
];

try {
    // Crear conexión PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, $options);
} catch (PDOException $e) {
    // Considerar loggear este error en lugar de mostrarlo directamente
    error_log('Error de conexión: ' . $e->getMessage());
    // En un entorno de producción, podrías querer mostrar un mensaje de error más genérico
    die("Error de conexión. Por favor, inténtelo más tarde.");
}
