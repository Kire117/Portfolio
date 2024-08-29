<?php
require_once 'config.php'; // Make sure to include your database connection script

header('Content-Type: application/json');

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Extract workshop details from POST data
    $title = isset($_POST['workshop_title']) ? $_POST['workshop_title'] : '';
    $date = isset($_POST['workshop_date']) ? $_POST['workshop_date'] : '';
    $description = isset($_POST['workshop_description']) ? $_POST['workshop_description'] : '';

    // Validate input data
    if (empty($title) || empty($date)) {
        // Missing required fields
        echo json_encode(['success' => false, 'message' => 'Title and date are required.']);
        exit;
    }

    try {
        // Prepare SQL statement to insert the new workshop
        $query = "INSERT INTO workshops (workshop_title, date, description) VALUES (:workshop_title, :date, :description)";
        $stmt = $conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':workshop_title', $title);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':description', $description);

        // Execute the statement
        $stmt->execute();

        // Check if the insert was successful
        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Workshop added successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add workshop.']);
        }
    } catch (PDOException $e) {
        // Database error
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    // Not a POST request
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

// Close database connection
$conn = null;
