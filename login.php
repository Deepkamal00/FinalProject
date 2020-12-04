<?php 
	require('db_connect.php');
	Session_start();

	if(isset($_POST['username']) &&isset($_POST['password'])){
		$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

		$sql= "SELECT * FROM Users WHERE Username = '$username'";

		$statement = $db->prepare($sql);

		if($statement->execute()){
			$hash_check = $statement->fetch();
			$pass = $hash_check['Password'];
			$pass = trim($pass);

			if(password_verify($password, $pass)){
				$_SESSION['user'] = $username;  
				header('location: myStory.php');
			}
			else{
				echo '<h1>Invalid Username or Password</h1>';
				echo $pass;
				echo strlen($pass);
				echo $password;
				header('location: myStory.php' );
			}
		}
	}
	
 ?>

<!DOCTYPE html>
<html>
<head>
	<title>login</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body id="homepage">
	<form id="login_credentials" method="post">
		<li>
			<label for="username">Username </label>
			<input type="text" name="username">
		</li>
		<li>
			<label for="password">Password </label>
			<input type="Password" name="password">
		</li>
		<li>
			<button type="submit" name="submit" value="submit">Login</button>
		</li>

		<span>Do not have an account, <a href="signup.php">Create Account</a>.</span>
	</form>
	<div id=title>
		<span id="journey">JOURNEY</span>
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="admin.php">Admin</a></li>
			<li><a href="login.php">myStory</a></li>
			<li><a href="explore.php">Explore</a></li>
		</ul>
	</div>
</body>
</html>

