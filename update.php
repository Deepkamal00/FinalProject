<?php  
	require('db_connect.php');

	$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

	$sql = "SELECT * FROM users WHERE UserID = :id";
	$statement = $db->prepare($sql);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
	$statement->execute();
	$result = $statement->fetch();

	if($_POST){
		$user = $_POST['uname'];
		$name = $_POST['name'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$query = "UPDATE users SET Username=:user, Name=:name, Email=:email, Phoneno = :phone WHERE UserID = :id";
		$update = $db->prepare($query);
		$update->bindValue(':user', $user);
		$update->bindValue(':name', $name);
		$update->bindValue(':email', $email);
		$update->bindValue(':phone', $phone);
		$update->bindValue(':id', $id, PDO::PARAM_INT);
		if($update->execute()){
			header('location: user.php');
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
	<div id="signup">
		<form method="post">
			<li>
				<input type="text" name="id" value="<?=$result['UserID']?>">
			</li>
			<li>
			<label for="uname">Username </label>
			<input type="text" name="uname" value="<?=$result['Username']?>">
		</li>
		<li>
			<label for="name">Name </label>
			<input type="text" name="name" value="<?=$result['Name']?>">
		</li>
		<li>
			<label for="email">Email </label>
			<input type="email" name="email" value="<?=$result['Email']?>">
		</li>
		<li>
			<label for="phone">Phone Number </label>
			<input type="phone" name="phone" value="<?=$result['Phoneno']?>">
		</li>
		<li>
			<input type="submit" name="submit" value="Update">
			<a href="deleteuser.php?id=<?=$result['UserID']?>"><input type="button" name="delete" value="Delete"></a>
		</li>
		</form>
	</div>
</body>
</html>