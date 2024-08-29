document.addEventListener('DOMContentLoaded', function () {
    loadAssistantsIntoSelector().then(() => {
        const assistantSelector = document.querySelector('[name="assistant_id"]');
        if (assistantSelector.options.length === 0) {
            alert('No assistants available. Cannot add a student.');
            return; // No continuar si no hay asistentes disponibles
        }
    });

    const addForm = document.getElementById('addStudentForm');
    addForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const studentIdValue = document.querySelector('[name="student_id"]').value;
        if (studentIdValue.length === 9 && /^\d{9}$/.test(studentIdValue)) {
            let formData = new FormData(addForm);

            // Convertir FormData a un objeto JavaScript para visualización
            formDataToObject(formData).then(formObject => {
                console.log('Data being sent to PHP:', formObject);
            });

            fetch('../includes/addStudent.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log(data);
                        alert('Student added successfully!');
                        clearFormFields();
                    } else {
                        throw new Error(data.error);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to add student. Please check the console for more information.');
                });
        } else {
            alert('The Student ID must be exactly 9 digits.');
        }
    });
});

function loadAssistantsIntoSelector() {
    return fetch('../includes/getAssistants.php')
        .then(response => response.json())
        .then(data => {
            const assistantSelector = document.querySelector('[name="assistant_id"]');
            assistantSelector.innerHTML = '';
            data.forEach(assistant => {
                let option = document.createElement('option');
                option.value = assistant.assistant_id;
                option.textContent = assistant.name;
                assistantSelector.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to load assistants.');
        });
}


// Función para convertir FormData a un objeto JavaScript
function formDataToObject(formData) {
    return new Promise(resolve => {
        const object = {};
        formData.forEach((value, key) => {
            // Considerar la posibilidad de arrays para campos con el mismo nombre
            if (!Reflect.has(object, key)) {
                object[key] = value;
                return;
            }
            if (!Array.isArray(object[key])) {
                object[key] = [object[key]];
            }
            object[key].push(value);
        });
        resolve(object);
    });
}

function clearFormFields() {
    document.querySelector('[name="student_id"]').value = '';
    document.querySelector('[name="student_name"]').value = '';
    document.querySelector('[name="assistant_id"]').selectedIndex = 0; // Resetea el selector a su primera opción
    document.querySelector('[name="level"]').value = '';
    document.querySelector('[name="initial_comment"]').value = '';
}
