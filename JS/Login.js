document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.querySelector('form');

    loginForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = new FormData(loginForm);

        // Send the data to the server using the Fetch API
        fetch('http://localhost/fullstackproject/PHP/Login.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.success) {
                // Login was successful
                setTimeout(() => {
                    window.location.href = 'MyProfile.html'; // Redirect to the Profile page
                }, 0);
            } else {
                // Login failed
                alert('Invalid credentials. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});
