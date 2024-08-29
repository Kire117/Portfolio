<?php
require_once 'config.php'; // Asegúrate de que incluyes tu script de conexión a la base de datos

header('Content-Type: application/json');

// Decodificar JSON recibido
$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['student_id'], $input['comment'])) {
    $student_id = $input['student_id'];
    $comment = $input['comment'];
    $date = date('Y-m-d'); // La fecha de hoy

    try {
        $sql = "INSERT INTO lab_attendance_records (student_id, date, comment) VALUES (:student_id, :date, :comment)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->execute();

        echo json_encode(['success' => true, 'message' => 'Attendance record added successfully.']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing student ID or comment.']);
}

$conn = null;
