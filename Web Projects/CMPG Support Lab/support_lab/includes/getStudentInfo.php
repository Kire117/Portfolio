<?php
require_once 'config.php'; // Asegúrate de que incluyes tu script de conexión a la base de datos

header('Content-Type: application/json');

// Verifica si el ID del estudiante fue enviado a través de GET
if (isset($_GET['student_id']) && !empty($_GET['student_id'])) {
    $student_id = $_GET['student_id'];

    try {
        // Prepara la consulta SQL para obtener la información del estudiante
        $query = "SELECT s.*, a.name as assistant_name 
                  FROM students s 
                  LEFT JOIN assistants a ON s.assistant_id = a.assistant_id 
                  WHERE s.student_id = :student_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->execute();

        // Verifica si se encontró el estudiante
        if ($stmt->rowCount() == 1) {
            $student = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode(['success' => true, 'student' => $student]);
        } else {
            // No se encontró un estudiante con ese ID
            echo json_encode(['success' => false, 'message' => 'Estudiante no encontrado.']);
        }
    } catch (PDOException $e) {
        // Error de la base de datos
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    // No se proporcionó un ID de estudiante
    echo json_encode(['success' => false, 'message' => 'Falta el ID del estudiante.']);
}

// Cierra la conexión a la base de datos
$conn = null;

//http://localhost/support_lab/includes/getStudentInfo.php?student_id=200547896