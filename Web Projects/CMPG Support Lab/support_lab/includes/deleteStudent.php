<?php
require_once 'config.php'; // Asume que tienes un archivo config.php con la conexión a la base de datos

$input = json_decode(file_get_contents('php://input'), true);
$studentId = isset($input['student_id']) ? $input['student_id'] : '';

if (!$studentId) {
    echo json_encode(['success' => false, 'message' => 'Student ID is required']);
    exit;
}

try {
    // Iniciar transacción
    $conn->beginTransaction();

    // Eliminar registros de asistencia al laboratorio
    $stmt = $conn->prepare("DELETE FROM lab_attendance_records WHERE student_id = :studentId");
    $stmt->execute([':studentId' => $studentId]);

    // Eliminar asistencias a workshops
    $stmt = $conn->prepare("DELETE FROM workshop_attendance WHERE student_id = :studentId");
    $stmt->execute([':studentId' => $studentId]);

    // Eliminar estudiante
    $stmt = $conn->prepare("DELETE FROM students WHERE student_id = :studentId");
    $stmt->execute([':studentId' => $studentId]);

    // Confirmar transacción
    $conn->commit();

    echo json_encode(['success' => true, 'message' => 'Student and related records deleted successfully']);
} catch (Exception $e) {
    // En caso de error, revertir cambios
    $conn->rollBack();
    echo json_encode(['success' => false, 'message' => 'Error deleting student: ' . $e->getMessage()]);
}
