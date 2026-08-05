<?php
	require "database.php";

	$lifetime = 15 * 60;
	$path = "/";
	$domain = "192.168.56.7";
	$secure = TRUE;
	$httponly = TRUE;
	session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
	session_start();

	if (isset($_POST["username"]) and isset($_POST["password"])){
		if (checklogin_mysql($_POST["username"],$_POST["password"])) {
			$_SESSION["authenticated"] = TRUE;
			$_SESSION["username"] = $_POST["username"];
			$_SESSION["browser"] = $_SERVER["HTTP_USER_AGENT"];
		} else {
			session_destroy();
			echo "<script>alert('Invalid username/password');window.location='form.php';</script>";
			die();
		}
	}

	if (!$_SESSION["authenticated"] or $_SESSION["authenticated"] != TRUE) {
		session_destroy();
		echo "<script>alert('You have not login. Please login first');</script>";
		header("Refresh:0; url=form.php");
		die();
	}

	if ($_SESSION["browser"] != $_SERVER["HTTP_USER_AGENT"]) {
		session_destroy();
		echo "<script>alert('Session hijacking is detected!');</script>";
		header("Refresh:0; url=form.php");
		die();
	}

	$name = get_name($_SESSION["username"]);
	$email = get_email($_SESSION["username"]);
	$phone_number = get_phone_number($_SESSION["username"]);
	$posts = get_all_posts();
    $rand = bin2hex(openssl_random_pseudo_bytes(16));
    $_SESSION["nocsrftoken"] = $rand;  
?>
	<head>
        <script type="text/javascript">
            function displayTime() {
                document.getElementById('digit-clock').innerHTML = "Current time: " + new Date();
            }
            setInterval(displayTime, 500);
        </script>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
		<link rel="stylesheet" href="styles.css">
	</head>
	<h2>Welcome <?php echo htmlspecialchars($_SESSION["username"], ENT_QUOTES, 'UTF-8');?>!</h2>
	<div id="digit-clock"></div>
	<a href="profilemanagementform.php">Profile Management</a> |
	<a href="changepasswordform.php">Change Password</a> | 
	<a href="logout.php">Logout</a>
	<br><br>
	<h3>My Profile</h3>
	<span>Name: <?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8');?></span><br>
	<span>Email: <?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8');?></span><br>
	<span>Phone Number: <?php echo htmlspecialchars($phone_number, ENT_QUOTES, 'UTF-8');?></span><br>
	<br>
	<h3>Posts</h3>
	<?php if (isset($_SESSION["username"])): ?>
		<a href="newpost.php">Create New Post</a>
		<hr>
	<?php endif; ?>
	<?php if (!empty($posts)): ?>
		<?php foreach ($posts as $post): ?>
			<h4><?php echo htmlentities($post["title"]); ?></h4>
			<p><?php echo nl2br(htmlentities($post["content"])); ?></p>
			<small>
				Posted by <?php echo htmlentities($post["owner"]); ?>
				on <?php echo htmlentities($post["date"]); ?>
			</small>
			<br>
			<?php if (isset($_SESSION["username"]) and $_SESSION["username"] == $post["owner"]): ?>
				<small style="padding-left: 0px;">
					<a href="editpostform.php?id=<?php echo $post["postID"]; ?>">Edit</a>|
					<form action="deletepost.php" method="post" style="display: inline-block; padding-left: 5px; margin-block-end: 0;">
						<input type="hidden" name="postID" value="<?php echo $post["postID"];?>">
						<input type="hidden" name="nocsrftoken" value="<?php echo $rand; ?>">
            			<button class="link-button" type="submit">Delete</button>
					</form>
				</small>
			<?php endif; ?>
			<h5>Comments</h5>
			<?php $comments = get_comments($post["postID"]); ?>
			<?php if (!empty($comments)): ?>
				<?php foreach ($comments as $comment): ?>
					<span><?php echo nl2br(htmlentities($comment["content"])); ?></span>
					<br>
					<small>
						Comment by <?php echo htmlentities($comment["owner"]); ?>
						on <?php echo htmlentities($comment["date"]); ?>
					</small>
					<br><br>
				<?php endforeach; ?>
			<?php else: ?>
				<span>This post does not have any comments</span>
				<br>
			<?php endif; ?>
			<?php if (isset($_SESSION["username"])): ?>
				<h6>Add a Comment</h6>
				<form action="addnewcomment.php" method="post" class="form-container">
					<input type="hidden" name="postID" value="<?php echo $post["postID"];?>">
					<textarea name="content" rows="3" cols="50" required></textarea>
					<br>
            		<input type="hidden" name="nocsrftoken" value="<?php echo $rand; ?>">
            		<button class="button" type="submit">Add Comment</button>
				</form>
			<?php endif; ?>
			<hr>
		<?php endforeach; ?>
	<?php else: ?>
		<span>No posts have been created!</span>
	<?php endif; ?>
