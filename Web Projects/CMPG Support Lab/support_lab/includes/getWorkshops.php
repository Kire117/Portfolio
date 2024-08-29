<?php
require_once 'config.php'; // Make sure to include your database connection script

header('Content-Type: application/json');

try {
    // Assuming you have a PDO connection in config.php
    $query = "SELECT * FROM workshops";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $workshops = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //echo json_encode(['success' => true, 'workshops' => $workshops]);
    echo json_encode($workshops);
} catch (PDOException $e) {
    // Handle error
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
}

// Close database connection
$conn = null;
