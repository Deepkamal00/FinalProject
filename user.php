<?php
	require('db_connect.php');

	$name ="";

	$sql = "SELECT * FROM users";
	$statement = $db->prepare($sql);
	$statement->execute();

	$query_result = $statement->fetchall();

	if($_POST){

	    
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Users</title>
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
	<form method="post">
	<?php foreach ($query_result as $row): ?>
		<div class="users11">
			<h1><?=$row['Username']?></h1>
			<?php $name = $row['Name']?>
			<div class="info">
				<h3><?=$row['Name']?></h3>
				<h3><?=$row['Email']?></h3>
				<h3><?=$row['PhoneNo']?></h3>
			</div>
			<a href="update.php?id=<?=$row['UserID']?>"><button type="button" class="buttons">Update</button></a>
		</div>
	<?php endforeach ?>
	</form>
</body>
</html>