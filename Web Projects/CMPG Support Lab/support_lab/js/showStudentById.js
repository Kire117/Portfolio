document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('newAttendanceRecord').style.display = 'none';

    document.getElementById('searchStudentForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const studentId = document.getElementById('studentIdInput').value;
        if (studentId) {
            fetchStudentInfo(studentId);
        }
    });

    document.getElementById('addAttendanceForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const comment = document.getElementById('attendanceComment').value;
        const studentId = document.getElementById('studentIdInput').value;
        addAttendanceRecord(studentId, comment);
    });
});

function fetchStudentInfo(studentId) {
    fetch(`../includes/getStudentById.php?student_id=${studentId}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                document.getElementById('studentInfoDisplay').innerHTML = `<p>${data.error}</p>`;
                document.getElementById('newAttendanceRecord').style.display = 'none';
            } else {
                displayStudentInfo(data);
                document.getElementById('newAttendanceRecord').style.display = 'block';
                loadAvailableWorkshops(studentId);
            }
        })
        .catch(error => {
            console.error('Error fetching student information.', error);
            document.getElementById('studentInfoDisplay').innerHTML = `<p>Error fetching student information.</p>`;
            document.getElementById('newAttendanceRecord').style.display = 'none';
        });
}

function displayStudentInfo(data) {
    let displayHtml = `<h3>Student Information</h3><table>`;
    displayHtml += `<tr><td><strong>Name</strong></td><td>${data.details.student_name}</td></tr>`;
    displayHtml += `<tr><td><strong>Email</strong></td><td id="emailDetailCopy">${data.details.student_id}@student.georgianc.on.ca<span class="copyEmail" onclick="copyEmailToClipboard('${data.details.student_id}@student.georgianc.on.ca')" title="Copy to clipboard">📋</span></td></tr>`;
    displayHtml += `<tr><td><strong>Assistant Name</strong></td><td>${data.details.assistant_name}</td></tr>`;
    displayHtml += `<tr><td><strong>Initial Level</strong></td><td>${data.details.initial_level}</td></tr>`;
    displayHtml += `<tr><td><strong>Current Level</strong></td><td>${data.details.current_level}</td></tr>`;
    displayHtml += `<tr><td><strong>Creation Date</strong></td><td>${data.details.creation_date}</td></tr>`;
    displayHtml += `<tr><td><strong>Initial Comment</strong></td><td>${data.details.initial_comment}</td></tr>`;
    displayHtml += `<tr><td><strong>Progress</strong></td><td>${data.details.progress}</td></tr>`;
    displayHtml += `<tr><td><strong>Strikes</strong></td><td>${data.details.strikes}</td></tr></table>`;
    displayHtml += `<h3>Workshops Attended</h3><table>`;
    data.workshops.forEach(workshop => {
        displayHtml += `<tr><td>${workshop.workshop_title}</td></tr>`;
    });
    displayHtml += `</table><h3>Lab Attendance Records</h3><table>`;
    data.labAttendance.forEach(record => {
        displayHtml += `<tr><td>${record.date}</td><td>${record.comment}</td></tr>`;
    });
    displayHtml += `</table>`;
    document.getElementById('studentInfoDisplay').innerHTML = displayHtml;
}

function copyEmailToClipboard(email) {
    const textArea = document.createElement("textarea");
    textArea.value = email;
    textArea.style.position = "fixed";
    textArea.style.left = "-9999px";
    document.body.appendChild(textArea);
    textArea.select();
    document.execCommand("copy");
    document.body.removeChild(textArea);
}


function loadAvailableWorkshops(studentId) {
    fetch(`../includes/getAvailableWorkshops.php?student_id=${studentId}`)
        .then(response => response.json())
        .then(workshops => {
            const form = document.getElementById('workshopAttendanceForm');
            const titleContainer = document.getElementById('workshopTitleContainer');
            form.innerHTML = '';
            if (workshops.length > 0) {
                titleContainer.style.display = 'block';
                workshops.forEach(workshop => {
                    const workshopInfo = document.createElement('div');
                    workshopInfo.textContent = workshop.workshop_title;
                    form.appendChild(workshopInfo);

                    const button = document.createElement('button');
                    button.textContent = "Add Attendance";
                    button.type = 'button';
                    button.onclick = function () { addWorkshopAttendance(studentId, workshop.workshop_id); };
                    form.appendChild(button);
                    form.appendChild(document.createElement('br'));
                });
            } else {
                titleContainer.style.display = 'none';
            }
        })
        .catch(error => console.error('Error loading workshops:', error));
}

function addWorkshopAttendance(studentId, workshopId) {
    fetch('../includes/addWorkshopAttendance.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `student_id=${studentId}&workshop_id=${workshopId}`
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Attendance added successfully.');
                fetchStudentInfo(studentId); // Recargar la información del estudiante
            } else {
                alert('Failed to add attendance.');
            }
        })
        .catch(error => {
            console.error('Error adding workshop attendance:', error);
            alert('Error adding workshop attendance. Please try again.');
        });
}

function addAttendanceRecord(studentId, comment) {
    fetch('../includes/addAttendanceRecord.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ student_id: studentId, comment: comment })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Attendance record added.');
                document.getElementById('attendanceComment').value = ""; // Limpiar el campo de comentario
                fetchStudentInfo(studentId); // Recargar la información del estudiante
            } else {
                alert('Error adding attendance record.');
            }
        })
        .catch(error => {
            console.error('Error adding attendance record:', error);
            alert('Error adding attendance record. Please try again.');
        });
}
