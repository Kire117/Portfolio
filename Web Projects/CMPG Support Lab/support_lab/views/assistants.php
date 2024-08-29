<?php require_once "../includes/header.php"; ?>

<div class="content-wrapper-assitants">

    <form id="addAssistantForm">
        <h2>Add New Assistant</h2>
        Assistant ID: <input type="number" name="assistant_id" required autocomplete="off"><br>
        Name: <input type="text" name="name" required autocomplete="off"><br>
        Password: <input type="password" name="password" required autocomplete="off"><br>
        <button type="submit">Add</button>
    </form>
    
    <table id="assistantsTable">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Los datos de los asistentes se llenarán aquí usando JavaScript -->
        </tbody>
    </table>
    
</div>

<script src="../js/assistants.js"></script>

<?php require_once "../includes/footer.php"; ?>