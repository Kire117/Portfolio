<?php
require_once 'config.php'; 
header('Content-Type: application/json');

try {
   
    $query = "SELECT * FROM students";
    $stmt = $conn->prepare($query);
    
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($results) {
        echo json_encode($results);
    } else{
        echo json_encode([]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => "Database error: " . $e->getMessage()]);
}

?>