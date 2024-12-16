<?php
	include 'includes/conn.php';
	session_start();

	if(isset($_SESSION['voter'])){
		$sql = "SELECT * FROM voters WHERE id = '".$_SESSION['voter']."'";
		$query = $conn->query($sql);
		$voter = $query->fetch_assoc();
// Retrieve the associated position_id for the voter
		$voter_position_id = $voter['position_id'];
	}
	else{
		header('location: index.php');
		exit();
	}

?>