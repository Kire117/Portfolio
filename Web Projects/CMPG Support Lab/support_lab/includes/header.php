<!DOCTYPE html>
<html lang="en">

<?php
// Iniciar sesión al principio del script
session_start();

// Verificar si la sesión con 'user_id' no está establecida
if (!isset($_SESSION['user_id'])) {
    // Redirigir al usuario a la página de inicio (index.php) si no ha iniciado sesión
    header('Location: ../index.php');
    exit;
}
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Lab</title>
    <link rel="icon" type="image/x-icon" href="../images/icon.png">
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
</head>

<body>
    <!------------------HEADER SECTION---------------------->
    <section class="header">
        <nav>
            <a href="index.html"><img src="../images/logo.png"></a>
            <div class="nav-links" id="navLinks">
                <i class="fa-solid fa-xmark" onclick="hideMenu()"></i>
                <ul>

                    <li><a href="searchStudent.php">STUDENT INFO</a></li>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'superuser') : ?>
                        <li><a href="assistants.php">ASSISTANTS</a></li>
                        <li><a href="workshops.php">WORKSHOPS</a></li>
                        <li><a href="reports.php">REPORTS</a></li>
                    <?php endif; ?>
                    <li><a href="newStudent.php">ADD STUDENT</a></li>
                    <li><a href="students.php">STUDENTS</a></li>
                    <li><a href="../includes/logout.php">LOGOUT</a></li>
                    
                </ul>
            </div>
            <i class="fa-solid fa-bars" onclick="showMenu()"></i>
        </nav>

    </section>