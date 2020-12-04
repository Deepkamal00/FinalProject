<?php 
	require('db_connect.php');

	$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

	$sql = "SELECT * FROM Story WHERE StoryID = :id";
	$statement = $db->prepare($sql);
  $statement->bindValue(':id', $id, PDO::PARAM_INT);
	$statement->execute();
	$result = $statement->fetch();

	if(isset($_POST['submit'])){
    if(isset($_POST['uploaded_file'])){
      $image_filename = $_FILES['uploaded_file']['name'];
          $temporary_image_path  = $_FILES['uploaded_file']['tmp_name'];
          $new_image_path = './uploads'. $image_filename ;

          $allowed_file_extensions[] = ['jpg', 'png', 'jfif', 'gif'];

          $actual_file_extension = pathinfo($new_image_path, PATHINFO_EXTENSION);

          //$actual_mime_type = mime_content_type($temporary_image_path);

          $extention_is_valid = in_array($actual_file_extension, $allowed_file_extensions);

          //$mime_is_valid = in_array($actual_mime_type, $allowed_mime_types);

              move_uploaded_file($temporary_image_path, $new_image_path);

              $image_medium = new Gumlet\ImageResize($new_image_path);
              $image_medium->resizeToWidth(400);
              $image_medium->save($new_image_path.'_medium'.'.'.$actual_file_extension);

               $image_thumbnail = new Gumlet\ImageResize($new_image_path);
              $image_thumbnail->resizeToWidth(50);
              $image_thumbnail->save($new_image_path.'_thumbnail'.'.'.$actual_file_extension);
            }
    $title = $_POST['title'];
    $main = $_POST['main'];

    $sql = "UPDATE Story SET Title = :title, main = :main WHERE StoryID = :id";
    $statement = $db->prepare($sql);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':main', $main);
    $statement->bindValue(':id', $id);
    if ($statement->execute()) {
      header("location: myStory.php");
    }
  }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Update</title>
  <link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body id="homepage">
<div id="all_stories">
  <form method="post">
    <fieldset>
      <p>
        <label for="title">Title</label>
        <input type="text" name="title" id="title1"  value="<?=$result['Title']?>" />
      </p>
      <p>
        <label for="main">Content</label>
        <textarea name="main" id="main" rows="15" ><?=$result['main']?></textarea>
      </p>
      <p>
        <?php if($result['Image']!=""):?>
          <img src="<?=$result['Image']?>_medium.jpg">
        <button>Delete Image</button>
        <?php endif?>
      </p>
      <p>
        <?php if($result['Image']!=""): ?>
          <label>Replace the old image with new one</label><br>
          <label>File name:</label>
          <input type="file" name="uploaded_file1" id="uploaded_file" />  
          <?php else:?>
            <label>Add an image to your story</label>
            <label>File name:</label>
            <input type="file" name="uploaded_file2" id="uploaded_file" />  
        <?php endif?>
      </p>
      <p>
        <input type="submit" name="submit" value="Create" />
      </p>
    </fieldset>
  </form> 
</div>
</body>
</html>