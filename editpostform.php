<?php
    require "database.php";
    require "session_auth.php";

    $postID = $_GET["id"];
    $post = get_post($postID);

    if ($post["owner"] != $_SESSION["username"]) {
		session_destroy();
		echo "<script>alert('The non-owner of this post is trying to make an edit!';</script>)";
        header("Refresh:0; url=form.php");
		die();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>WAPH miniFacebook - Edit Post</title>
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
        <h1>WAPH miniFacebook - Edit Post</h1>
        <h2>Team 15</h2>
        <div id="digit-clock"></div>
        <?php
            $rand = bin2hex(openssl_random_pseudo_bytes(16));
            $_SESSION["nocsrftoken"] = $rand;        
        ?>
        <br>
        <form action="editpost.php" method="post" class="form-container">
            <input type="hidden" name="postID" value="<?php echo $post["postID"]; ?>">
            Title
            <input type="text" name="title" value="<?php echo htmlentities($post["title"]); ?>" required>
            Content
            <textarea name="content" rows="8" cols="60" required><?php echo htmlentities($post["content"]); ?></textarea>
            <input type="hidden" name="nocsrftoken" value="<?php echo $rand; ?>"/>
            <button class="button" type="submit">Save Changes</button>
        </form>
    </body>
    <a href="index.php">Go back</a>
</html>