<?php
	require "database.php";
    require "session_auth.php";

	$token = $_POST["nocsrftoken"];
	if (!isset($token) || ($token != $_SESSION["nocsrftoken"])) {
		session_destroy();
		echo "<script>alert('CSRF attack is detected!';</script>)";
        header("Refresh:0; url=form.php");
		die();
	}

    $username = $_SESSION["username"];
    $name = $_POST["name"];
    $email = $_POST["email"];
	$phone_number = $_POST["phone_number"];

    if (!isset($username) && !isset($name) && !isset($email) && !isset($phone_number)) {
		session_destroy();
		echo "<script>alert('username, name, and email are all required fields!');</script>";
		header("Refresh:0; url=form.php");
		die();
    }

    if (empty($username) || empty($name) || empty($email) || empty($phone_number)) {
		session_destroy();
        echo "<script>alert('username, name, and email cannot be empty!');</script>";
        header("Refresh:0; url=form.php");
		die();
    }

	$username = sanitize_input($username);
	$name = sanitize_input($name);
	$email = sanitize_input($email);
	$phone_number = sanitize_input($phone_number);

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

	if (!updateprofile($username, $name, $email, $phone_number)) {
		session_destroy();
        echo "<script>alert('Update profile failed!');</script>";
        header("Refresh:0; url=form.php");
		die();
	} else {
        echo "<script>alert('Profile has been updated!');</script>";
        header("Refresh:0; url=index.php");
	}
?>