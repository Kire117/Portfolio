<?php
// Incluir el archivo de configuración de la base de datos
require_once 'config.php'; // Asegúrate de que la ruta sea correcta

$response = ['success' => false, 'message' => ''];

// Verificar si el parámetro POST existe
if(isset($_POST['assistant_id'])) {
    $assistant_id = $_POST['assistant_id'];

    // Preparar la sentencia SQL para eliminar el asistente
    $sql = "DELETE FROM assistants WHERE assistant_id = :assistant_id";

    try {
        // Preparar la sentencia
        $stmt = $conn->prepare($sql);

        // Vincular el parámetro a la sentencia
        $stmt->bindParam(':assistant_id', $assistant_id, PDO::PARAM_INT);

        // Ejecutar la sentencia
        $stmt->execute();

        // Verificar si se eliminó alguna fila
        if($stmt->rowCount() > 0) {
            $response['success'] = true;
            $response['message'] = "Successfully removed assistant.";
        } else {
            $response['message'] = "The assistant with that ID was not found.";
        }
    } catch(PDOException $e) {
        $response['message'] = "Failed to delete assistant: " . $e->getMessage();
    }
} else {
    $response['message'] = "Error: Missing parameters.";
}

// Cerrar la conexión
$conn = null;

header('Content-Type: application/json');
echo json_encode($response);
?>
