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

    $postID = $_POST["postID"];
    $content = $_POST["content"];

	if (!isset($postID) && !isset($content)) {
		session_destroy();
        echo "<script>alert('postID and content are required fields!');</script>";
        header("Refresh:0; url=form.php");
		die();
	}

	if (empty($postID) || empty($content) ) {
		session_destroy();
        echo "<script>alert('postID and content cannot be empty!');</script>";
        header("Refresh:0; url=form.php");
		die();
	}

    if (!add_comment($postID, $_SESSION["username"], $content)) {
		session_destroy();
        echo "<script>alert('Adding comment failed!');</script>";
        header("Refresh:0; url=form.php");
		die();
    } else {
        echo "<script>alert('Comment has been added!');</script>";
        header("Refresh:0; url=index.php");
    }
?>