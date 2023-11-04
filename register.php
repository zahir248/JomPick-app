<?php
$db = mysqli_connect('localhost','root','','jompick');
if(!$db)
{
	echo "Database connection failed";
}
$username = $_POST['username'];
$password = $_POST['password'];
$fullName = $_POST['fullName'];
$emailAddress = $_POST['emailAddress'];
$icNumber = $_POST['icNumber'];
$phoneNumber = $_POST['phoneNumber'];
$role_id = 3; // Set the role_id to 3 for new registrations(client)

$sql = "SELECT username FROM user WHERE username = '".$username."'";
$result = mysqli_query($db,$sql);
$count = mysqli_num_rows($result);
if($count == 1){
	echo json_encode("Error");
}else{
	$insert = "INSERT INTO user(username,password,fullName,emailAddress,icNumber,phoneNumber,role_id) VALUES ('".$username."','".$password."', '".$fullName."', '".$emailAddress."', '".$icNumber."', '".$phoneNumber."', '" . $role_id . "')";
		$query = mysqli_query($db,$insert);
		if($query){
			echo json_encode("Success");
		}
}
?>