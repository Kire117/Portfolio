<?php
session_start();
require_once 'config.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user-id']) && isset($_POST['password'])) {
    $userId = $_POST['user-id'];
    $password = $_POST['password'];

    $sql = "SELECT assistant_id, password, role FROM assistants WHERE assistant_id = :userId";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            if ($row = $stmt->fetch()) {
                if (password_verify($password, $row['password'])) {
                    $_SESSION['user_id'] = $row['assistant_id'];
                    $_SESSION['role'] = $row['role'];
                    $response['success'] = true;
                } else {
                    $response['message'] = 'La contraseña ingresada es incorrecta.';
                }
            }
        } else {
            $response['message'] = 'No existe una cuenta para este ID.';
        }
    } catch (PDOException $e) {
        $response['message'] = "Error de conexión a la base de datos.";
    }
} else {
    $response['message'] = 'Datos incompletos.';
}

echo json_encode($response);
