<?php
require_once 'config.php'; // Asegúrate de que la ruta sea correcta

header('Content-Type: application/json');

// Verifica que todos los campos necesarios estén presentes en la solicitud POST
if (isset($_POST['student_id']) && isset($_POST['student_name']) && isset($_POST['assistant_id']) && isset($_POST['level']) && isset($_POST['initial_comment'])) {
    $student_id = $_POST['student_id'];
    $student_name = $_POST['student_name'];
    $assistant_id = $_POST['assistant_id'];
    $initial_level = $_POST['level'];
    $current_level = $_POST['level'];
    $initial_comment = $_POST['initial_comment'];
    $creation_date = date('Y-m-d'); // Fecha de hoy
    $progress = 0; // Por defecto al agregar
    $strikes = 0; // Por defecto al agregar

    // Preparar la consulta SQL para insertar el nuevo estudiante
    $sql = "INSERT INTO students (student_id, student_name, assistant_id, initial_level, current_level, initial_comment, creation_date, progress, strikes) VALUES (:student_id, :student_name, :assistant_id, :initial_level, :current_level, :initial_comment, :creation_date, :progress, :strikes)";

    try {
        // Preparar y ejecutar la consulta
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->bindParam(':student_name', $student_name, PDO::PARAM_STR);
        $stmt->bindParam(':assistant_id', $assistant_id, PDO::PARAM_INT);
        $stmt->bindParam(':initial_level', $initial_level, PDO::PARAM_INT);
        $stmt->bindParam(':current_level', $current_level, PDO::PARAM_INT);
        $stmt->bindParam(':initial_comment', $initial_comment, PDO::PARAM_STR);
        $stmt->bindParam(':creation_date', $creation_date);
        $stmt->bindParam(':progress', $progress, PDO::PARAM_INT);
        $stmt->bindParam(':strikes', $strikes, PDO::PARAM_INT);
        $stmt->execute();

        // Si todo salió bien, enviar respuesta exitosa
        echo json_encode(["success" => true, "message" => "Nuevo estudiante agregado exitosamente."]);
    } catch (PDOException $e) {
        // En caso de error en la consulta, enviar respuesta con el error
        http_response_code(500);
        echo json_encode(["success" => false, "error" => "Error al agregar el estudiante: " . $e->getMessage()]);
    }
} else {
    // Si falta algún campo en la solicitud POST, enviar respuesta indicándolo
    http_response_code(400);
    echo json_encode(["success" => false, "error" => "Error: Faltan parámetros para agregar al estudiante."]);
}

// Cerrar la conexión a la base de datos
$conn = null;
