<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>WAPH miniFacebook - Login Page</title>
    <script type="text/javascript">
        function displayTime() {
          const options = {
            month: 'short', // 'Jun'
            day: '2-digit', // '24'
            hour: '2-digit', // '07'
            minute: '2-digit', // '03'
            second: '2-digit', // '45'
            hour12: true // 'am'
          };
          const formattedTime = new Date().toLocaleString('en-US', options).replace(/,/, '');
          document.getElementById('digit-clock').innerHTML = "Current time: " + formattedTime;
        }
        setInterval(displayTime,500);
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <h1>WAPH miniFacebook - Login Page</h1>
    <h2>Team 15</h2>
    <div id="digit-clock"></div>  
  <?php
    $rand = bin2hex(openssl_random_pseudo_bytes(16));
    $_SESSION["nocsrftoken"] = $rand;  
  ?>
    <br>
    <form action="index.php" method="POST" class="form login form-container">
      Username:<input type="text" class="text_field" name="username" required
                      pattern="\w+"
                      placeholder="Your username"
                      title="3-50 characters: letters, numbers, and underscores only">
      Password: <input type="password" class="text_field" name="password" required
                      pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&])[\w!@#$%^&]{8,}$"
                      placeholder="Your password"
                      title="Password must have at least 8 characters with 1 special symbol !@#$%^& 1 number, 1 lowercase, and 1 UPPERCASE"
                      onchange="this.setCustomValidity(this.validity.patternMismatch?this.title: ''); form.repassword.pattern = this.value;">
      <input type="hidden" name="nocsrftoken" value="<?php echo $rand; ?>"/>
      <button class="button" type="submit">Login</button>
    </form>
    <span>Don't have an account?<a href="registrationform.php">Sign up</a></span>
  </body>
</html>
