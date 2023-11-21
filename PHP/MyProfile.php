<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

// Connect to your MySQL database
$host = "localhost";
$username = "root";
$password = "";
$database = "userdetailsdb";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process the JSON data received from JavaScript
$data = json_decode(file_get_contents("php://input"), true);

$firstname = isset($data['first name']) ? $data['first name'] : '';
$lastname = isset($data['last name']) ? $data['last name'] : '';
$email = isset($data['email']) ? $data['email'] : '';
$phone = isset($data['phone number']) ? $data['phone number'] : '';
$company = isset($data['company']) ? $data['company'] : '';
$designation = isset($data['designation']) ? $data['designation'] : '';
$skills = isset($data['skills']) ? $data['skills'] : '';
$hobbies = isset($data['hobbies']) ? $data['hobbies'] : '';

// Check if the record already exists
$result = $conn->query("SELECT * FROM userdetails WHERE id=1");

if ($result->num_rows > 0) {
    // If record exists, update the data
    $sql = "UPDATE userdetails SET firstname='$firstname', lastname='$lastname', email='$email', phone='$phone', company='$company', designation='$designation', skills='$skills', hobbies='$hobbies' WHERE id=1";
} else {
    // If record doesn't exist, insert the data
    $sql = "INSERT INTO userdetails (id, firstname, lastname, email, phone, company, designation, skills, hobbies) VALUES (1,'$firstname', '$lastname', '$email', '$phone', '$company', '$designation', '$skills', '$hobbies')";
}

if ($conn->query($sql) === TRUE) {
    $jsonFilePath = '../JSON/MyProfile.json';
    $jsonData = json_encode([
        "firstname" => $firstname,
        "lastname" => $lastname,
        "email" => $email,
        "phone" => $phone,
        "company" => $company,
        "designation" => $designation,
        "skills" => $skills,
        "hobbies" => $hobbies
    ]);

    file_put_contents($jsonFilePath, $jsonData);

    echo trim(json_encode(["success" => true, "message" => "Data updated successfully"]));
    exit;
} else {
    echo trim(json_encode(["success" => false, "message" => "Error updating/inserting data: " . $conn->error]));
    exit;
}

$conn->close();
?>

