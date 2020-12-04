<?php

  require ('db_connect.php');
    
    $query = "SELECT * FROM story";

    
    $statement = $db->prepare($query);
    
    //$statement->bindValue(':id', $id, PDO::PARAM_INT);
   
    $statement->execute(); 

    $stories= $statement->fetchall();

    if($_POST){
      $comment = $_POST['comment'];

      $sql = "INSERT INTO Story(Comment) VALUES ($comment)";
      $run = $db->prepare($sql);
      $run->execute();
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
    <?php foreach($stories as $row): ?>
      <a href="exstory.php?id=<?=$row['StoryID']?>"><h1><?=$row['Title']?></h1></a>
    <?php endforeach ?>
  </div>
  
</body>
</html>