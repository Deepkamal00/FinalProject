<?php
	require('db_connect.php');
	$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

	$sql = "DELETE FROM comment WHERE id = :id";
	$statement = $db->prepare($sql);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
	$statement->execute();
    header('Location:story.php');
?>