<?php

  require ('db_connect.php');


  $filter = filter_input(INPUT_POST, 'filter', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $story = "";
  $result = "";

  $query = "SELECT * FROM story";
    
      $statement = $db->prepare($query);
     
      $statement->execute(); 

      $stories= $statement->fetchall();

      if(isset($_POST['count'])){
        $country = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $country = preg_replace("#[^0-9a-z]#i", "", $country);
        $abc = "SELECT * FROM story WHERE Country LIKE '%$country%'";
        $aaa = $db->prepare($abc);
        $aaa->execute();
        $result = $aaa->fetchall();
      }

  if(isset($_POST['click'])){
      if($filter != "select"){

    $sql = "SELECT * FROM story WHERE Category = :cat";
    
    $state = $db->prepare($sql);
    $state->bindValue(':cat', $filter);
    $state->execute(); 

    $story= $state->fetchall();
    } 
  }

  if (!isset ($_GET['page']) ) {  
    $page = 1;  
  } else {  
      $page = $_GET['page'];  
  } 

  $results_per_page = 2;  
  $page_first_result = ($page-1) * $results_per_page;  

  $number_of_result = $statement->rowCount(); 

  $number_of_page = ceil ($number_of_result / $results_per_page); 

  $query = "SELECT * FROM story LIMIT " . $page_first_result . ',' . $results_per_page;  
    $rows = $db->prepare($query);
    $rows->execute();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Explore</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
    <form method="post">
    <p>Filter by categories
      <select name="filter">
        <option value="select">Select </option>
        <option value="mount">Mountains</option>
        <option value="beach">Beach</option>
        <option value="gen">General</option>
      </select>
      <button name="click" type="submit">Apply</button>
    </p>
    <p>
      Or search for a country
      <input type="search" name="search">
      <button name="count" type="submit">Search</button>
    </p>
    <?php if($story!=""):?>
      <?php foreach($story as $row): ?>
      <a href="exstory.php?id=<?=$row['StoryID']?>"><h1><?=$row['Title']?></h1></a>
    <?php endforeach ?>
  <?php elseif($result!=""):?>
      <?php foreach($result as $row): ?>
      <a href="exstory.php?id=<?=$row['StoryID']?>"><h1><?=$row['Title']?></h1></a>
    <?php endforeach ?>
  <?php else: ?>
    <?php foreach($rows as $row): ?>
      <a href="exstory.php?id=<?=$row['StoryID']?>"><h1><?=$row['Title']?></h1></a>
    <?php endforeach ?> 
    <?php for($page = 1; $page<=$number_of_page; $page++):?>
      <a href="explore.php?page=<?=$page?>"><?=$page?></a>
    <?php endfor?>
  <?php endif?>

  </form>
  </div>
  
</body>
</html>