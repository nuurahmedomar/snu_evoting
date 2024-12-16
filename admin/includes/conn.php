<?php
	$conn = new mysqli('localhost', 'root', '', 'id21241452_tijabo');

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	
?>