<?php
// Incluir el archivo de configuración de la base de datos
require_once 'config.php'; // Asegúrate de que la ruta sea correcta

// Preparar la respuesta como un array que será convertido a JSON
$response = ['success' => false, 'message' => 'Operation not completed'];

// Verificar si los campos necesarios están presentes
if (isset($_POST['assistant_id']) && isset($_POST['name']) && isset($_POST['password'])) {
    $assistant_id = $_POST['assistant_id'];
    $name = $_POST['name'];
    $password = $_POST['password'];

    // Hashear la contraseña antes de almacenarla en la base de datos
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Preparar la sentencia SQL para insertar el nuevo asistente
    $sql = "INSERT INTO assistants (assistant_id, name, password) VALUES (:assistant_id, :name, :password)";

    try {
        // Preparar la sentencia
        $stmt = $conn->prepare($sql);

        // Vincular los parámetros a la sentencia
        $stmt->bindParam(':assistant_id', $assistant_id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR); // Vincular la contraseña hasheada

        // Ejecutar la sentencia
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'New assistant added successfully.';
        } else {
            // Manejar el caso en que la ejecución de la sentencia no fue exitosa
            $response['message'] = 'The assistant could not be added.';
        }
    } catch (PDOException $e) {
        // Manejar cualquier excepción o error que ocurra durante el proceso
        $response['message'] = "Error adding assistant: " . $e->getMessage();
    }

    // Cerrar la conexión
    $conn = null;
} else {
    // Manejar el caso en que no se recibieron los datos necesarios
    $response['message'] = 'Necessary data is missing.';
}

// Devolver la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);
