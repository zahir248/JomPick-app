<?php
include 'db_connection.php';
session_start();

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Establish database connection (replace with your connection details)
    $conn = new mysqli("localhost", "root", "", "jompick");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch user data from the database, including role_id
    $sql = "SELECT user_id, emailaddress, password, role_id FROM user WHERE LOWER(emailAddress) = LOWER('$email')";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($row["password"] === $password) {
            // Check if the user has a valid role (role_id 1 or 2)
            if ($row["role_id"] == 1) {
                // Admin role
                $_SESSION["id"] = $row["user_id"];
                $_SESSION["email"] = $row["emailAddress"];
                header("Location: admin_dashboard.php");
                exit;
            } elseif ($row["role_id"] == 2) {
                // Staff role
                $_SESSION["id"] = $row["user_id"];
                $_SESSION["email"] = $row["emailAddress"];
                header("Location: staff_dashboard.php");
                exit;
            } else {
                header("Location: index.php?error=Unauthorized access");
            }
        } else {
            header("Location: index.php?error=Invalid password");
        }
    } else {
        header("Location: index.php?error=User not found");
    }

    $conn->close();
}

?>
