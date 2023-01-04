<?php
// Change this to your connection info.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'bookshop_users';
// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	exit('Email is not valid!');
}

if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
	exit('Password must be between 5 and 20 characters long!');
}

// We need to check if the account with that username exists.
if ($stmt = $con->prepare('SELECT id, password FROM employee_signed WHERE username = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();
	// Store the result so we can check if the account exists in the database.
	if ($stmt->num_rows > 0) {
		// Username already exists
		echo 'Username exists, please choose another!';
	} 

	else {
		// Username doesnt exists, insert new account
		if ($stmt = $con->prepare('INSERT INTO employee_signed (username, password, email, department) VALUES (?, ?, ?, ?)')) {
			// We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
			$password = $_POST['password'];
			$stmt->bind_param('ssss', $_POST['username'], $password, $_POST['email'], $_POST['department']);
			$stmt->execute();
			echo 'You have successfully registered, you can now login!';
			echo "<a href='http://localhost/470/employee/employee_login.html' style='color: red;'> <u>Click Here to redirect to the Login page</u> </a>";
		} 

		else {
			// Something is wrong with the sql statement, check to make sure employee_signed table exists with all 3 fields.
			echo 'Could not prepare statement!';
		}
	}
	$stmt->close();
} 
else {
	// Something is wrong with the sql statement, check to make sure employee_signed table exists with all 3 fields.
	echo 'Could not prepare statement!';
}
$con->close();
?>