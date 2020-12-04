<?php 
	require('db_connect.php');
	
	Session_Start(); 

	if($_POST) {
	
	if ($_POST["vercode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')
            {
                 echo  '<strong>Incorrect verification code. Retry...</strong>';
            }
            else{

        if($_POST['uname'] !== "" && $_POST['name'] !== "" && $_POST['email'] !== "" ){
            $userName = filter_input(INPUT_POST, 'uname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $Password = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $confirm_password = filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $Name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $phone = filter_input(INPUT_POST, 'phone', FILTER_VALIDATE_INT);

            $hash = password_hash('$Password', PASSWORD_DEFAULT);

            if($Password == $confirm_password){
            	$query = "INSERT INTO users(Name, Username, Password,Email, PhoneNo) values (:Name, :uname, :pass, :email, :phone)";
            
	            $Statement = $db->prepare($query);
	            $Statement->bindValue(':Name', $Name);
	            $Statement->bindValue(':uname', $userName);
	            $Statement->bindValue(':pass', $hash);
	            $Statement->bindValue(':email', $email);
	            $Statement->bindValue(':phone', $phone);
	            $Statement->execute();

	            $insert_id = $db->lastInsertId();

	            header('location: login.php');
	        }

            else{
            	echo '<script>alert("Passwords doesnt match")</script>';            
            }

            
        }
        else{
            echo '<script> alert("Incomplete Data, All fields are required") </script>';
        }
}

		     
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>SignUp</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body id="homepage">
	
	<div id="signup">
		<form method="post">
		<li>
			<label for="uname">Username </label>
			<input type="text" name="uname">
		</li>
		<li>
			<label for="name">Name </label>
			<input type="text" name="name">
		</li>
		<li>
			<label for="dob">Date Of Birth</label>
			<input type="date" name="dob">
		</li>
		<li>
			<label for="email">Email </label>
			<input type="email" name="email">
		</li>
		<li>
			<label for="phone">Phone Number </label>
			<input type="phone" name="phone">
		</li>
		<li>															
			<label for="pass">Password</label>
			<input type="Password" name="pass">
		</li>
		<li>
			<label>Confirm Password</label>
			<input type="Password" name="confirm_password">
		</li>
		<li>
			<label for="captcha">Please Enter the Captcha Text</label>
		    <img src="captcha.php" alt="CAPTCHA" class="captcha-image">
		    <input type="text" id="captcha" name="vercode">
		</li>

		<button type="submit" name="command" value="Submit" >Submit</button>
	</form>
	</div>
</body>
</html>