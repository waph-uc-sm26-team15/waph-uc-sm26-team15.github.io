<?php
    require "session_auth.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>WAPH miniFacebook - Profile Management</title>
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
        <h1>WAPH miniFacebook - Profile Management</h1>
        <h2>Team 15</h2>
        <div id="digit-clock"></div>
        <?php
            $rand = bin2hex(openssl_random_pseudo_bytes(16));
            $_SESSION["nocsrftoken"] = $rand;        
        ?>
        <br>
        <form action="profilemanagement.php" method="post" class="form-container">
            Username: <?php echo $_SESSION["username"]; ?><br>
            Name:<input type="text" class="text_field" name="name" required
                        pattern="^[A-Za-z]+([\s'.-][A-Za-z]+)*$"
                        placeholder="First and Last name"
                        title="Letters and spaces only">
            Email:<input type="text" class="text_field" name="email" required
                        pattern="^[\w.-]+@[\w-]+(.[\w-]+)*$"
                        placeholder="Your email address"
                        title="Please enter a valid email address">
            Phone Number:<input type="text" class="text_field" name="phone_number" required
                        pattern="^\(?\d{3}\)?[-.\s]?\d{3}[-.\s]?\d{4}$"
                        placeholder="Your phone number"
                        title="Please enter a valid phone number">
            <input type="hidden" name="nocsrftoken" value="<?php echo $rand; ?>"/>
            <button class="button" type="submit">Update Profile</button>
        </form>
        <a href="index.php">Go back</a>
    </body>
</html>

