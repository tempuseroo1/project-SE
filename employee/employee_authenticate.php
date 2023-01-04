<?php
session_start();
// Change this to your connection info.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'bookshop_users';
// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}


// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if ( !isset($_POST['username'], $_POST['password']) ) {
	// Could not get the data that should have been sent.
	exit('Please fill both the username and password fields!');
}


// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt = $con->prepare('SELECT id, password, department FROM employee_signed WHERE username = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	// Store the result so we can check if the account exists in the database.
	$stmt->store_result();


	if ($stmt->num_rows > 0) {
		$stmt->bind_result($id, $password, $department);
		$stmt->fetch();

		if ($_POST['password'] === $password) { 

			session_regenerate_id();
			$_SESSION['loggedin'] = TRUE;
			$_SESSION['name'] = $_POST['username'];
			$_SESSION['id'] = $id;
			// echo 'Welcome ' . $_SESSION['name'] . '!';

			if ($department === 'Stock') {
				header('Location: stock_home.php');
			}

			elseif ($department === 'Finance') {
				header('Location: finance_home.php');
			}

			else {
				header('Location: hr_home.php');
			}
		} 

	else {
		// Incorrect password
		echo 'Incorrect username and/or password!';
	}
}

else {
	// Incorrect username
	echo 'Incorrect username and/or password!';
}


	$stmt->close();
}
?>