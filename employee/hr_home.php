<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: employee_login.html');
	exit;
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>HR Employee</title>
		<link href="login_style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>Indigo Bookshop</h1>
				<a href="employee_profile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="employee_logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		<div class="content">
			<h2>HUMAN RESOURCE MANAGEMENT EMPLOYEE</h2>
			<p>Welcome, <?=$_SESSION['name']?>!</p>
		</div>

		<div class="content">
			<p><a href='http://localhost/470/employee/crud_read_deliveryboy.php' style='color: red;'> <u>List of Delivery Boys</u> </a></p>
		</div>

		<div class="content">
			<p><a href='http://localhost/470/employee/crud_read_employee.php' style='color: red;'> <u>List of Employees</u> </a></p>
		</div>


	</body>
</html>