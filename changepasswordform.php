<?php
    require "session_auth.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>WAPH miniFacebook - Change Password</title>
        <script type="text/javascript">
            function displayTime() {
                document.getElementById('digit-clock').innerHTML = "Current time: " + new Date();
            }
            setInterval(displayTime, 500);
        </script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <h1>WAPH miniFacebook - Change Password</h1>
        <h2>Team 15</h2>
        <div id="digit-clock"></div>
        <?php
            $rand = bin2hex(openssl_random_pseudo_bytes(16));
            $_SESSION["nocsrftoken"] = $rand;
        ?>
        <br>
        <form action="changepassword.php" method="POST" class="form login form-container">
            New Password: <input type="password" class="text_field" name="newpassword" required
                             pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&])[\w!@#$%^&]{8,}$"
                             placeholder="New password"
                             title="Password must have at least 8 characters with 1 special symbol !@#$%^& 1 number, 1 lowercase, and 1 UPPERCASE">
            <input type="hidden" name="nocsrftoken" value="<?php echo $rand; ?>"/>
            <button class="button" type="submit">Change password</button>
        </form>
        <a href="index.php">Go back</a>
    </body>
</html>

