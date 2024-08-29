document.addEventListener('DOMContentLoaded', function () {
    loadAssistants();
    loadStudents();

    document.getElementById('assistantFilter').addEventListener('change', function () {
        loadStudents(this.value);
    });

    document.getElementById('studentIdFilter').addEventListener('input', function () {
        const studentId = document.getElementById('studentIdFilter').value;
        if (studentId.length === 9) {
            loadStudents(undefined, this.value);
            this.value = '';
        }
    });

    const studentsTable = document.getElementById('students-table');
    studentsTable.addEventListener('click', function (event) {
        // Asegurarse de que el clic es en una fila
        if (event.target.tagName === 'TD') {
            const row = event.target.parentNode;
            const email = row.cells[1].textContent;
            // Extrae solo los primeros 9 dígitos del studentId del correo electrónico
            const studentId = email.slice(0, 9);
            openModalWithStudentInfo(studentId);
        }
    });
});

function loadAssistants() {
    // Suponiendo que tienes un endpoint `/getAssistants`
    fetch('../includes/getAssistants.php')
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('assistantFilter');
            data.forEach(assistant => {
                let option = document.createElement('option');
                option.value = assistant.assistant_id;
                option.textContent = assistant.name;
                select.appendChild(option);
            });
        });
}

function loadStudents(assistantId = '', studentId = '') {
    let url = '../includes/getStudents.php';

    if (assistantId) {
        url = `../includes/getStudentsByAssistant.php?assistantId=${assistantId}`;
    } else if (studentId) {
        url = `../includes/getStudentByIdSearch.php?studentId=${studentId}`;
    }

    fetch(url)
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('students-table').getElementsByTagName('tbody')[0];
            tbody.innerHTML = ''; // Limpiar la tabla antes de añadir nuevos datos

            console.log(data);

            data.forEach(student => {
                let row = tbody.insertRow();
                row.insertCell(0).textContent = student.student_name;
                row.insertCell(1).textContent = student.student_id + "@student.georgianc.on.ca";
                row.insertCell(2).textContent = student.current_level;
                row.insertCell(3).textContent = student.creation_date;

                // Agregar botón de eliminar
                let deleteCell = row.insertCell(4);
                let deleteButton = document.createElement('button');
                deleteButton.textContent = 'Delete';
                deleteButton.onclick = function () { deleteStudent(student.student_id); };
                deleteCell.appendChild(deleteButton);
            });
        });
}


function deleteStudent(studentId) {
    console.log(studentId)//Hasta aqui si llega el student id
    if (confirm('Are you sure you want to delete this student and all related records?')) {
        fetch('../includes/deleteStudent.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ student_id: studentId })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Student deleted successfully.');
                    // Vuelve a cargar los estudiantes para actualizar la tabla
                    loadStudents();
                } else {
                    alert('Error deleting student: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while deleting the student.');
            });
    }
}

function openModalWithStudentInfo(studentId) {
    Promise.all([
        fetch(`../includes/getStudentInfo.php?student_id=${studentId}`).then(response => response.json()),
        fetch('../includes/getAssistants.php').then(response => response.json())
    ])
        .then(([studentData, assistantsData]) => {
            console.log(studentData)
            if (studentData.success) {
                const student = studentData.student;
                document.getElementById('studentId').value = student.student_id;
                document.getElementById('studentName').value = student.student_name;
                document.getElementById('initialLevel').value = student.initial_level;
                document.getElementById('currentLevel').value = student.current_level;
                document.getElementById('initialComment').value = student.initial_comment;
                document.getElementById('creationDate').value = student.creation_date;
                document.getElementById('progress').value = student.progress;
                document.getElementById('strikes').value = student.strikes;

                const assistantSelect = document.getElementById('assistantId');
                assistantSelect.innerHTML = ''; // Clear existing options
                assistantsData.forEach(assistant => {
                    const option = document.createElement('option');
                    option.value = assistant.assistant_id;
                    option.textContent = assistant.name;
                    assistantSelect.appendChild(option);
                });

                // Set the current assistant as selected
                assistantSelect.value = student.assistant_id;

                document.getElementById('studentModal').style.display = 'block';
            } else {
                throw new Error('Student information could not be loaded.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert(error.message);
        });
}

// Cerrar el modal
document.querySelector('.close-button').addEventListener('click', function () {
    document.getElementById('studentModal').style.display = 'none';
});

// Actualizar la información del estudiante
document.getElementById('studentForm').addEventListener('submit', function (event) {
    event.preventDefault();

    if (document.getElementById('initialLevel').value > document.getElementById('currentLevel').value) {
        alert('The current level cannot be lower than the initial level');
    } else {
        // Recolectar los datos del formulario
        // No incluimos assistant_id porque no se puede cambiar
        const studentData = {
            student_id: document.getElementById('studentId').value,
            student_name: document.getElementById('studentName').value,
            assistant_id: document.getElementById('assistantId').value,
            initial_level: document.getElementById('initialLevel').value,
            current_level: document.getElementById('currentLevel').value,
            initial_comment: document.getElementById('initialComment').value,
            progress: document.getElementById('progress').value,
            strikes: document.getElementById('strikes').value,
        };

        // Enviar los datos actualizados al servidor
        fetch('../includes/updateStudent.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(studentData)
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Updated student information.');
                    let filter = document.getElementById('assistantFilter').value;
                    loadStudents(filter);
                    // Recargar los estudiantes o actualizar la fila específica
                } else {
                    console.log(data)
                    alert('Error updating information.');
                }
                // Cerrar el modal
                document.getElementById('studentModal').style.display = 'none';
            });
    }
});

// Cancelar y cerrar el modal
document.querySelector('.cancel-button').addEventListener('click', function () {
    document.getElementById('studentModal').style.display = 'none';
});