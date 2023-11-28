<!DOCTYPE html>
<html>
<head>
    <title>JomPick | Log In</title>
    <!-- Include Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body > 

<?php
// Check if 'error' parameter is set in the URL
if (isset($_GET['error'])) {
    // Display an error message with the value of the 'error' parameter
    echo '<div class="alert alert-danger text-center" role="alert">' . $_GET['error'] . '</div>';
    
    // Clear the 'error' parameter from the URL using JavaScript
    echo '<script>history.replaceState({}, document.title, "' . $_SERVER['PHP_SELF'] . '");</script>';
}
?>

<div class="container mt-5">

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="row justify-content-center" style="padding-bottom: 50px">
                <img src="assets/JomPick_logo1.jpg" alt="Logo" style="width:150px;height:150px;">
            </div>
            <div class="card">
                <div class="card-body" >
                    <!-- Create a form to submit login credentials to 'login.php' -->
                    <form method="post" action="login.php">
                        <label for="username">Username</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-user" style="padding:0px 4px 0px;"></i> <!-- Envelope icon for email field -->
                                </span>
                            </div>
                            <input type="username" class="form-control" name="username" placeholder="Username" required>
                        </div>
                        <label for="password">Password</label>
                        <div class="input-group mb-3" style="padding-bottom: 10px;">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    &#128274; <!-- Lock icon for password field -->
                                </span>
                            </div>
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        <button type="submit" class="btn btn-blue btn-block" style="background-color: #6D87EC; color: white;">
                            Sign in
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include jQuery, Popper.js, and Bootstrap JS scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>