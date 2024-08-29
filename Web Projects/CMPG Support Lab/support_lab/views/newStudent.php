<?php require_once "../includes/header.php"; ?>

<div class="content-wrapper-add-students">

    <form id="addStudentForm">
        <h2>Add New Student</h2>
        Student ID: <input type="number" name="student_id" required autocomplete="off"><br>
        Name: <input type="text" name="student_name" required autocomplete="off"><br>
        <!-- Cambio aquí para usar un selector -->
        Assistant ID:
        <select name="assistant_id" required>
            <!-- Las opciones se cargarán dinámicamente con JavaScript -->
        </select><br>
        Initial Level: <input type="number" name="level" required autocomplete="off"><br>
        Initial Comment: <textarea name="initial_comment" required rows="4" cols="50" autocomplete="off"></textarea><br>
        <button type="submit">Add</button>
    </form>

</div>

<script src="../js/addStudent.js"></script>

<?php require_once "../includes/footer.php"; ?>