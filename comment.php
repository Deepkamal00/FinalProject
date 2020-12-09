<?php 
	require('db_connect.php');

	$storyID = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

	if ($_POST) {
		echo $storyID;
		$name = $_POST['name'];
		$email = $_POST['email'];
		$comment = $_POST['comment'];

		$query = "INSERT INTO comment (name, email, comment, sID) VALUES (:name, :email, :comment, :id)";
		$state = $db->prepare($query);
		$state->bindValue(':name', $name);
		$state->bindValue(':email', $email);
		$state->bindValue(':comment', $comment);
		$state->bindValue(':id', $storyID);
		if($state->execute()){
			header("location: exstory.php?id=".$storyID);
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Comment</title>
</head>
<body>
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
</body>
</html>