document.addEventListener('DOMContentLoaded', () => {
    const assistantIdInput = document.querySelector('[name="assistant_id"]');
    const nameInput = document.querySelector('[name="name"]');
    const passwordInput = document.querySelector('[name="password"]');
    const addForm = document.getElementById('addAssistantForm');
    const tableBody = document.getElementById('assistantsTable').getElementsByTagName('tbody')[0];

    // Carga inicial de asistentes
    loadAssistants();

    // Agregar asistentes
    addForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const assistantIdValue = assistantIdInput.value;

        if (isValidAssistantId(assistantIdValue)) {
            const formData = new FormData(addForm);
            formData.append('action', 'add');
            fetch('../includes/addAssistant.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    clearFormFields(); // Limpia los campos del formulario
                    console.log(data);
                    loadAssistants();
                })
                .catch(error => console.error('Error:', error));
        } else {
            alert('The Assistant ID must be exactly 9 digits.');
        }
    });

    function loadAssistants() {
        fetch('../includes/getAssistants.php')
            .then(response => response.json())
            .then(data => {
                tableBody.innerHTML = ''; // Limpiar antes de llenar
                data.forEach(assistant => createAssistantRow(assistant));
            })
            .catch(error => console.error('Error:', error));
    }

    function createAssistantRow(assistant) {
        let row = tableBody.insertRow();
        row.insertCell(0).textContent = assistant.assistant_id;
        row.insertCell(1).textContent = assistant.name;
        row.insertCell(2).innerHTML = `<button onclick="deleteAssistant(${assistant.assistant_id})">Delete</button>`;
    }

    function deleteAssistant(assistantId) {
        if (confirm("Are you sure you want to delete this assistant?")) {
            fetch(`../includes/deleteAssistant.php?assistant_id=${assistantId}`, {
                method: 'POST'
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data.message);
                    loadAssistants();
                })
                .catch(error => console.error('Error:', error));
        }
    }

    function isValidAssistantId(id) {
        return id.length === 9 && /^\d{9}$/.test(id);
    }

    function clearFormFields() {
        assistantIdInput.value = '';
        nameInput.value = '';
        passwordInput.value = '';
    }

    // Hacer deleteAssistant global para acceso desde HTML
    window.deleteAssistant = deleteAssistant;
});
