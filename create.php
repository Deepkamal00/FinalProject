<?php 
  require('db_connect.php');

  session_start();

  if(!isset($_SESSION['user']))
  {
    //header('location: login.php');
  }

  include 'lib\ImageResize.php';
  include 'lib\ImageResizeException.php';

  $error = false;

  $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $content = filter_input(INPUT_POST, 'main', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $category = filter_input(INPUT_POST, 'cat', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  echo $category;

    if($title != "" && $content != "" ){

          $image_filename = $_FILES['uploaded_file']['name'];
          $temporary_image_path  = $_FILES['uploaded_file']['tmp_name'];
          $new_image_path = './uploads'. $image_filename ;

          $allowed_file_extensions[] = ['jpg', 'png', 'jfif', 'gif'];

          $actual_file_extension = pathinfo($new_image_path, PATHINFO_EXTENSION);

          $extention_is_valid = in_array($actual_file_extension, $allowed_file_extensions);

            
            move_uploaded_file($temporary_image_path, $new_image_path);
          
//             $image_medium = new Gumlet\ImageResize($new_image_path);
  //           $image_medium->resizeToWidth(400);
    //         $image_medium->save($new_image_path.'_medium'.'.'.$actual_file_extension);
//
  //           $image_thumbnail = new Gumlet\ImageResize($new_image_path);
    //         $image_thumbnail->resizeToWidth(50);
      //       $image_thumbnail->save($new_image_path.'_thumbnail'.'.'.$actual_file_extension);
            

      $query = "INSERT INTO story(Title, main, Image, Category, Country) VALUES (:title, :main, :image, :cat, :country)";
      
      $Statement = $db->prepare($query);

      $Statement->bindValue(':title', $title);
      $Statement->bindValue(':main', $content);
      $Statement->bindValue(':image', $new_image_path);
      $Statement->bindValue(':cat', $category);
      $Statement->bindValue(':country', $country);

      $Statement->execute();

      $insert_id = $db->lastInsertId();

      header('location: myStory.php');
    }  
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Create story</title>
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
<div id="all_stories">
  <form method="post" enctype="multipart/form-data">
    <fieldset>
      <?php if ($error): ?>
        <p><?= $error ?></p>
      <?php endif ?>

      <legend>New Story</legend>
      <p>
        <label for="title">Title</label>
        <input type="text" name="title" id="title1" />
      </p>
      <p>
        <label>Country: </label>
        <input type="text" name="country" />
      </p>
      <p>
        <label for="main">Content</label>
        <textarea name="main" id="main" rows="15"></textarea>
      </p>
      <p>
        <label>Chose a category for your story</label>
        <input type="radio" name="cat" id="mount" value="mount"> Mountains<br/>
        <input type="radio" name="cat" id="beach" value="beach"> Beach<br/>
        <input type="radio" name="cat" id="gen" value="gen" checked/> General <br/>
      </p>
      <p>
        <label>Images</label><br>
        <label>File name:</label>
        <input type="file" name="uploaded_file" id="uploaded_file" />  
      </p>
      <p>
        <input type="submit" name="submit" value="Create" />
      </p>
    </fieldset>
  </form> 
</body>
</html>