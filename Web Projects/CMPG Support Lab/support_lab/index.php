<?php
//header('Location: views/searchStudent.php'); 
if (isset($_SESSION['user_id'])) {
    header('Location: ../views/searchStudent.php'); // Redirigir al usuario a una página de inicio si ya ha iniciado sesión
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Lab</title>
    <link rel="icon" type="image/x-icon" href="images/icon.png">
    <link rel="stylesheet" href="styles/loginStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css" integrity="sha512-OQDNdI5rpnZ0BRhhJc+btbbtnxaj+LdQFeh0V9/igiEPDiWE2fG+ZsXl0JEH+bjXKPJ3zcXqNyP4/F/NegVdZg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <img src="images/logo.png" alt="Login Image" class="login-image">
            <form class="login-form" id="loginForm" method="POST">
                <label for="user-id">ID</label>
                <input type="text" id="user-id" name="user-id" required autocomplete="off">

                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input type="password" id="password" name="password" required>
                    <i class="ri-eye-off-line login-eye" id="login-eye"></i>
                </div>

                <br>
                <button type="submit">LOGIN</button>
            </form>
            <div id="errorMessage"></div>
        </div>
    </div>
    <script src="js/login.js"></script>
</body>

</html>