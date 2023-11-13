<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jompick";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Receive updated profile data from the request
$userId = $_POST['user_id'];
$fullName = $_POST['fullName'];
$phoneNumber = $_POST['phoneNumber'];
$icNumber = $_POST['icNumber'];
$emailAddress = $_POST['emailAddress'];

// Check if the submitted data is the same as the existing data
$sqlCheck = "SELECT * FROM user WHERE user_id = $userId";
$resultCheck = $conn->query($sqlCheck);

$response = array(); // Create an associative array for the response

if ($resultCheck->num_rows > 0) {
    $row = $resultCheck->fetch_assoc();

    if ($row['fullName'] == $fullName && $row['phoneNumber'] == $phoneNumber && $row['icNumber'] == $icNumber && $row['emailAddress'] == $emailAddress) {
        // No changes, return a response indicating no update
        $response['success'] = false;
        $response['message'] = "No changes to update";
    } else {
        // Update the user's profile in the database
        $sql = "UPDATE user SET fullName='$fullName', phoneNumber='$phoneNumber', icNumber='$icNumber', emailAddress='$emailAddress' WHERE user_id=$userId";

        if ($conn->query($sql) === TRUE) {
            $response['success'] = true;
            $response['message'] = "Profile updated successfully";
            $response['fullName'] = $fullName;
            $response['phoneNumber'] = $phoneNumber;
            $response['icNumber'] = $icNumber;
            $response['emailAddress'] = $emailAddress;
        } else {
            $response['success'] = false;
            $response['message'] = "Error updating profile: " . $conn->error;
            // You can include other fields in the response if needed
        }
    }
} else {
    $response['success'] = false;
    $response['message'] = "User not found";
}

// Close the database connection
$conn->close();

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);

?>
