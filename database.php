<?php
    function login_mysqli() {
		$mysqli = new mysqli('localhost', 'team15', 'password', 'waph_team15');
		if ($mysqli->connect_errno) {
			printf("Database connection failed: %s\n", $mysqli->connect_error);
			exit();
		}
        return $mysqli;
    }

	function sanitize_input($input) {
		$input = trim($input);
		$input = stripslashes($input);
		$input = htmlspecialchars($input);
		return $input;
	}

	function checklogin_superuser($username, $password) {
		$mysqli = login_mysqli();
		$prepared_sql = "SELECT * FROM superusers WHERE username= ? " . 
		                                " AND password=md5(?);";
		$stmt = $mysqli->prepare($prepared_sql);
		$stmt->bind_param("ss", $username, $password);
		$stmt->execute();
		$result=$stmt->get_result();
		if ($result->num_rows == 1) return TRUE;
		return FALSE;
	}

    function checklogin_mysql($username, $password) {
		$mysqli = login_mysqli();
		$prepared_sql = "SELECT * FROM users WHERE username= ? " . 
		                                " AND password=md5(?);";
		$stmt = $mysqli->prepare($prepared_sql);
		$stmt->bind_param("ss", $username, $password);
		$stmt->execute();
		$result=$stmt->get_result();
		if ($result->num_rows == 1) return TRUE;
		return FALSE;
  	}

	function get_all_users() {
        $mysqli = login_mysqli();
        $prepared_sql = "SELECT username, name, email, phone_number FROM users;";
        $stmt = $mysqli->prepare($prepared_sql);
        $stmt->execute();
        $stmt->bind_result(
            $username,
            $name,
            $email,
            $phone_number
        );

        $users = [];
        while ($stmt->fetch()) {
            $users[] = [
                "username" => $username,
                "name" => $name,
                "email" => $email,
                "phone_number" => $phone_number
            ];
        }

        return $users;
	}

	function get_name($username) {
		$mysqli = login_mysqli();
		$prepared_sql = "SELECT name FROM users WHERE username= ?;";
		$stmt = $mysqli->prepare($prepared_sql);
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$stmt->bind_result($name);

		if ($stmt->fetch()) {
			return $name;
		}
		return null;
	}

	function get_email($username) {
		$mysqli = login_mysqli();
		$prepared_sql = "SELECT email FROM users WHERE username= ?;";
		$stmt = $mysqli->prepare($prepared_sql);
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$stmt->bind_result($email);

		if ($stmt->fetch()) {
			return $email;
		}
		return null;
	}

	function get_phone_number($username) {
		$mysqli = login_mysqli();
		$prepared_sql = "SELECT phone_number FROM users WHERE username= ?;";
		$stmt = $mysqli->prepare($prepared_sql);
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$stmt->bind_result($phone_number);

		if ($stmt->fetch()) {
			return $phone_number;
		}
		return null;
	}

	function addnewuser($username, $password, $name, $email, $phone_number) {
		$mysqli = login_mysqli();
		$prepared_sql = "INSERT INTO users (username, password, name, email, phone_number) VALUES (?, md5(?), ?, ?, ?);";
		$stmt = $mysqli->prepare($prepared_sql);
		$stmt->bind_param("sssss", $username, $password, $name, $email, $phone_number);

		if ($stmt->execute()) return TRUE;
		return FALSE;
  	}

	function updateprofile($username, $name, $email, $phone_number) {
		$mysqli = login_mysqli();
		$prepared_sql = "UPDATE users SET name = ?, email = ?, phone_number = ? WHERE username = ?;";
		$stmt = $mysqli->prepare($prepared_sql);
		$stmt->bind_param("ssss", $name, $email, $phone_number, $username);

		if ($stmt->execute()) return TRUE;
		return FALSE;
  	}

	function add_post($owner, $title, $content) {
        $mysqli = login_mysqli();
        $prepared_sql = "INSERT INTO posts (owner, title, content) VALUES (?, ?, ?);";
		$stmt = $mysqli->prepare($prepared_sql);
		$stmt->bind_param("sss", $owner, $title, $content);

		if ($stmt->execute()) return TRUE;
		return FALSE;
	}

    function get_all_posts() {
        $mysqli = login_mysqli();
        $prepared_sql = "SELECT postID, title, content, date, owner FROM posts ORDER BY date DESC;";
        $stmt = $mysqli->prepare($prepared_sql);
        $stmt->execute();
        $stmt->bind_result(
            $postID,
            $title,
            $content,
            $date,
            $owner
        );

        $posts = [];
        while ($stmt->fetch()) {
            $posts[] = [
                "postID" => $postID,
                "title" => $title,
                "content" => $content,
                "date" => $date,
                "owner" => $owner
            ];
        }

        return $posts;
    }

    function get_post($postID) {
        $mysqli = login_mysqli();
        $prepared_sql = "SELECT postID, title, content, date, owner FROM posts WHERE postID = ?;";
        $stmt = $mysqli->prepare($prepared_sql);
        $stmt->bind_param("i", $postID);
        $stmt->execute();
        $stmt->bind_result(
            $postID,
            $title,
            $content,
            $date,
            $owner
        );
        $stmt->fetch();
        $post = [
            "postID" => $postID,
            "title" => $title,
            "content" => $content,
            "date" => $date,
            "owner" => $owner
        ];

        return $post;
    }

    function update_post($postID, $title, $content) {
        $mysqli = login_mysqli();
        $prepared_sql = "UPDATE posts SET title=?, content=? WHERE postID=?;";
		$stmt = $mysqli->prepare($prepared_sql);
		$stmt->bind_param("ssi", $title, $content, $postID);

		if ($stmt->execute()) return TRUE;
		return FALSE;
    }

    function delete_post($postID) {
        $mysqli = login_mysqli();
        $prepared_sql = "DELETE FROM posts WHERE postID = ?;";
        $stmt = $mysqli->prepare($prepared_sql);
        $stmt->bind_param("i", $postID);

		if ($stmt->execute()) return TRUE;
		return FALSE;
    }

	function add_comment($postID, $owner, $content) {
		$mysqli = login_mysqli();
		$prepared_sql = "INSERT INTO comments (postID, owner, content) VALUES (?, ?, ?);";
		$stmt = $mysqli->prepare($prepared_sql);
		$stmt->bind_param("iss", $postID, $owner, $content);

		if ($stmt->execute()) return TRUE;
		return FALSE;
	}

	function get_comments($postID) {
		$mysqli = login_mysqli();
		$prepared_sql = "SELECT commentID, owner, content, date FROM comments WHERE postID = ? ORDER BY date ASC;";
		$stmt = $mysqli->prepare($prepared_sql);
		$stmt->bind_param("i", $postID);
		$stmt->execute();
		$stmt->bind_result(
			$commentID,
			$owner,
			$content,
			$date
		);

		$comments = [];
        while ($stmt->fetch()) {
            $comments[] = [
                "commentID" => $commentID,
                "owner" => $owner,
                "content" => $content,
                "date" => $date
            ];
        }

        return $comments;
	}
?>