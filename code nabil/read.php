<?php

header('Content-Type: application/json');

$db = mysqli_connect('localhost', 'root', '', 'jompick');

// Assuming you want to retrieve all rows from the user table
$sql = "SELECT fullName, emailAddress, phoneNumber FROM user";
$result = mysqli_query($db, $sql);

if ($result) {
    $userArray = array(); // Create an array to hold user data
    
    // Fetch each row of user data
    while ($row = mysqli_fetch_assoc($result)) {
        $userArray[] = $row;
    }
    
    // Return the user data as JSON
    echo json_encode($userArray);
} else {
    echo json_encode("Error");
}
?>
