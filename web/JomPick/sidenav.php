<?php

// Check if user is logged in, redirect to login page if not
if (!isset($_SESSION["id"])) {
    header("Location: index.php");
    exit;
}

// Fetch user's name from the database
$user_id = $_SESSION["id"];
$user_role = $_SESSION["role_id"]

?>

<?php  if (($user_role == '1')){ ?>
        <a href="admin_dashboard.php" class="list-group-item list-group-item-action">Dashboard</a>
        <a href="manage_items.php" class="list-group-item list-group-item-action">Manage item</a>
        <a href="manage_users.php" class="list-group-item list-group-item-action">Manage Users</a>
        <a href="#" class="list-group-item list-group-item-action">View Reports</a>
        <a href="#" class="list-group-item list-group-item-action" onclick="logout()">Logout</a>
<?php  } ?>

<?php  if (($user_role == '2')){ ?>
        <a href="staff_dashboard.php" class="list-group-item list-group-item-action">Dashboard</a>
        <a href="manage_items.php" class="list-group-item list-group-item-action">Manage item</a>
        <a href="#" class="list-group-item list-group-item-action" onclick="logout()">Logout</a>
<?php  } ?>