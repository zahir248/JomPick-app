<?php
session_start();

// Check if user is logged in, redirect to login page if not
if (!isset($_SESSION["id"])) {
    header("Location: index.php");
    exit;
}

include 'api/db_connection.php'; // Include your database connection

// Fetch user data from the database and join with the role table to get role names
$sql_user = "SELECT u.*, r.rolename FROM user u
            JOIN role r ON u.role_id = r.role_id
            WHERE u.role_id = 2 || u.role_id = 3";
$result_user = $conn->query($sql_user);
$users = array();

if ($result_user->num_rows > 0) {
    while ($user_row = $result_user->fetch_assoc()) {
        $users[] = $user_row;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <!-- Include Bootstrap CSS link (you'll need to download Bootstrap or use a CDN) -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>JomPick | JomPick Report</title>
    <link rel="shortcut icon" type="image/jpg" href="assets/JomPick_logo1.jpg">   
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/style2.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
    label{
        margin-bottom:5px;
    }
    input{
        margin-bottom:5px;
    }
</style>
    
<body class="sb-nav-fixed">
<!-- Top nav -->   
<?php include 'function/topnav.php' ?>
<!-- Top nav -->
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion" >
            <?php include 'function/sidenav.php' ?>
        </nav>
    </div>
    <div id="layoutSidenav_content">
    
        <main>
            <div class="container-fluid px-4">
            <h1 class="mt-4">User Report</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="dashboard.php">Analytics</a></li>
                    <li class="breadcrumb-item active">JomPick Report</li>
                </ol>
                <div class="card mb-4">
                    <form method="post" action="add_item.php" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                            <label for="userid">User ID:</label><br/>
                                            <input type="text" class="form-control" id="userid" name="userid" required>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                            <label for="username">Name:</label><br/>
                                            <input type="text" class="form-control" id="username" name="username" required>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                            <label for="phnum">Phone Number:</label><br/>
                                            <input type="text" class="form-control" id="phnum" name="phnum" required>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                            <label for="icnum">Ic Number:</label><br/>
                                            <input type="text" class="form-control" id="icnum" name="icnum" required>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                            <label for="fullname">Full Name:</label><br/>
                                            <input type="text" class="form-control" id="fullname" name="fullname" required>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                            <label for="mailaddress">E-Mail:</label><br/>
                                            <input type="text" class="form-control" id="mailaddress" name="mailaddress" required>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="form-group">
                                            <label for="role">Role:</label><br/>
                                            <input type="text" class="form-control" id="role" name="role" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <div></div>
                            <div class="small text-white"><a href="#!" class="btn btn-primary btn-sm"><i class="fa fa-search"></i>&nbsp;&nbsp;Search</a></div>
                        </div>
                    </form>
                </div>

                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div><i class="fas fa-table me-1"></i> JomPick Reports</div>
                        <div class="small text-white"><a href="staff_register.php" class="btn btn-primary btn-sm" data-toggle="modal"><i class="fa fa-plus-square"></i>&nbsp;&nbsp;Register</a></div>
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple" style=" --bs-table-hover-bg: none;">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Username</th>
                                    <th>Phone Number</th>
                                    <th>Ic Number</th>
                                    <th>Full Name</th>
                                    <th>E-Mail</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>User ID</th>
                                    <th>Username</th>
                                    <th>Phone Number</th>
                                    <th>Ic Number</th>
                                    <th>Full Name</th>
                                    <th>E-Mail</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php foreach ($users as $user) { ?>
                                    <tr>
                                        <td><?php echo $user["user_id"]; ?></td>
                                        <td><?php echo $user["userName"]; ?></td>
                                        <td><?php echo $user["phoneNumber"]; ?></td>
                                        <td><?php echo $user["icNumber"]; ?></td>
                                        <td><?php echo $user["fullName"]; ?></td>
                                        <td><?php echo $user["emailAddress"]; ?></td>
                                        <td><?php echo $user["rolename"]; ?></td> <!-- Display the role name from the joined table -->
                                        <td>
                                            <a href="#" class="btn btn-info btn-sm" style="margin-top:3px; color:white;"><i class="fas fa-edit"></i> Update</a>
                                            <a href="#" class="btn btn-danger btn-sm" style="margin-top:3px;"><i class="fas fa-trash-alt"></i> Delete</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div></div>
                    <div class="text-muted">Copyright &copy; JomPick 2023</div>
                </div>
            </div>
        </footer>
    </div>


<script>
    function logout() {
        if (confirm("Are you sure you want to log out?")) {
            window.location.href = "function/logout.php"; // Redirect to the logout page
        }
    }
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <!-- Include Bootstrap JavaScript (jQuery and Popper.js) links here -->

    <script src="path/to/jquery.min.js"></script>
    <script src="path/to/popper.min.js"></script>
    <script src="path/to/bootstrap.min.js"></script>
</body>
</html>