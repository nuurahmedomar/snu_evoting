<!-- <?php
	session_start();
	include 'includes/conn.php';

	if(isset($_POST['login'])){
		$username = $_POST['username'];
		$password = $_POST['password'];

		$sql = "SELECT * FROM admin WHERE username = '$username'";
		$query = $conn->query($sql);

		if($query->num_rows < 1){
			$_SESSION['error'] = 'Incorrect username or password';
		}
		else{
			$row = $query->fetch_assoc();
			if(password_verify($password, $row['password'])){
				$_SESSION['admin'] = $row['id'];
			}
			else{
				$_SESSION['error'] = 'Incorrect username or password';
			}
		}
		
	}
	else{
		$_SESSION['error'] = 'Input admin credentials first';
	}

	header('location: index.php');

?> -->


<?php
session_start();
include 'includes/conn.php'; // Make sure this file includes the database connection

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT id, password FROM admin WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows < 1){
        $_SESSION['error'] = 'Incorrect username or password';
    }
    else{
        $row = $result->fetch_assoc();
        if(password_verify($password, $row['password'])){
            $_SESSION['admin'] = $row['id']; // Store the admin's unique identifier (ID) in the session
        }
        else{
            $_SESSION['error'] = 'Incorrect username or password';
        }
    }
}
else{
    $_SESSION['error'] = 'Input admin credentials first';
}

header('location: index.php');
?>
