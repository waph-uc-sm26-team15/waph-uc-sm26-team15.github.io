<?php
	require $_SERVER["DOCUMENT_ROOT"] . "/database.php";
    require $_SERVER["DOCUMENT_ROOT"] . "/session_auth.php";

	$lifetime = 15 * 60;
	$path = "/";
	$domain = "192.168.56.7";
	$secure = TRUE;
	$httponly = TRUE;
	session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
	session_start();

    if (!isset($_SESSION["role"]) or $_SESSION["role"] != "superuser") {
		session_destroy();
		echo "<script>alert('You are not a superuser and do not have permission to view this page!');</script>";
		header("Refresh:0; url=loginform.php");
		die();
    }

    $users = get_all_users();
?>
	<head>
        <script type="text/javascript">
            function displayTime() {
                document.getElementById('digit-clock').innerHTML = "Current time: " + new Date();
            }
            setInterval(displayTime, 500);
        </script>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
		<link rel="stylesheet" href="../styles.css">
	</head>
	<h2>Welcome <?php echo htmlspecialchars($_SESSION["username"], ENT_QUOTES, 'UTF-8');?>!</h2>
	<div id="digit-clock"></div>
	<a href="logout.php">Logout</a>
	<br><br>
    <h3>Registered Users</h3>
    <table>
        <tr>
            <th><b style="padding-left: 0px;">Username</b></th>
            <th><b style="padding-left: 0px;">Name</b></th>
            <th><b style="padding-left: 0px;">Email</b></th>
            <th><b style="padding-left: 0px;">Phone Number</b></th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlentities($user["username"]); ?></td>
                <td><?php echo htmlentities($user["name"]); ?></td>
                <td><?php echo htmlentities($user["email"]); ?></td>
                <td><?php echo htmlentities($user["phone_number"]); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>