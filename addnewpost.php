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

    $title = $_POST["title"];
    $content = $_POST["content"];

	if (!isset($title) && !isset($content)) {
		session_destroy();
        echo "<script>alert('title and content are required fields!');</script>";
        header("Refresh:0; url=form.php");
		die();
	}

	if (empty($title) || empty($content) ) {
		session_destroy();
        echo "<script>alert('title and content cannot be empty!');</script>";
        header("Refresh:0; url=form.php");
		die();
	}

	if (!add_post($_SESSION["username"], $title, $content)) {
		session_destroy();
        echo "<script>alert('Add post failed!');</script>";
        header("Refresh:0; url=form.php");
		die();
	} else {
        echo "<script>alert('Post has been added!');</script>";
        header("Refresh:0; url=index.php");
	}
?>
