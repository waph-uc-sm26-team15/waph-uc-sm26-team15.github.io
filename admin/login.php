<?php
    require $_SERVER["DOCUMENT_ROOT"] . "/database.php";

    session_start();

	if (isset($_POST["username"]) and isset($_POST["password"])){
		if (checklogin_superuser($_POST["username"],$_POST["password"])) {
			$_SESSION["authenticated"] = TRUE;
			$_SESSION["username"] = $_POST["username"];
			$_SESSION["browser"] = $_SERVER["HTTP_USER_AGENT"];
            $_SESSION["role"] = "superuser";
		} else {
			session_destroy();
			echo "<script>alert('Invalid super username/password');window.location='loginform.php';</script>";
			die();
		}
	}

	if (!$_SESSION["authenticated"] or $_SESSION["authenticated"] != TRUE) {
		session_destroy();
		echo "<script>alert('You have not login. Please login first');</script>";
		header("Refresh:0; url=loginform.php");
		die();
	}

	if ($_SESSION["browser"] != $_SERVER["HTTP_USER_AGENT"]) {
		session_destroy();
		echo "<script>alert('Session hijacking is detected!');</script>";
		header("Refresh:0; url=loginform.php");
		die();
	}

    header("Refresh:0; url=index.php");
?>