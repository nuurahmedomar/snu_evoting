<?php
  	session_start();
  	if(isset($_SESSION['admin'])){
    	header('location:home.php');
  	}
?>
<?php include 'includes/header.php'; ?>
<style>
	.login-box-body .row {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
		p {
			text-align: center;
			margin-top: 10px;
			font-size: 18px;
			color: black;
		}
		a:hover{
			color: red;
		}
</style>
<body class="hold-transition login-page" style="background: red !important;">
<link rel="icon" href="../logo.jpeg" type="image/jpeg" />

<div class="login-box">
  	<div class="login-logo" style="color:white !important;">
  		<b>SNU Voting System</b>
  	</div>
  
  	<div class="login-box-body">
    	<p class="login-box-msg">Sign in</p>

    	<form action="login.php" method="POST">
      		<div class="form-group has-feedback">
        		<input type="text" class="form-control" name="username" placeholder="Username" required>
        		<span class="glyphicon glyphicon-user form-control-feedback"></span>
      		</div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
      		<div class="row">
    			<div class="col-xs-4">
          			<button type="submit" class="btn btn-info btn-block btn-flat" name="login"><i class="fa fa-sign-in"></i> Gal </button>
        		</div>
      		</div>
					<!-- <p>Donot have an ccount? <a href="../register_admin.php/">Register here</a></p> -->
    	</form>
  	</div>
  	<?php
  		if(isset($_SESSION['error'])){
  			echo "
  				<div class='callout callout-danger text-center mt20'>
			  		<p>".$_SESSION['error']."</p> 
			  	</div>
  			";
  			unset($_SESSION['error']);
  		}
  	?>
</div>
	
<?php include 'includes/scripts.php' ?>
</body>
</html>