<?php 
	require('authenticate.php');
 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body id="homepage">
	<div id=title>
		<span id="journey">JOURNEY</span>
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="admin.php">Admin</a></li>
			<li><a href="login.php">myStory</a></li>
			<li><a href="explore.php">Explore</a></li>
		</ul>
	</div>
	<div id="admin_container">
		<div class="descreptive_img">
			<a href="user.php"><img src="user.jpg" width="600px" height="600px"></a>
			<h2 class="description">Users</h2>
		</div>
		<div class="descreptive_img1">
			<a href="mystory.php"><img src="storypage.jpg" width="600px" height="600px"></a>
			<h2 class="description">Stories</h2>
		</div>
	</div>
	
</body>
</html>