<?php require_once "../includes/header.php"; ?>

<div class="content-wrapper-workshops">

    <div class="add-workshop-form">
        <form id="newWorkshopForm">
            <h2>Add New Workshop</h2>
            <div class="form-group">
                <label for="workshopTitle">Title:</label>
                <input type="text" id="workshopTitle" name="workshop_title" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="workshopDate">Date:</label>
                <input type="date" id="workshopDate" name="workshop_date" required>
            </div>
            <div class="form-group">
                <label for="workshopDescription">Description:</label>
                <textarea id="workshopDescription" name="workshop_description" rows="4" cols="50" required></textarea>
            </div>
            <button type="submit" class="btn">Add Workshop</button>
        </form>
    </div>

    <table id="workshops-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Date</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Workshops will be loaded here -->
        </tbody>
    </table>

</div>

<script src="../js/workshops.js"></script>

<?php require_once "../includes/footer.php"; ?>