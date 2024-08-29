<?php
require_once 'config.php'; 

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $workshopId = isset($_POST['workshop_id']) ? $_POST['workshop_id'] : '';

    if (empty($workshopId)) {
        echo json_encode(['success' => false, 'message' => 'Workshop ID is required.']);
        exit;
    }

    try {
        // Inicia una transacción
        $conn->beginTransaction();

        // Primero, eliminar todas las asistencias relacionadas con el workshop
        $stmt = $conn->prepare("DELETE FROM workshop_attendance WHERE workshop_id = :workshop_id");
        $stmt->bindParam(':workshop_id', $workshopId);
        $stmt->execute();

        // Luego, eliminar el workshop
        $stmt = $conn->prepare("DELETE FROM workshops WHERE workshop_id = :workshop_id");
        $stmt->bindParam(':workshop_id', $workshopId);
        $stmt->execute();

        // Si todo fue bien, hacer commit de la transacción
        $conn->commit();

        echo json_encode(['success' => true, 'message' => 'Workshop and related attendances deleted successfully.']);
    } catch (PDOException $e) {
        // Si algo va mal, hacer rollback de la transacción
        $conn->rollBack();
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
    }

    // Cerrar conexión a la base de datos
    $conn = null;
} else {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
