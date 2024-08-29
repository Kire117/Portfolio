<?php
require_once 'config.php'; 
header('Content-Type: application/json');

$workshopId = isset($_GET['workshopId']) ? $_GET['workshopId'] : '';

try {
    // Primero, obtenemos el título del workshop por separado para no repetirlo por cada estudiante
    $workshopQuery = "SELECT workshop_title FROM workshops WHERE workshop_id = :workshopId";
    $workshopStmt = $conn->prepare($workshopQuery);
    $workshopStmt->bindParam(':workshopId', $workshopId, PDO::PARAM_INT);
    $workshopStmt->execute();
    $workshopTitleResult = $workshopStmt->fetch(PDO::FETCH_ASSOC);
    $workshopTitle = $workshopTitleResult['workshop_title'];
    
    // Luego, obtenemos todos los estudiantes que asistieron al workshop
    $attendanceQuery = "SELECT s.student_id, s.student_name, 
                        CONCAT(s.student_id, '@student.georgianc.on.ca') as student_email
                        FROM workshop_attendance wa
                        JOIN students s ON wa.student_id = s.student_id
                        WHERE wa.workshop_id = :workshopId";
                        
    $attendanceStmt = $conn->prepare($attendanceQuery);
    $attendanceStmt->bindParam(':workshopId', $workshopId, PDO::PARAM_INT);
    $attendanceStmt->execute();
    $attendanceResults = $attendanceStmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Empaquetamos tanto el título del workshop como los resultados de asistencia en un solo JSON
    $response = [
        "workshop_title" => $workshopTitle,
        "attendance" => $attendanceResults
    ];

    echo json_encode($response);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => "Database error: " . $e->getMessage()]);
}
?>
