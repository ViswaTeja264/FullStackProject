document.addEventListener('DOMContentLoaded', () => {
    const signupForm = document.querySelector('form');

    signupForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        try {
            const formData = new FormData(signupForm);

            // Send the data to the server using the Fetch API
            const response = await fetch('http://localhost/fullstackproject/PHP/SignUp.php', {
                method: 'POST',
                body: formData,
            });

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            const data = await response.json();

            if (data.success) {
                // Registration was successful
                alert('Registration Successful! You Can Now Log In.');
                setTimeout(() => {
                    window.location.href = 'Login.html'; // Redirect to the login page
                }, 0);

            } else {
                // Registration failed
                alert('Registration Failed. Please Check Your Inputs.');

                // Check if the error message is present in the response
                const errorMessage = data.message || 'Registration Failed.';

                // Display the error message on the page
                displayErrorMessage(errorMessage);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });

    // Function to display error messages
    function displayErrorMessage(message) {
        // Create or update an element to display the error message
        let errorMessageElement = document.getElementById('error-message');
    
        if (!errorMessageElement) {
            errorMessageElement = document.createElement('div');
            errorMessageElement.id = 'error-message';
            errorMessageElement.style.color = 'red';
            document.querySelector('.container').appendChild(errorMessageElement);
        }
    
        errorMessageElement.textContent = message;
    }
});
