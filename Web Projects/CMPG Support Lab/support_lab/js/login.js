const togglePasswordVisibility = (loginPassId, loginEyeId) => {
    const input = document.getElementById(loginPassId);
    const iconEye = document.getElementById(loginEyeId);

    iconEye.addEventListener('click', () => {
        if (input.type === 'password') {
            input.type = 'text';
            iconEye.classList.replace('ri-eye-off-line', 'ri-eye-line');
        } else {
            input.type = 'password';
            iconEye.classList.replace('ri-eye-line', 'ri-eye-off-line');
        }
    });
};

togglePasswordVisibility('password', 'login-eye');

document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('includes/login.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            window.location.href = 'views/searchStudent.php';
        } else {
            document.getElementById('errorMessage').textContent = data.message;
        }
    })
    .catch(error => console.error('Error:', error));
});