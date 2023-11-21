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
$username = $_POST['username'];
$password = $_POST['password'];

// TODO: Validate the username and password against your signup database
$query = "SELECT * FROM users WHERE firstname = ? AND password = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('ss', $username, $password);

// Execute the query
$stmt->execute();

// Fetch the result
$result = $stmt->get_result();

// Check if a row with the given username and password exists
if ($result->num_rows > 0) {
    // Login successful
    $response = ['success' => true];
} else {
    // Login failed
    $response = ['success' => false, 'message' => 'Data Unavailable'];
}

// Send a JSON response to the JavaScript
header('Content-Type: application/json');
echo trim(json_encode($response));
exit;

// Close the database connection
$stmt->close();
$mysqli->close();
?>

