<?php 
	require('db_connect.php');

	$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
	$comment ="";
	$sql = "SELECT * FROM story WHERE StoryID = :id";
	$statement = $db->prepare($sql);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
	$statement->execute();
	$result = $statement->fetch();

	$query = "SELECT * FROM comment WHERE sID = :id";
	$state = $db->prepare($query);
	$state->bindValue(':id', $id, PDO::PARAM_INT);
	if($state->execute())
	{
		$comment = $state->fetchall();
	}
	
	if ($_POST) {
		$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
		$comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

		$query = "INSERT INTO comment (name, email, comment, sID) VALUES (:name, :email, :comment, :id)";
		$state = $db->prepare($query);
		$state->bindValue(':name', $name);
		$state->bindValue(':email', $email);
		$state->bindValue(':comment', $comment);
		$state->bindValue(':id', $id);
		if($state->execute()){
			header("location: exstory.php?id=".$id);
		}
	}

	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Explore</title>
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
    <div id="stories">
      <h1><?=$result['Title']?></h1>
      <p><?=$result['main']?></p>
      <?php if($result['Image'] != ""):?>
      	<img src="<?=$result['Image']?>" width="500px" height=500px />
      <?php endif?>

      <?php if($comment!=""):?>
      	<h2>COMMENTS</h2>
      	<?php foreach($comment as $row): ?>
      		<p><?=$row['comment']?></p>
      	<?php endforeach?>
      <?php endif?>
      <p>
      	<h2>Add a comment:</h2>
      	<form method="post">
			<p>
				<label>Name: </label>
				<input type="text" name="name" />
				<label>Email: </label>
				<input type="text" name="email" />
		        <label>Add Comment</label>
		        <textarea name="comment"></textarea>
		        <button type="submit" value="submit">Submit</button>
		    </p>
		</form>
      </p>

      
  	</div>
</body>
</html>