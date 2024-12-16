<?php
	// $conn = new mysqli('localhost', 'id21241452_tijabo', 'Tijabo123!', 'id21241452_tijabo');

	// if ($conn->connect_error) {
	//     die("Connection failed: " . $conn->connect_error);
	// }
	
?>

<?php
	$conn = new mysqli('localhost', 'root', '', 'id21241452_tijabo');

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	
?>