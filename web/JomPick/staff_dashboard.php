<?php
session_start();

// Check if user is logged in, redirect to login page if not
if (!isset($_SESSION["id"])) {
    header("Location: index.php");
    exit;
}

include 'db_connection.php'; // Include your database connection

// Fetch user's name from the database
$user_id = $_SESSION["id"];
$sql_user = "SELECT userName FROM user WHERE user_id = '$user_id'";
$result_user = $conn->query($sql_user);

if ($result_user->num_rows > 0) {
    $user_row = $result_user->fetch_assoc();
    $user_name = $user_row["userName"];
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>JomPick | Staff Dashboard</title>
    <!-- Include Bootstrap CSS link (you'll need to download Bootstrap or use a CDN) -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <!-- HEADER -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Staff Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
    <!-- HEADER -->
        <div class="row ">
             <!-- Side Nav -->
            <div class="col-md-2">
                <div class="list-group">
                    <?php include 'sidenav.php' ?>
                </div>
            </div>
             <!-- Side Nav -->

            <!-- Your content -->
            <div class="col-md-9" >
                <!-- Your dashboard content goes here -->
                <h1>Welcome to the Staff Dashboard</h1>
                <p>Hello, <?php echo $user_name; ?>! You have successfully logged in.</p>
                <!-- Add more content or widgets as needed -->
            </div>
            <!-- Your content -->

        </div>

    <script>
    function logout() {
        if (confirm("Are you sure you want to log out?")) {
            window.location.href = "logout.php"; // Redirect to the logout page
        }
    }
</script>

    <!-- Include Bootstrap JavaScript (jQuery and Popper.js) links here -->
    <script src="path/to/jquery.min.js"></script>
    <script src="path/to/popper.min.js"></script>
    <script src="path/to/bootstrap.min.js"></script>
</body>
</html>
