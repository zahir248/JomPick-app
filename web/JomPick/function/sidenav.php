<?php

// Check if user is logged in, redirect to login page if not
if (!isset($_SESSION["id"])) {
    header("Location: ../index.php");
    exit;
}

// Fetch user's name from the database
    $user_id = $_SESSION["id"];
    $sql = "SELECT userName, role_id FROM user WHERE LOWER(user_id) = LOWER('$user_id')";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $user_role = $row ['role_id'];
    $user_name = $row["userName"];
?>

<?php  if (($user_role == '1')){ ?>
        <div class="sb-sidenav-menu">
        <div class="nav">
                <div class="sb-sidenav-menu-heading">Dashboard</div>
                <a class="nav-link" href="dashboard.php">
                        <i class="fas fa-chart-area"></i>
                        &nbsp;&nbsp;&nbsp;Analytics
                </a>

                <div class="sb-sidenav-menu-heading">Staff Management</div>
                        <a class="nav-link" href="staff_register.php">
                                <i class="fa fa-address-card"></i>
                                &nbsp;&nbsp;&nbsp;Registration
                        </a>
                        <a class="nav-link" href="staff_report.php">
                                <i class="fas fa-table"></i>
                                &nbsp;&nbsp;&nbsp;Staff List
                        </a>

                <div class="sb-sidenav-menu-heading">JomPick Management</div>
                        <a class="nav-link" href="item_register.php">
                                <i class="fa fa-file-text"></i>
                                &nbsp;&nbsp;&nbsp;Registration
                        </a>
                        <a class="nav-link" href="item_report.php">
                                <i class="fas fa-table"></i>
                                &nbsp;&nbsp;&nbsp;Report
                        </a>
                        <a class="nav-link" href="dashboard.php">
                                <i class="fas fa-user"></i>
                                &nbsp;&nbsp;&nbsp;Customer List
                        </a>
                        <a class="nav-link" href="dashboard.php">
                                <i class="fas fa-money-bill"></i>
                                &nbsp;&nbsp;&nbsp;Penalty
                        </a>
                        <a class="nav-link" href="dashboard.php">
                                <i class="fas fa-house"></i>
                                &nbsp;&nbsp;&nbsp;Pick-up Locations
                        </a>
                </div>
        </div>
        <div class="sb-sidenav-footer">
                <div class="small">Logged in as Admin:</div>
                <?php echo $user_name; ?>
        </div>
<?php  } ?>

<?php  if (($user_role == '2')){ ?>
        <div class="sb-sidenav-menu">
        <div class="nav">
                <div class="sb-sidenav-menu-heading">Dashboard</div>
                <a class="nav-link" href="dashboard.php">
                        <i class="fas fa-chart-area"></i>
                        &nbsp;&nbsp;&nbsp;Analytics
                </a>
                <a class="nav-link" href="dashboard.php">
                        <i class="fas fa-user"></i>
                        &nbsp;&nbsp;&nbsp;Profile
                </a>


                <div class="sb-sidenav-menu-heading">JomPick Management</div>
                        <a class="nav-link" href="item_register.php">
                                <i class="fa fa-file-text"></i>
                                &nbsp;&nbsp;&nbsp;Registration
                        </a>
                        <a class="nav-link" href="item_report.php">
                                <i class="fas fa-table"></i>
                                &nbsp;&nbsp;&nbsp;Report
                        </a>
                        <a class="nav-link" href="dashboard.php">
                                <i class="fas fa-user"></i>
                                &nbsp;&nbsp;&nbsp;Customer List
                        </a>
                        <a class="nav-link" href="dashboard.php">
                                <i class="fas fa-house"></i>
                                &nbsp;&nbsp;&nbsp;Penalty
                        </a>
                        
                </div>
        </div>
        <div class="sb-sidenav-footer">
                <div class="small">Logged in as Staff:</div>
                <?php echo $user_name; ?>
        </div>

<?php  } ?>