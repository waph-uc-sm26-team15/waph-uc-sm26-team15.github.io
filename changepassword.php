<?php
	require "database.php";
    require "session_auth.php";

	$token = $_POST["nocsrftoken"];
	if (!isset($token) || ($token != $_SESSION["nocsrftoken"])) {
		session_destroy();
		echo "<script>alert('CSRF attack is detected!');</script>";
        header("Refresh:0; url=form.php");
		die();
	}

    $username = $_SESSION["username"];
	$password = $_POST["newpassword"];

	if (!isset($username) && !isset($password)) {
		session_destroy();
        echo "<script>alert('username and newpassword are required fields!');</script>";
        header("Refresh:0; url=form.php");
		die();
	}

	if (empty($username) || empty($password) ) {
		session_destroy();
        echo "<script>alert('username and password cannot be empty!');</script>";
        header("Refresh:0; url=form.php");
		die();
	}

	$password = sanitize_input($password);

	if (preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&])[\w!@#$%^&]{8,}$/', $password) == 0) {
		session_destroy();
        echo "<script>alert('Invalid password!');</script>";
        header("Refresh:0; url=form.php");
		die();
	}

	if (!changepassword($username, $password)) {
		session_destroy();
        echo "<script>alert('Change password failed!');</script>";
        header("Refresh:0; url=form.php");
		die();
	} else {
        echo "<script>alert('Password has been changed!');</script>";
        header("Refresh:0; url=index.php");
	}

	function changepassword($username, $password) {
		$mysqli = new mysqli('localhost', 'team15', 'password', 'waph_team15');
		if ($mysqli->connect_errno) {
			printf("Database connection failed: %s\n", $mysqli->connect_error);
			return FALSE;
		}
		$prepared_sql = "UPDATE users SET password = md5(?) WHERE username = ?;";
		$stmt = $mysqli->prepare($prepared_sql);
		$stmt->bind_param("ss", $password, $username);
		if ($stmt->execute()) return TRUE;
		return FALSE;
  	}
?>