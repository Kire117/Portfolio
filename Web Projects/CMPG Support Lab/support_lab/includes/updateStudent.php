<?php
require_once 'config.php'; // Asegúrate de que incluyes tu script de conexión a la base de datos

header('Content-Type: application/json');

// Recibe la entrada RAW del body de la solicitud
$input = json_decode(file_get_contents('php://input'), true);

// Verificar si todos los campos necesarios están presentes en el JSON recibido
if (isset($input['student_id'], $input['student_name'], $input['assistant_id'], $input['initial_level'], $input['current_level'], $input['initial_comment'], $input['strikes'])) {
    $student_id = $input['student_id'];
    $student_name = $input['student_name'];
    $assistant_id = $input['assistant_id'];
    $initial_level = $input['initial_level'];
    $current_level = $input['current_level'];
    $initial_comment = $input['initial_comment'];
    $progress = $current_level - $initial_level;
    $strikes = $input['strikes'];

    try {
        // Preparar la consulta SQL para actualizar la información del estudiante
        $query = "UPDATE students SET 
                  student_name = :student_name,
                  current_level = :current_level,
                  initial_comment = :initial_comment,
                  progress = :progress,
                  strikes = :strikes,
                  assistant_id = :assistant_id
                  WHERE student_id = :student_id";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->bindParam(':student_name', $student_name, PDO::PARAM_STR);
        $stmt->bindParam(':current_level', $current_level, PDO::PARAM_INT);
        $stmt->bindParam(':initial_comment', $initial_comment, PDO::PARAM_STR);
        $stmt->bindParam(':progress', $progress, PDO::PARAM_INT);
        $stmt->bindParam(':strikes', $strikes, PDO::PARAM_INT);
        $stmt->bindParam(':assistant_id', $assistant_id, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();

        // Verificar que se actualizó algún registro
        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Información del estudiante actualizada.']);
        } else {
            // Ningún registro fue actualizado. Esto también puede ocurrir si los datos son iguales.
            echo json_encode(['success' => false, 'message' => 'No se actualizó la información. Verifique que los datos sean diferentes.']);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    // No se proporcionaron todos los campos necesarios
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Faltan campos en la solicitud POST.']);
}

// Cierra la conexión a la base de datos
$conn = null;
