<?php
	require_once '../models/user.php';
    require_once '../controllers/Authcontroller.php';
	
	if(isset($_POST['inputEmail'])&& isset( $_POST['inputPassword'])&&isset($_POST['inputName'])&& isset( $_POST['inputphone'])){
		if(!empty($_POST['inputEmail'])&&!empty($_POST['inputPassword']&&!empty($_POST['inputName'])&&!empty($_POST['inputphone']))){
			$user=new user;
			$auth =new Authcontroller;
			$user->setemail($_POST['inputEmail']);
			$user->setpassword($_POST['inputPassword']);
			$user->setphone($_POST['inputphone']);
			$user->setusername($_POST['inputName']);
			 if($auth->register($user)){
				header("location:index.php");
			 }
			 else{
				$errMsg=$_SESSION["errMsg"];
				if($errMsg!==""){
					echo "<script>alert('$errMsg')</script>";
					$_POST['inputEmail']="";
					$_POST['inputPassword']="";
				}
			 }
		}	

	}
	
	
    
?>


<!DOCTYPE html>
<html lang="en">

<head>
		<meta charset="utf-8">
		<title>Sign Up</title>
		<meta name="description" content="#">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Bootstrap core CSS -->
		<link href="dist/css/lib/bootstrap.min.css" type="text/css" rel="stylesheet">
		<!-- Swipe core CSS -->
		<link href="dist/css/swipe.min.css" type="text/css" rel="stylesheet">
		<!-- Favicon -->
		<link href="dist/img/favicon.png" type="image/png" rel="icon">
	</head>
	<body class="start">
		<main>
			<div class="layout">
				<!-- Start of Sign Up -->
				<div class="main order-md-2">
					<div class="start">
						<div class="container">
							<div class="col-md-12">
								<div class="content">
									<h1>Create Account</h1>
									<div class="third-party">
										<button class="btn item bg-blue">
											<i class="material-icons">pages</i>
										</button>
										<button class="btn item bg-teal">
											<i class="material-icons">party_mode</i>
										</button>
										<button class="btn item bg-purple">
											<i class="material-icons">whatshot</i>
										</button>
									</div>
									<p>or use your email for registration:</p>
									<form class="signup" action="sign-up.php" method="post">
										<div class="form-parent">
											<div class="form-group">
												<input type="text" name="inputName" id="inputName" class="form-control" placeholder="Username" required>
												<button class="btn icon"><i class="material-icons">person_outline</i></button>
											</div>
											<div class="form-group">
												<input type="email"name="inputEmail" id="inputEmail" class="form-control" placeholder="Email Address" required>
												<button class="btn icon"><i class="material-icons">mail_outline</i></button>
											</div>
											
										</div>
										<div class="form-group">
												<input type="tel" pattern="[0-1]{2}[0-5]{1}[0-9]{8}"  name="inputphone" id="inputphone" class="form-control" placeholder="Phone Number" required>
												<button class="btn icon"><i class="material-icons">local_phone</i></button>
										</div>
										<div class="form-group">
											
											<input type="password"name="inputPassword" id="inputPassword" class="form-control" placeholder="Password" required>
											<button class="btn icon"><i class="material-icons">lock_outline</i></button>
										</div>
										<button type="submit" class="btn button">Sign Up</button>
										<div class="callout">
											<span>Already a member? <a href="sign-in.php">Sign In</a></span>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- End of Sign Up -->
				<!-- Start of Sidebar -->
				<div class="aside order-md-1">
					<div class="container">
						<div class="col-md-12">
							<div class="preference">
								<h2>Welcome Back!</h2>
								<p>To keep connected with your friends please login with your personal info.</p>
								<a href="sign-in.php" class="btn button">Sign In</a>
							</div>
						</div>
					</div>
				</div>
				<!-- End of Sidebar -->
			</div> <!-- Layout -->
		</main>
		<!-- Bootstrap core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="dist/js/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script>window.jQuery || document.write('<script src="dist/js/vendor/jquery-slim.min.js"><\/script>')</script>
		<script src="dist/js/vendor/popper.min.js"></script>
		<script src="dist/js/bootstrap.min.js"></script>
	</body>


</html>