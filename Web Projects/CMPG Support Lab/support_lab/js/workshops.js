document.addEventListener('DOMContentLoaded', function () {
    loadWorkshops();

    const form = document.getElementById('newWorkshopForm');
    form.addEventListener('submit', function (event) {
        event.preventDefault();
        addWorkshop(form);
    });
});

function loadWorkshops() {
    fetch('../includes/getWorkshops.php')
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('workshops-table').getElementsByTagName('tbody')[0];
            tbody.innerHTML = '';
            console.log(data);
            data.forEach(workshop => {
                let row = tbody.insertRow();
                row.insertCell(0).textContent = workshop.workshop_title;
                row.insertCell(1).textContent = workshop.date;
                row.insertCell(2).textContent = workshop.description;
                let deleteCell = row.insertCell(3);
                let deleteButton = document.createElement('button');
                deleteButton.textContent = 'Delete';
                deleteButton.className = 'btn-delete';
                deleteButton.onclick = function () { deleteWorkshop(workshop.workshop_id); };
                deleteCell.appendChild(deleteButton);
            });
        })
        .catch(error => console.error('Error loading workshops:', error));
}

function addWorkshop(form) {
    const formData = new FormData(form);
    fetch('../includes/addWorkshop.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadWorkshops();
                form.reset(); // Resets the form
            } else {
                alert('Failed to add workshop.');
            }
        })
        .catch(error => {
            console.error('Error adding workshop:', error);
            alert('Error adding workshop. Please try again.');
        });
}

function deleteWorkshop(workshopId) {
    if (confirm('Are you sure you want to delete this workshop?')) {
        fetch('../includes/deleteWorkshop.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'workshop_id=' + workshopId
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Workshop deleted successfully.');
                    loadWorkshops();
                } else {
                    alert('Failed to delete workshop.');
                }
            })
            .catch(error => {
                console.error('Error deleting workshop:', error);
                alert('Error deleting workshop. Please try again.');
            });
    }
}