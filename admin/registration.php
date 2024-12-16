<?php
session_start();
if(isset($_SESSION['user'])){
  header("Location: index.php");
} 

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Registration</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="style.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <?php
    if(isset($_POST['submit'])){
      $fullname = $_POST['fullname'];
      $email = $_POST['email'];
      $password = $_POST['password'];
      $repeat_password = $_POST['repeat_password'];

      $password_hash = password_hash($password, PASSWORD_DEFAULT);


      $errors = array();
      if(empty($fullname) OR empty($email) OR empty($password) OR empty($repeat_password)){
        array_push($errors, "All fields are required !");
      }
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        array_push($errors, "Email is not valid !");
      }
      if(strlen($password) < 8){
        array_push($errors, "Password must be at least 8 characters long !");
      }
      if($password !== $repeat_password ){
        array_push($errors, "Passwords does not match !");
      }
      require_once('database.php');
      $sql = "SELECT * FROM admin where username = '$email'";
      $result = mysqli_query($conn, $sql);
      $rowCount = mysqli_num_rows($result);
      if($rowCount > 0){
        array_push($errors, "This email is  already taken !");
      }

      if(count($errors) > 0){
        foreach($errors as $error){
          echo "<div class='alert alert-danger'>$error</div>";
        }
      } else{
        // We will insert data into databse
        $sql = "INSERT INTO admin (firstname, username, password) VALUES (?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        $preparestmt = mysqli_stmt_prepare($stmt,$sql);
        if($preparestmt){
          mysqli_stmt_bind_param($stmt,"sss",$fullname, $email,  $password_hash);
          mysqli_stmt_execute($stmt);
          echo "<div class='alert alert-success'>You are registered successfully.</div>";
      } else {
        die("Something went wrong..");
      }
    }
  }

    ?>
    <form action="registration.php" method="post">
      <div class="form-group">
        <input type="text" class="form-control" name="fullname" placeholder="Full name">
      </div>
      <div class="form-group">
        <input type="email" name="email" class="form-control" placeholder="Email">
      </div>
      <div class="form-group">
        <input type="password" class="form-control" name="password" placeholder="Password">
      </div>
      <div class="form-group">
        <input type="password" name="repeat_password" class="form-control" placeholder="Confirm password">
      </div>
      <div class="form-btn">
        <input type="submit" value="Register"  name="submit" class="btn btn-primary">
      </div>
    </form>
    <div><p>Aleady registered <a  href="index.php">Login here</a></p></div>
  
  </div>
  
</body>
</html>