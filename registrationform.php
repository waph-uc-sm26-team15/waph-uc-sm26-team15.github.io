<?php
  require "csrf.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>WAPH miniFacebook - New User Registration</title>
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
  <h1>WAPH miniFacebook - New User Registration</h1>
  <h2>Team 15</h2>
  <div id="digit-clock"></div>  
<?php
	$lifetime = 15 * 60;
	$path = "/";
	$domain = "192.168.56.7";
	$secure = TRUE;
	$httponly = TRUE;
	session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);  
  session_start();

  $rand = bin2hex(openssl_random_pseudo_bytes(16));
	$_SESSION["nocsrftoken"] = $rand;
?>
  <br>
  <br>
  <form action="addnewuser.php" method="POST" class="form-container">
    Username:<input type="text" class="text_field" name="username" required
                    pattern="\w+"
                    placeholder="Your username"
                    title="3-50 characters: letters, numbers, and underscores only"><br>
    Name:<input type="text" class="text_field" name="name" required
                pattern="^[A-Za-z]+([\s'.-][A-Za-z]+)*$"
                placeholder="First and Last name"
                title="Letters and spaces only"><br>
    Email:<input type="text" class="text_field" name="email" required
                 pattern="^[\w.-]+@[\w-]+(.[\w-]+)*$"
                 placeholder="Your email address"
                 title="Please enter a valid email address"><br>
    Phone Number:<input type="text" class="text_field" name="phone_number" required
                 pattern="^\(?\d{3}\)?[-.\s]?\d{3}[-.\s]?\d{4}$"
                 placeholder="Your phone number"
                 title="Please enter a valid phone number"><br>
    Password: <input type="password" class="text_field" name="password" required
                     pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&])[\w!@#$%^&]{8,}$"
                     placeholder="Your password"
                     title="Password must have at least 8 characters with 1 special symbol !@#$%^& 1 number, 1 lowercase, and 1 UPPERCASE"
                     onchange="this.setCustomValidity(this.validity.patternMismatch?this.title: ''); form.repassword.pattern = this.value;"><br>
    Retype Password: <input type="password" class="text_field" name="repassword"
                            placeholder="Retype your password"
                            title="Password does not match"
                            onchange="this.setCustomValidity(this.validity.patternMismatch?this.title: '');"><br>
    <input type="hidden" name="nocsrftoken" value="<?php echo $token; ?>">
    <button class="button" type="submit">Add User</button>
  </form>
</body>
</html>
