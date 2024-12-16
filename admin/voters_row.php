<?php 
	include 'includes/session.php';

	if(isset($_POST['id'])){
		$id = $_POST['id'];
		$sql = "SELECT * , voters.id AS id FROM voters LEFT JOIN positions ON
		positions.id = voters.position_id WHERE voters.id = '$id'";
		// $sql = "SELECT * FROM voters WHERE id = '$id'";
		$query = $conn->query($sql);
		$row = $query->fetch_assoc();

		echo json_encode($row);
	}
?>