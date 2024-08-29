<?php
require_once 'config.php'; // Incluye tu script de configuración con la conexión a la base de datos

header('Content-Type: application/json');

// Comprueba si se ha proporcionado un ID de asistente específico a través del método GET
$assistantId = isset($_GET['assistantId']) && !empty($_GET['assistantId']) ? $_GET['assistantId'] : null;

try {
    // Prepara la consulta SQL dependiendo de si se proporcionó un assistantId
    if ($assistantId) {
        $query = "SELECT * FROM students WHERE assistant_id = :assistantId ORDER BY student_name ASC";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':assistantId', $assistantId, PDO::PARAM_INT);
    } else {
        // Si no se proporciona assistantId, selecciona todos los estudiantes
        $query = "SELECT * FROM students";
        $stmt = $conn->prepare($query);
    }

    // Ejecuta la consulta preparada
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Verifica si se encontraron resultados
    if ($results) {
        echo json_encode($results);
    } else{
        echo json_encode([]);
    }
} catch (PDOException $e) {
    // Manejo de errores de la base de datos
    http_response_code(500);
    echo json_encode(["success" => false, "error" => "Database error: " . $e->getMessage()]);
}

// Cierra la conexión a la base de datos, si es necesario
// En PDO, la conexión se cierra automáticamente al finalizar el script
?>