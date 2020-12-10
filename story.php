<?php 
	require('db_connect.php');  

	  $query = "";
	  $id = "";
	  $state = "";

	if (isset($_POST['click'])) {
		
		$option = $_POST['sort'];

		if ($option == "Title") {
			$query = "SELECT * FROM Story ORDER BY $option";
		}elseif ($option == "StoryID") {
			$query = "SELECT * FROM Story ORDER BY StoryID DESC";
			$option = "Newer to Older";
		}else{
			$query = "SELECT * FROM Story ORDER BY StoryID";
			$option = "Older To Newer";
		}
		
	}else{
		$query = "SELECT * FROM Story";
	}
     
	//Prepare Query
	$statement = $db->prepare($query);

	//Execute the query
 	$statement->execute(); 	
 		$comid = "";

 	if (isset($_POST['delcom'])) {
 		echo $comid;
 	 	$delete = "DELETE FROM comment WHERE id = :id";
 	 	$run = $db->prepare($delete);
 	 	$run->bindValue(':id', $comid);
 	 	$run->execute();
 	} 					
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
				<form method="post">
				<p>
					<label>Sort by</label>
					<select name="sort">
						<option value="old">Select</option>
						<option value="old">Older to newer</option>
						<option value="StoryID">Newer to older</option>
						<option value="Title">Title</option>
					</select>
					<button name="click" type="submit">Apply</button>
				</p>
				<label>Currently sorted by :</label>
				<?php if(isset($_POST['click'])):?>
					<label><?=$option?></label>
					<?php else :?>
						<label>Older to newer</label>
				<?php endif?>
				<?php foreach ($statement as $row) : ?>
					<?php $id = $row['StoryID'];?>
					<?php 
						if($id!==""){
					 		$sql = "SELECT * FROM comment WHERE sID = :id";
					 		$state = $db->prepare($sql);
					 		$state->bindValue(':id',$id);
					 		$state->execute();
 						}
					?>
					<h1><?=$row['Title']?></h1>
					<p>
						<?=$row['main']?><br/>
						<?php if ($row['Image']!=""):?>
						<img src="<?=$row['Image']?>" width="500" height="500" />
						<?php endif?>
						
						<button><a href="updatestory.php?id=<?=$row['StoryID']?>">Update</a></button>
						<button><a href="deletestory.php?id=<?=$row['StoryID']?>">Delete</button></a>

						<p>
							<?php if($state!==""):?>
								<h2>Comments</h2>
								<?php foreach($state as $comment):?>
									<p>
										<?= $comment['comment']?>
									
										<?=$comment['id']?>
										<a href="deletecomment.php?id=<?=$comment['id']?>">Delete comment</a>
									</p>
								<?php endforeach?>
							<?php endif?>
						</p>
					</p>
				<?php endforeach?>
				</form>
			</div>
			
		</li>
		<li>
			<a href="logout.php"><button>Logout</button></a>
		</li>
	</div>
</body>
</html>