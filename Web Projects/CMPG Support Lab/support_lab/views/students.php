<?php require_once "../includes/header.php"; ?>

<div class="content-wrapper-students">

    <div class="filter-container">
        <label for="studentIdFilter">Student ID:</label>
        <input type="text" id="studentIdFilter" placeholder="Enter Student ID">
    </div>

    <div class="filter-container">
        <label for="assistantFilter">Assistant:</label>
        <select id="assistantFilter">
            <option value="">Select Assistant</option>
        </select>
    </div>

    <table id="students-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Level</th>
                <th>First visit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

    <div id="studentModal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <form id="studentForm">
                <label for="studentId">Student ID:</label>
                <input type="text" id="studentId" name="student_id" disabled>

                <label for="studentName">Name:</label>
                <input type="text" id="studentName" name="student_name" autocomplete="off" required placeholder="Student name">

                <label for="assistantId">Assistant:</label>
                <select id="assistantId" name="assistant_id" required>
                </select>

                <label for="initialLevel">Initial Level:</label>
                <input type="number" id="initialLevel" name="initialLevel" disabled>

                <label for="currentLevel">Current Level:</label>
                <input type="number" id="currentLevel" name="current_level" autocomplete="off" required placeholder="Current level">

                <label for="initialComment">Initial Comment:</label>
                <textarea id="initialComment" name="initial_comment" disabled></textarea>

                <label for="creationDate">Creation Date:</label>
                <input type="date" id="creationDate" name="creation_date" disabled>

                <label for="progress">Progress:</label>
                <input type="number" id="progress" name="progress" disabled>

                <label for="strikes">Strikes:</label>
                <input type="number" id="strikes" name="strikes" autocomplete="off" required placeholder="Strikes">

                <div class="form-actions">
                    <button type="button" class="cancel-button">Cancel</button>
                    <button type="submit" class="update-button">Update</button>
                </div>
            </form>
        </div>

    </div>


    <script src="../js/students.js"></script>
</div>

<?php require_once "../includes/footer.php"; ?>