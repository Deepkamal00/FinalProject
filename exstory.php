<?php 
	require('db_connect.php');

	$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

	$sql = "SELECT * FROM story WHERE StoryID = :id";
	$statement = $db->prepare($sql);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
	$statement->execute();
	$result = $statement->fetch();
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
      	<img src="<?=$result['Image']?>_medium.jpg">
      <?php endif?>
      <form method="post">
      <p>
        <label>Add Comment</label>
        <textarea name="comment"></textarea>
        <button value="submit">Submit</button>
      </p></form>
  	</div>
</body>
</html>