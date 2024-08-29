// Al cargar la página, llenamos el selector con los workshops disponibles
document.addEventListener('DOMContentLoaded', function () {
    fetch('../includes/getWorkshops.php')
        .then(response => response.json())
        .then(data => {
            const selector = document.getElementById('workshopSelector');
            data.forEach(workshop => {
                let option = new Option(workshop.workshop_title, workshop.workshop_id);
                selector.add(option);
            });
        })
        .catch(error => console.error('Error fetching workshops:', error));
});

// Esta función se llamará cuando quieras generar el reporte de todos los estudiantes
function fetchStudentsAndGenerateExcel() {
    fetch('../includes/getStudents.php') // Ajusta la ruta al script PHP
        .then(response => response.json())
        .then(data => {
            // Una vez que tenemos los datos, llamamos a la función para generar el Excel
            generateExcelStudentReport(data);
        })
        .catch(error => {
            console.error('Error fetching the students:', error);
        });
}

// Esta función toma los datos y los utiliza para generar un archivo Excel
function generateExcelStudentReport(data) {
    // Crear un nuevo libro de trabajo
    var wb = XLSX.utils.book_new();

    // Convierte los datos a hoja de trabajo
    var ws = XLSX.utils.json_to_sheet(data);

    // Añadir la hoja de trabajo al libro con un nombre específico
    XLSX.utils.book_append_sheet(wb, ws, "StudentsReport");

    // Calcular el progreso total y crear un nuevo sheet para esto
    let averageProgress = calculateTotalProgress(data);
    var progressSheet = XLSX.utils.json_to_sheet([{ "Total Progress": averageProgress }]);
    XLSX.utils.book_append_sheet(wb, progressSheet, "TotalProgress");

    // Añadir la fecha actual al nombre del archivo
    let currentDate = new Date().toISOString().slice(0, 10); // Formato AAAA-MM-DD
    XLSX.writeFile(wb, `StudentsReport-${currentDate}.xlsx`);
}

function calculateTotalProgress(data) {
    // Calcula el progreso total de todos los estudiantes
    let totalProgress = data.reduce((acc, current) => acc + current.progress, 0);
    return totalProgress;
}

function generateExcelWorkshopReport(data) {
    // Usar el título del workshop para el nombre del archivo
    const workshopTitle = data.workshop_title;
    const formattedData = data.attendance.map(student => ({
        "Student ID": student.student_id,
        "Student Name": student.student_name,
        "Student Email": student.student_email
    }));

    // Crear un nuevo libro de trabajo y añadir los datos de los estudiantes
    var wb = XLSX.utils.book_new();
    var ws = XLSX.utils.json_to_sheet(formattedData);
    XLSX.utils.book_append_sheet(wb, ws, "Workshop Attendance");

    // Reemplaza caracteres no permitidos en nombres de archivo
    const fileName = workshopTitle.replace(/[/\\?%*:|"<>]/g, '') + ".xlsx";

    // Generar un archivo Excel con el título del workshop como nombre de archivo
    XLSX.writeFile(wb, fileName);
}


function fetchWorkshopAttendanceAndGenerateExcel() {
    let workshopId = document.getElementById('workshopSelector').value;
    fetch(`../includes/getWorkshopAttendance.php?workshopId=${workshopId}`)
        .then(response => response.json())
        .then(data => {
            if (data && data.attendance.length > 0) {
                generateExcelWorkshopReport(data);
            } else {
                console.error('No data found for the selected workshop or no attendance data.');
            }
        })
        .catch(error => {
            console.error('Error fetching workshop attendance:', error);
        });
}

