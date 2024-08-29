<?php
require_once 'config.php'; // Asegúrate de que incluyes tu script de conexión a la base de datos

$studentId = $_GET['studentId'] ?? '';

// Preparar y ejecutar la consulta
$query = "SELECT * FROM students WHERE student_id = :studentId";
$stmt = $conn->prepare($query);
$stmt->bindParam(':studentId', $studentId, PDO::PARAM_INT);
$stmt->execute();

$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Devolver los resultados en formato JSON
echo json_encode($students);
