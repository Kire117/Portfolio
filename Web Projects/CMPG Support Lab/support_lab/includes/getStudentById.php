<?php
// Incluir el archivo de configuración de la base de datos
require_once 'config.php'; // Asegúrate de que la ruta sea correcta

header('Content-Type: application/json');

// Verificar si se recibió el ID del estudiante via GET
if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];

    $student_id = $_GET['student_id'];
    
    if (!filter_var($student_id, FILTER_VALIDATE_INT)) {
        echo json_encode(["error" => "Invalid student ID."]);
        exit;
    }

    try {
        // Inicializar arreglo para almacenar toda la información
        $studentInfo = [];

        // Modificar la consulta para incluir un JOIN con la tabla assistants
        $sqlStudent = "SELECT s.student_id, s.student_name, s.assistant_id, a.name as assistant_name, s.initial_level, s.current_level, s.initial_comment, s.creation_date, s.progress, s.strikes FROM students s LEFT JOIN assistants a ON s.assistant_id = a.assistant_id WHERE s.student_id = :student_id";
        $stmtStudent = $conn->prepare($sqlStudent);
        $stmtStudent->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $stmtStudent->execute();

        if ($stmtStudent->rowCount() > 0) {
            $studentInfo['details'] = $stmtStudent->fetch(PDO::FETCH_ASSOC);
        } else {
            echo json_encode(["error" => "Student not found."]);
            exit;
        }

        // Luego, obtener los títulos de los workshops a los que ha asistido el estudiante
        $sqlWorkshops = "SELECT w.workshop_title FROM workshops w INNER JOIN workshop_attendance wa ON w.workshop_id = wa.workshop_id WHERE wa.student_id = :student_id";
        $stmtWorkshops = $conn->prepare($sqlWorkshops);
        $stmtWorkshops->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $stmtWorkshops->execute();

        $workshops = $stmtWorkshops->fetchAll(PDO::FETCH_ASSOC);
        $studentInfo['workshops'] = $workshops;

        // Ahora, obtener los registros de asistencia al laboratorio del estudiante
        $sqlLabAttendance = "SELECT record_id, date, comment FROM lab_attendance_records WHERE student_id = :student_id ORDER BY date DESC";
        $stmtLabAttendance = $conn->prepare($sqlLabAttendance);
        $stmtLabAttendance->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $stmtLabAttendance->execute();

        $labAttendanceRecords = $stmtLabAttendance->fetchAll(PDO::FETCH_ASSOC);
        $studentInfo['labAttendance'] = $labAttendanceRecords;

        // Devolver los resultados en formato JSON
        echo json_encode($studentInfo);
    } catch (PDOException $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }

    // Cerrar la conexión
    $conn = null;
} else {
    echo json_encode(["error" => "Falta el ID del estudiante."]);
}
