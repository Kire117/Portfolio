<?php
require_once 'config.php'; // Asegúrate de incluir tu script de conexión a la base de datos

header('Content-Type: application/json');

// Asegurarse de que se proporcionó un ID de estudiante
if (!isset($_GET['student_id']) || empty($_GET['student_id'])) {
    echo json_encode(["error" => "Student ID is required."]);
    exit;
}

$student_id = $_GET['student_id'];

try {
    // Seleccionar todos los workshops a los que el estudiante no ha asistido
    $query = "SELECT w.workshop_id, w.workshop_title, w.date
              FROM workshops w
              WHERE w.workshop_id NOT IN (
                  SELECT wa.workshop_id
                  FROM workshop_attendance wa
                  WHERE wa.student_id = :student_id
              )
              AND w.date = CURDATE()";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
    $stmt->execute();

    $workshops = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($workshops);
} catch (PDOException $e) {
    // En caso de un error con la base de datos, devolver un mensaje de error
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}

$conn = null; 
