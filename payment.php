<?php
// your_php_script.php

// Check if the 'data' parameter is set in the POST request
if (isset($_POST['data'])) {
    // Retrieve data from the POST request
    $receivedData = $_POST['data'];

    // Decode the JSON string to an associative array
    $reservationData = json_decode($receivedData, true);

    // Now $reservationData contains the reservation details as an associative array
    // You can access individual values like $reservationData['adults'], $reservationData['roomNumber'], etc.

    // Perform any necessary processing or validation here
    // For example, you might want to store the data in a database

    // Respond to the client (optional)
    echo 'Data received successfully.';
} else {
    // Handle the case where 'data' parameter is not set
    echo 'Error: Data parameter not set in the request.';
}
?>
