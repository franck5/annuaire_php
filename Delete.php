<?php 

		$base = mysqli_connect("localhost", "root", "j9hn2x2", "annuaire");
	$id = $_POST["id"];
	var_dump($id);
	
	$sup = mysqli_query($base, "DELETE FROM annuaire WHERE id = $id");

	header('Location:index.php');

?>