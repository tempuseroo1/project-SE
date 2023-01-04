<?php
session_start();
session_destroy();
// Redirect to the login page:
header('Location: employee_login.html');
?>