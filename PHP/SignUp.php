<?php

// Enable CORS (Cross-Origin Resource Sharing)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

// Database connection settings
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'signupdb';

// Create a database connection
$mysqli = new mysqli($host, $username, $password, $database);

// Check the connection
if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

// Retrieve form data
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$countryCode = $_POST['country-code'];
$phone = $_POST['phone'];
$password = $_POST['password'];

// Check if email is already in use
$checkQuery = "SELECT * FROM users WHERE email = ?";
$checkStmt = $mysqli->prepare($checkQuery);
$checkStmt->bind_param('s', $email);
$checkStmt->execute();
$result = $checkStmt->get_result();

if ($result->num_rows > 0) {
    // Email is already in use, return an error response
    $response = ['success' => false, 'message' => 'Email is already in use.'];
} else {

    // Insert data into the database
    $insertQuery = "INSERT INTO users (firstname, lastname, email, country_code, phone, password) VALUES (?, ?, ?, ?, ?, ?)";
    $insertStmt = $mysqli->prepare($insertQuery);
    $insertStmt->bind_param('ssssss', $firstname, $lastname, $email, $countryCode, $phone, $password);

    if ($insertStmt->execute()) {
        // Registration was successful
        $response = ['success' => true];

        // Save data to JSON file
        $userData = [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'countryCode' => $countryCode,
            'phone' => $phone,
            'password' => $password,
        ];

        $jsonData = json_encode($userData, JSON_PRETTY_PRINT);
        file_put_contents('../JSON/SignUp.json', $jsonData);
    } else {
        // Registration failed
        $response = ['success' => false, 'message' => 'Registration failed.'];
    }
}

// Send a JSON response to the JavaScript
header('Content-Type: application/json');
echo json_encode($response);

// Close the database connection
$checkStmt->close();
$insertStmt->close();
$mysqli->close();
?>
