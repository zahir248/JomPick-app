<?php
include '../api/db_connection.php';
session_start();

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // Fetch user data from the database, including role_id
    $sql = "SELECT user_id, userName, password, role_id FROM user WHERE LOWER(userName) = LOWER('$username')";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($row["password"] === $password) {
            // Check if the user has a valid role (role_id 1 or 2)
            if ($row["role_id"] == 1) {
                // Admin role
                $_SESSION["id"] = $row["user_id"];
                $_SESSION["username"] = $row["userName"];
                header("Location: ../admin_dashboard.php");
                exit;
            } else if ($row["role_id"] == 2) {
                // Staff role
                $_SESSION["id"] = $row["user_id"];
                $_SESSION["username"] = $row["userName"];
                header("Location: ../staff_dashboard.php");
                exit;
            } else {
                header("Location: ../index.php?error=Unauthorized access");
            }
        } 
    } else {
        header("Location: ../index.php?error=Login Invalid");
    }

    $conn->close();
}

?>