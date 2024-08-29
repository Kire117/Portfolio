<?php
require_once 'config.php';

$response = ['success' => false, 'message' => 'Operation not completed'];

$assistant_id = "987654321";
$name = "Nathan"; // Cambiar por el nombre del superusuario
$password = "12QW45er"; // Cambiar por una contraseña segura
$role = "superuser"; // Este valor debe coincidir con la lógica de roles en tu base de datos

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO assistants (assistant_id, name, password, role) VALUES (:assistant_id, :name, :password, :role)";

try {
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':assistant_id', $assistant_id, PDO::PARAM_INT);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
    $stmt->bindParam(':role', $role, PDO::PARAM_STR);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Superuser added successfully.';
    } else {
        $response['message'] = 'The superuser could not be added.';
    }
} catch (PDOException $e) {
    $response['message'] = "Error adding superuser: " . $e->getMessage();
}

$conn = null;

header('Content-Type: application/json');
echo json_encode($response);
?>
