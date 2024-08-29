<?php
// Incluir el archivo de configuración de la base de datos
require_once 'config.php'; // Asegúrate de que la ruta sea correcta

header('Content-Type: application/json');

try {
    // Preparar la sentencia SQL para seleccionar solo los asistentes con rol "assistant"
    $sql = "SELECT assistant_id, name FROM assistants WHERE role = 'assistant' ORDER BY name ASC";
    $stmt = $conn->prepare($sql);

    // Ejecutar la sentencia
    $stmt->execute();

    // Verificar si se encontraron asistentes
    if ($stmt->rowCount() > 0) {
        $assistants = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $assistants[] = $row;
        }

        // Devolver los resultados en formato JSON
        echo json_encode($assistants);
    } else {
        // En caso de que no haya asistentes con el rol especificado, devolver un arreglo vacío
        echo json_encode([]);
    }
} catch (PDOException $e) {
    // En caso de error, devolver el mensaje de error en formato JSON
    echo json_encode(["error" => $e]);
}

//Cerrar la conexión
$conn = null;
?>
