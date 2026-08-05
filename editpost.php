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
    $title = $_POST["title"];
    $content = $_POST["content"];
    $post = get_post($postID);

    if ($post["owner"] != $_SESSION["username"]) {
		session_destroy();
		echo "<script>alert('The non-owner of this post is trying to make an edit!';</script>)";
        header("Refresh:0; url=form.php");
		die();
    }

	if (!isset($postID) && !isset($title) && !isset($content)) {
		session_destroy();
        echo "<script>alert('title and content are required fields!');</script>";
        header("Refresh:0; url=form.php");
		die();
	}

	if (empty($postID) || empty($title) || empty($content)) {
		session_destroy();
        echo "<script>alert('title and content cannot be empty!');</script>";
        header("Refresh:0; url=form.php");
		die();
	}

    $title = sanitize_input($title);
    $content = sanitize_input($content);

	if (!update_post($postID, $title, $content)) {
		session_destroy();
        echo "<script>alert('Update post failed!');</script>";
        header("Refresh:0; url=form.php");
		die();
	} else {
        echo "<script>alert('Post has been updated!');</script>";
        header("Refresh:0; url=index.php");
	}
?>