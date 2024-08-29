<?php
require_once 'config.php'; // Asegúrate de incluir tu script de conexión a la base de datos

// Asegurarse de que los datos necesarios se han enviado
if (!isset($_POST['student_id']) || !isset($_POST['workshop_id'])) {
    echo json_encode(['success' => false, 'message' => 'Student ID and Workshop ID are required.']);
    exit;
}

$student_id = $_POST['student_id'];
$workshop_id = $_POST['workshop_id'];

try {
    // Preparar la consulta SQL para insertar el nuevo registro de asistencia
    $query = "INSERT INTO workshop_attendance (student_id, workshop_id) VALUES (:student_id, :workshop_id)";

    // Preparar la sentencia
    $stmt = $conn->prepare($query);

    // Vincular los parámetros a la sentencia
    $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
    $stmt->bindParam(':workshop_id', $workshop_id, PDO::PARAM_INT);

    // Ejecutar la sentencia
    $stmt->execute();

    // Verificar si se insertó el registro correctamente
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Attendance record added successfully.']);
    } else {
        // Si no se insertaron filas, podría ser un indicador de un problema
        echo json_encode(['success' => false, 'message' => 'Failed to add attendance record.']);
    }
} catch (PDOException $e) {
    // Manejar cualquier error que ocurra durante el proceso
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
}

// Cerrar la conexión
$conn = null;
