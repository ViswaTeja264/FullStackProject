<?php
header('Content-Type: application/json');

$jsonFilePath = '../JSON/MyProfile.json';

// Check if the file exists
if (file_exists($jsonFilePath)) {
    // Read the contents of the file
    $jsonData = file_get_contents($jsonFilePath);

    // Decode the JSON data
    $decodedData = json_decode($jsonData, true);

    // Check if decoding was successful
    if ($decodedData !== null) {
        // Output or log the decoded data
        var_dump($decodedData);
    } else {
        // Handle JSON decoding error
        echo "Error decoding JSON data.";
    }
} else {
    // Handle file not found error
    echo "File not found: $jsonFilePath";
}

?>
