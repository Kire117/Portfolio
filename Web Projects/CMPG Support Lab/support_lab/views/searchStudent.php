<?php require_once "../includes/header.php"; ?>

<div class="content-wrapper-students-info">
    <!-- AQUI EL BUSCADOR -->
    <div class="student-search-form">
        <form id="searchStudentForm">
            <input type="text" id="studentIdInput" placeholder="Enter Student ID" autocomplete="off" require>
            <button type="submit">Search</button>
        </form>
    </div>

    <!-- AQUI APARECERA LA INFORMACION -->
    <div id="studentInfoDisplay"></div>

    <section id="workshopList" aria-labelledby="workshopListTitle">
        <div id="workshopTitleContainer" style="display: none;">
            <h2 id="workshopListTitle">Available Workshops</h2>
        </div>
        <form id="workshopAttendanceForm" aria-describedby="workshopListDesc">
            <p id="workshopListDesc" style="display: none;">Select a workshop to add attendance for today.</p>
            <!-- Los workshops disponibles se cargarán aquí -->
        </form>
    </section>


    <div id="newAttendanceRecord">
        <h3>Add Attendance Record</h3>
        <form id="addAttendanceForm">
            <label for="attendanceComment">Comment:</label>
            <textarea type="text" id="attendanceComment" name="comment" placeholder="Enter comment" required rows="4" cols="50" autocomplete="off"></textarea>
            <button type="submit">Save</button>
        </form>
    </div>
    <script src="../js/showStudentById.js"></script>
</div>

<?php require_once "../includes/footer.php"; ?>