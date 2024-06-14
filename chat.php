
<?php
	session_start();
	if(!isset( $_SESSION["userid"])){
		header("location:sign-in.php");
	}
	require_once '../controllers/contactcontroller.php';
	require_once '../controllers/messageController.php';
	require_once '../controllers/notificationcontroller.php';
	require_once '../models/message.php';
	require_once '../models/contact.php';
	require_once '../models/user.php';
	$contactcont =new contactcontroller;
	$messageController=new messageController;
	$_SESSION['contactAsUser'] =$contactcont->getContactUser($_GET['phonenum']);
	$contact=$contactcont->getContactinfo($_GET['phonenum']);
	$messages=$messageController->getChat($_SESSION['userid']);
	
	if( isset( $_POST['text'])){
		if(!empty( $_POST['text'])){
			$message=new message;
			$messagecontroller =new messageController;
			$notficationcontroller = new notificationcontroller;
			$notfication = new notfication;
			$notfication->setuserID($_SESSION['contactAsUser']['0']['id']);
			$notfication->setcontent("you have a new message from ".$_SESSION['username']);

			$notficationcontroller->addnotification($notfication);
			$message->setText($_POST['text']);
			unset($_POST['text']);
			if($messagecontroller->sendMessage($message)){
							
			}
			 else{
				$errMsg=$_SESSION["errMsg"];
				if($errMsg!==""){
					echo "<script>alert('$errMsg')</script>";
					$_POST['inputEmail']="";
					$_POST['image']="";
				}
			 }
			 $messages=$messageController->getChat($_SESSION['userid']);
		}	

	}
	if( isset( $_POST['delete'])){
		if(!empty( $_POST['messageId'])){
			$messagecontroller =new messageController;
			if($messagecontroller->delete($_POST['messageId'])){
				$messages=$messageController->getChat($_SESSION['userid']);
			}
			 else{
				$errMsg=$_SESSION["errMsg"];
				if($errMsg!==""){
					echo "<script>alert('$errMsg')</script>";
					$_POST['inputEmail']="";
					$_POST['image']="";
				}
			 }
		}	

	}
	
	if( isset( $_POST['delete'])){
		if(!empty( $_POST['messageId'])){
			$messagecontroller =new messageController;
			if($messagecontroller->delete($_POST['messageId'])){
				$messages=$messageController->getChat($_SESSION['userid']);
			}
			 else{
				$errMsg=$_SESSION["errMsg"];
				if($errMsg!==""){
					echo "<script>alert('$errMsg')</script>";
					$_POST['inputEmail']="";
					$_POST['image']="";
				}
			 }
		}	

	}
?>

<!DOCTYPE html>
<html lang="en"><head>
	<meta charset="utf-8">
	<title>Chat</title>
	<meta name="description" content="#">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap core CSS -->
	<link href="dist/css/lib/bootstrap.min.css" type="text/css" rel="stylesheet">
	<!-- Swipe core CSS -->
	<link href="dist/css/swipe.min.css" type="text/css" rel="stylesheet">
	<!-- Favicon -->
	<link href="dist/img/favicon.png" type="image/png" rel="icon">
<style>
    @media (max-width: 991px){
.chatmod {
    padding-bottom: 0px;
}
    }
	.me .danger {
  border-color: #f44336;
  color: #2195F3;
}
.me .danger:hover {
  background: #2195F3;
  color: red;
}
 .danger {
  border-color: #f44336;
  color: #f5f5f5;
}
 .danger:hover {
  background: #f5f5f5;
  color: red;
}

	
</style></head>


<body class="chatmod">
	<main>
		<div class="layout">

			<div class="main">
				<div class="tab-content" id="nav-tabContent">
					
					<div class="babble tab-pane fade active show" id="list-chat" role="tabpanel" aria-labelledby="list-chat-list">
						
						<div class="chat" id="chat1">
							<div class="top">
								<div class="container">
									<div class="col-md-12">
										<div class="inside">
											<a href="#"><img class="avatar-md" src="<?php echo $contact['pphoto'];   ?>"
											 data-toggle="tooltip" data-placement="top" title="" alt="avatar" data-original-title="<?php echo $contact['name'];   ?>"></a>
											<div class="status">
												<i class="material-icons online">fiber_manual_record</i>
											</div>
											<div class="data">
												<h5><a href="#"><?php echo $contact['name'];   ?></a></h5>
												<span>Active now</span>
											</div>
											<a class="btn" href="index.php"><i class="material-icons md-30">close</i></a>
											
										</div>
									</div>
								</div>
							</div>
							<div class="content" id="content">
								<div class="container">
									<div class="col-md-12">
										
										
										
										
										
										
											
												<?php

													if($messages){
														$btnNum =-1;
														foreach($messages as $message){
															$btnNum ++;
															if($message['userId']==$_SESSION['userid']){
															?>
															<div class="message me">
																	<div class="text-main">
																	<div class="text-group me "  >
																		<div class="text me" style="display: flex;flex-direction: row-reverse">
																			<form action="" method="POST">
																				<input type="hidden" name="messageId" value="<?php echo $message['id'];?>">
																				<button class="btn danger" name="delete"  style="margin-left: 5px; "><i class="material-icons online">delete</i></button> 
																			</form>
																			
																			<p><?php echo $message['text'] ?></p>
																			
																		</div>
																	</div>
																	
																	<span><?php echo $message['timestamp'] ?></span>
																</div>
															
												
											
															</div>
															<?php
															}
														if($message['recipientId']==$_SESSION['userid']){
															?>
															<div class="message">
																<img class="avatar-md" src="<?php echo $contact['pphoto'];   ?>" data-toggle="tooltip" data-placement="top" title="" alt="avatar" data-original-title="<?php echo $contact['name'];   ?>">
																<div class="text-main">
																	<div class="text-group">
																		 <div class="text" style="display:flex; width: fit-content; padding-right:5px " >
																		 	
																			
																			<p ><?php echo $message['text'] ?></p>
																			<form action="" method="POST">
																				<input type="hidden" name="messageId" value="<?php echo $message['id'];?>">
																				<button class="btn danger" name="delete"  style="margin-left: 3px;"><i class="material-icons online">delete</i></button> 
																			</form>
																		</div>
																	</div>
																	<span><?php echo $message['timestamp'] ?></span>
																</div>
															</div>
															<?php
														}
													}
												}
												
											?>	
											
										
										
										
										
										
									</div>
								</div>
							</div>
							<div class="container">
								<div class="col-md-12">
									<div class="bottom">
										<form class="position-relative w-100 btn button" method="post">
											<textarea class="form-control" name="text" placeholder="Start typing for reply..." rows="1"></textarea>
											
											<button type="submit" class="btn send" onclick="myfunction()"><i class="material-icons">send</i></button>
										</form>
									</div>
								</div>
							</div>
						</div>
						
						
						
						
					</div>
					
					
					
					
					
					
					
				</div>
			</div>
		</div> 
	</main>
	
	
	<script src="dist/js/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script>window.jQuery || document.write('<script src="dist/js/vendor/jquery-slim.min.js"><\/script>')</script><script src="dist/js/vendor/jquery-slim.min.js"></script><script src="dist/js/vendor/jquery-slim.min.js"></script><script src="dist/js/vendor/jquery-slim.min.js"></script>
	<script src="dist/js/vendor/popper.min.js"></script>
	<script src="dist/js/swipe.min.js"></script>
	<script src="dist/js/bootstrap.min.js"></script>
	

	
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</body></html>
