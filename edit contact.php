<?php
	require_once '../models/contact.php';
    require_once '../controllers/Authcontroller.php';
	require_once '../controllers/contactcontroller.php';
	session_start();
	if(isset($_POST['contactName'])){
		$_SESSION['editid']= $_POST['contactId'];
		$_SESSION['editlocation']= $_POST['contactphoto'];
		$_SESSION['editemail']=$_POST['contactemail'];
		$_SESSION['editphone']=$_POST['phoneNumber'];
		$_SESSION['editname']=$_POST['contactName'];
	}
	if( isset( $_FILES['image1'] )&& isset( $_POST['inputphone1']) && isset( $_POST['inputName1'])){
		$location="dist/img/avatars/".date("h-i-s").$_FILES['image1']['name']; //new image directory
		
		if($_POST['inputName1']!=$_SESSION['editname']||$_POST['inputphone1']!=$_SESSION['editphone']||$location!=$_SESSION['editlocation']){
			$contactcontroller =new contactcontroller;
			$contact = new contact;
			$contact->setpphoto($_SESSION['editlocation']);
			
			if(move_uploaded_file($_FILES['image1']['tmp_name'],$location)&& strstr($location, ".jpg") ){
				
				$contact->setpphoto($location);
				$_SESSION['editlocation']=$location;
				
			}
			else{
			}
			
			
			$contact->setphone($_POST['inputphone1']);
			$contact->setID($_SESSION['editid']);
			$contact ->setname($_POST['inputName1']);
			$_SESSION['editemail']=$_POST['inputEmail'];
			$_SESSION['editphone']=$_POST['inputphone1'];
			$_SESSION['editname']=$_POST['inputName1'];
			if(isset($_POST['inputEmail']))
				$contact ->setemail($_POST['inputEmail']);
			$contact ->setpphoto($location);
			if($contactcontroller->editprofile ($contact)){

			}
			else{
				$errMsg=$_SESSION["errMsg"];
				if($errMsg!==""){
					echo "<script>alert('$errMsg')</script>";
				}
			}
				
		}
	}
	
	
    
?>


<!DOCTYPE html>
<html lang="en">

<head>
		<meta charset="utf-8">
		<title>Add Admin</title>
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
								<div class="content" >
								<h1>Contact Profile</h1>
									<div style="border: 2px solid black; border-radius: 50px; width: max-content;  padding:10px; margin:auto;">
									<a href="index.php"><button type="button" class="btn"><i class="material-icons">close</i></button></a>
									<form class="signup"  method="post" enctype="multipart/form-data" style="border: 2px solid black; border-radius: 50px; padding: 50px;">
										<div class="upload" style="margin-bottom: 10px;">
											<div class="data">
												
												<label>
													<input hidden  type="file" name="image1" value="<?php echo $_SESSION['editlocation'];?>">
													<img class="avatar-xxl" <?php echo "src='".$_SESSION['editlocation']."'"?> alt="avatar">
												</label>
											</div>
										</div>
										
										<div class="form-parent">
											<div class="form-group">
												<input type="text" name="inputName1" id="inputName1" class="form-control" placeholder="Username" value="<?php echo $_SESSION['editname']; ?>" required>
												<button class="btn icon"><i class="material-icons">person_outline</i></button>
											</div>
											<div class="form-group">
												<input type="email"name="inputEmail" id="inputEmail" class="form-control" value="<?php echo $_SESSION['editemail'];?>" placeholder="Email Address" >
												<button class="btn icon"><i class="material-icons">mail_outline</i></button>
											</div>
											
										</div>
										<div class="form-group">
												<input type="tel" pattern="[0-1]{2}[0-5]{1}[0-9]{8}"  name="inputphone1" value="<?php echo $_SESSION['editphone'];?>" id="inputphone" class="form-control" placeholder="Phone Number" required>
												<button class="btn icon"><i class="material-icons">local_phone</i></button>
										</div>
										
										<button type="submit" class="btn button">Apply</button>
										
									</form>
									</div>
									
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- End of Sign Up -->

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