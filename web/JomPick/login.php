<?php
include 'db_connection.php';
session_start();

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $passwords = trim($_POST["password"]);
    
    // Establish database connection (replace with your connection details)
    $conn = new mysqli("localhost", "root", "", "jompick");
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Fetch user data from the database
    $sql = "SELECT user_id, emailaddress, password FROM user WHERE LOWER(emailAddress) = LOWER('$email')";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($row["password"] === $passwords) {
            $_SESSION["id"] = $row["user_id"];
            $_SESSION["email"] = $row["emailAddress"];
            header("Location: dashboard.php");
            exit;
        } else {
            header("Location: index.php?error=Invalid password");
        }
    } else {
        header("Location: index.php?error=User not found");
    }
    
    $conn->close();
}
?>
