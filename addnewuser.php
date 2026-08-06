<?php
	require "database.php";

	$token = $_POST["nocsrftoken"];
	if (!isset($token) || ($token != $_SESSION["nocsrftoken"])) {
		session_destroy();
		echo "<script>alert('CSRF attack is detected!');</script>";
        header("Refresh:0; url=form.php");
		die();
	}

	$username = $_POST["username"];
	$password = $_POST["password"];
	$repassword = $_POST["repassword"];
	$name = $_POST["name"];
	$email = $_POST["email"];
	$phone_number = $_POST["phone_number"];

	if (!isset($username) && !isset($password) && !isset($repassword) && !isset($name) && !isset($email) && !isset($phone_number)) {
		session_destroy();
		echo "<script>alert('username, password, name, email, and phone number are all required fields!');</script>";
		header("Refresh:0; url=form.php");
		die();
	}

	if (empty($username) || empty($password) || empty($repassword) || empty($name) || empty($email) || empty($phone_number)) {
		session_destroy();
		echo "<script>alert('username, password, name, email, and phone number cannot be empty!');</script>";
		header("Refresh:0; url=form.php");
		die();
	}

	$username = sanitize_input($username);
	$password = sanitize_input($password);
	$repassword = sanitize_input($repassword);
	$name = sanitize_input($name);
	$email = sanitize_input($email);
	$phone_number = sanitize_input($phone_number);

	if (preg_match("/\w+/", $username) == 0) {
		session_destroy();
		echo "<script>alert('Invalid username!');</script>";
		header("Refresh:0; url=form.php");
		die();
	}

	if (preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&])[\w!@#$%^&]{8,}$/', $password) == 0) {
		session_destroy();
		echo "<script>alert('Invalid password!');</script>";
		header("Refresh:0; url=form.php");
		die();
	}

	if (preg_match("/^[A-Za-z]+([\s\'.-][A-Za-z]+)*$/", $name) == 0) {
		session_destroy();
		echo "<script>alert('Invalid name!');</script>";
		header("Refresh:0; url=form.php");
		die();
	}

	if (preg_match('/^[\w.-]+@[\w-]+(.[\w-]+)*$/', $email) == 0) {
		session_destroy();
		echo "<script>alert('Invalid email!');</script>";
		header("Refresh:0; url=form.php");
		die();
	}

	if (preg_match('/^\d{3}-\d{3}-\d{4}$/', $phone_number) == 0) {
		session_destroy();
		echo "<script>alert('Invalid phone number!');</script>";
		header("Refresh:0; url=form.php");
		die();
	}

	if ($password !== $repassword) {
		session_destroy();
		echo "<script>alert('Passwords do not match!');</script>";
		header("Refresh:0; url=form.php");
		die();
	}

	if (!addnewuser($username, $password, $name, $email, $phone_number)) {
		session_destroy();
		echo "<script>alert('Failed to register user');</script>";
		header("Refresh:0; url=form.php");
		die();
	} else {
		echo "<script>alert('Registered user!');</script>";
		header("Refresh:0; url=form.php");
	}
?>
