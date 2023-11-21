function toggleEditMode() {
  const profileData = document.querySelector('.profile-data');
  profileData.classList.toggle('edit-mode');

  if (profileData.classList.contains('edit-mode')) {
    // Copy values to input fields when entering edit mode
    const details = profileData.querySelectorAll('.detail');
    details.forEach((detail) => {
      const valueSpan = detail.querySelector('.value');
      const inputField = detail.querySelector('input');
      inputField.value = valueSpan.innerText.trim();
    });
  } else {
    // Saving data when exiting edit mode
    const updatedData = {};
    const details = profileData.querySelectorAll('.detail');
    details.forEach((detail) => {
      const label = detail.querySelector('.label');
      const inputField = detail.querySelector('input');
      const fieldName = label.innerText.trim().toLowerCase();
      const fieldValue = inputField.value.trim();
      updatedData[fieldName] = fieldValue;

      // Updating the displayed value with the newly entered data
      const valueSpan = detail.querySelector('.value');
      valueSpan.innerText = fieldValue;
    });

    // Fetch request to send data to PHP backend
    fetch('http://localhost/fullstackproject/PHP/MyProfile.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(updatedData),
    })
      .then(response => response.json())
      .then(data => {
        console.log('Data sent successfully:', data);

        // Store the updated data in localStorage
        localStorage.setItem('profileData', JSON.stringify(updatedData));
      })
      .catch(error => {
        console.error('Error sending data:', error);
      });
  }
}

// Function to retrieve stored data on page load
function retrieveStoredData() {
  const storedData = localStorage.getItem('profileData');

  if (storedData) {
    const parsedData = JSON.parse(storedData);
    // Updating the displayed data with the stored data
    updateProfileData(parsedData);
  }
}

function updateProfileData(updatedData) {

  console.log('Received data:', updatedData);
  
  // Updating the HTML elements with the new data
  const details = document.querySelectorAll('.detail');
  details.forEach((detail) => {
    const label = detail.querySelector('.label');
    const valueSpan = detail.querySelector('.value');
    const fieldName = label.innerText.trim().toLowerCase();
    valueSpan.innerText = updatedData[fieldName];
  });
}

// Calling the retrieveStoredData function on page load
document.addEventListener('DOMContentLoaded', retrieveStoredData);
