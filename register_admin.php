<?php
if (isset($_POST['add'])) {
    // Your database connection and insertion code
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "id21241452_tijabo";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $created_date = $_POST['date'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $filename = $_FILES['photo']['name'];

    if (!empty($filename)) {
        move_uploaded_file($_FILES['photo']['tmp_name'], 'images/' . $filename);
    }

    $sql = "INSERT INTO admin (username, password, firstname, lastname, photo, created_on) 
            VALUES ('$username', '$password', '$firstname', '$lastname', '$filename', '$created_date')";


    if ($conn->query($sql)) {
        echo '<span id="successMessage">Registration successful!</span>';
        echo '<script>
                function redirectToSuccess() {
                    window.location.replace("registration_success.php");
                }

                if (document.getElementById("successMessage")) {
                    setTimeout(redirectToSuccess, 1000); // Redirect after 3 seconds
                }
              </script>';
    } else {
        echo 'Error: ' . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>SNU Voting System</title>
    <style>
        /* Your CSS styles */
        
      body {
        background: #d2d6de;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        font-family: Arial, sans-serif;
      }
      h1 {
        text-align: center;
        font-size: 36px;
        color: #333;
      }
      h4 {
        color: #949085;
        font-size: 15px;
      }
      .modal-content {
        background: #fff;
        padding: 10px; /* Adjusted padding */
        border-radius: 0; /* Removed border-radius */
        text-align: center;
      }
      .form-group {
        margin-bottom: 10px; /* Reduced margin */
      }
      input {
        width: calc(100% - 20px); /* Adjusted input width */
        padding: 8px;
        margin: 5px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
      }
      input::placeholder {
        font-size: 14px; /* Increased size of placeholders */
      }
      label {
        text-align: left;
        display: block;
        margin-left: 10px;
        margin-bottom: 5px;
        color: #333;
      }
      .modal-footer {
        text-align: center;
      }
      button {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        background-color: #337ab7;
        color: #fff;
        cursor: pointer;
        font-size: 16px;
      }
      p a {
        text-decoration: none;
      }
      a:hover{
        color: red;
      }
      #successMessage {
        display: none;
        text-align: center;
        padding: 20px;
        background-color: #4CAF50;
        color: white;
        margin-top: 20px;
      }

        /* ... */
    </style>
</head>
<body>
    <!-- Your HTML content -->
    
    <div class="modal fade" id="addnew">
        <!-- Your form and other HTML content -->
        <h1>SNU Voting System</h1>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><b>Admin Registration Form</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="register_admin.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Firstname" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Lastname" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="photo" class="col-sm-3 control-label">Photo</label>
                        <div class="col-sm-9">
                            <input type="file" id="photo" name="photo">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="date" class="col-sm-3 control-label">Created Date</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" id="date" name="date">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-flat" name="add"><i class="fa fa-save"></i> Save</button>
                        <p>Already have an account? <a href="/e-voting/admin/">Sign in</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    <!-- ... -->
</body>
</html>
