<?php require_once "../includes/header.php"; ?>

<div class="content-wrapper-reports">

    <section class="student-report">
        <h1>REPORTS</h1>
        <button class="report-button" onclick="fetchStudentsAndGenerateExcel()">Generate Student Report</button>
        <div class="workshop-report">
            <h2>Workshop Reports</h2>
            <select id="workshopSelector">

            </select>
            <button class="report-button" onclick="fetchWorkshopAttendanceAndGenerateExcel()">Generate Workshop Report</button>
        </div>
    </section>





</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
<script src="../js/reports.js"></script>

<?php require_once "../includes/footer.php"; ?>