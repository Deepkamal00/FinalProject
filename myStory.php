<?php 
	require('db_connect.php');   

	session_start();
	  if(!isset($_SESSION['user']))
	  {
	    //header('location: login.php');
	  }

	  $query = "SELECT * from Story";
     
	//Prepare Query
	$statement = $db->prepare($query);

	//Execute the query
 	$statement->execute(); 					
?>

<!DOCTYPE html>
<html>
<head>
	<title>myStory</title>
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
	<div>
		<li><a href="create.php">Create a new story</a></li>
		<li>Your previous stories:
			<div id="stories">
				<?php foreach ($statement as $row) : ?>
					<h1><?=$row['Title']?></h1>
					<p>
						<?=$row['main']?><br/>
						<?php if ($row['Image']!=""):?>
						<img src="<?=$row['Image']?>_medium.jpg">
						<?php endif?>
						<button><a href="updatestory.php?id=<?=$row['StoryID']?>">Update</a></button>
						<button><a href="deletestory.php?id=<?=$row['StoryID']?>">Delete</button></a>
					</p>
				<?php endforeach?>
			</div>
			
		</li>
		<li>
			<a href="logout.php"><button>Logout</button></a>
		</li>
	</div>
</body>
</html>