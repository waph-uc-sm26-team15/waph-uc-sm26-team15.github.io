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
    $post = get_post($postID);

    if ($post["owner"] != $_SESSION["username"]) {
		session_destroy();
		echo "<script>alert('The non-owner of this post is trying to delete it!';</script>)";
        header("Refresh:0; url=form.php");
		die();
    }

	if (!isset($postID)) {
		session_destroy();
        echo "<script>alert('title and content are required fields!');</script>";
        header("Refresh:0; url=form.php");
		die();
	}

	if (empty($postID)) {
		session_destroy();
        echo "<script>alert('title and content cannot be empty!');</script>";
        header("Refresh:0; url=form.php");
		die();
	}

	if (!delete_post($postID)) {
		session_destroy();
        echo "<script>alert('Delete post failed!');</script>";
        header("Refresh:0; url=form.php");
		die();
	} else {
        echo "<script>alert('Post has been deleted!');</script>";
        header("Refresh:0; url=index.php");
	}
?>