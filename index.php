<?php
	session_start();
	if(!isset( $_SESSION["userrole"])){
		header("location:sign-in.php");
	}
	require_once '../controllers/contactcontroller.php';
	require_once '../models/contact.php';
	require_once '../controllers/authcontroller.php';
	require_once '../controllers/callcontroller.php';
	require_once '../controllers/usercontroller.php';
	require_once '../controllers/notificationcontroller.php';
	require_once '../models/user.php';

	$contactscont=new contactcontroller;
	$contacts=$contactscont->getcontacts($_SESSION["userid"]);
	$notificationcontroller = new notificationcontroller;
	$notfications = $notificationcontroller->getNotification($_SESSION['userid']);
	$callcontroller = new callcontroller;
	$calls= $callcontroller->getcall($_SESSION['userid']);
	$usercontroller = new usercontroller;
	if(isset($_POST['search'])){
	 	$users =$usercontroller->getusers($_POST['search']);
	}
	if( isset( $_FILES['image'])&&isset($_POST['inputName'])&& isset( $_POST['inputphone'])){
		if(!empty($_FILES['image']&&!empty($_POST['inputName'])&&!empty($_POST['inputphone']))){
			$cont=new contact;
			$contcontrol =new contactcontroller;
			$location="dist/img/avatars/ ".date("h-i-s").$_FILES['image']['name'];
			if(move_uploaded_file($_FILES['image']['tmp_name'],$location)){
				$cont->setpphoto($location);
				
			}
			else{
				$errMsg ="error in upload";
			}
			if(!isset($_POST['inputEmail'])){
				$contemail="";
			}
			$contemail=$_POST['inputEmail'];
			$cont->setemail($contemail);
			
			$cont->setphone($_POST['inputphone']);
			$cont->setname($_POST['inputName']);
			 if($contcontrol->addcontact($cont)){
				$contacts=$contactscont->getcontacts($_SESSION["userid"]);
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
		if(!empty( $_POST['delcontact'])){
			if($contactscont->delete($_POST['delcontact'])){
				$contacts=$contactscont->getcontacts($_SESSION["userid"]);
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
	if( isset( $_POST['block'])){
		if(!empty( $_POST['blockContact'])){
			if($contactscont->block ($_POST['blockContact'])){
				$contacts=$contactscont->getcontacts($_SESSION["userid"]);
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
	if( isset( $_POST['unblock'])){
		if(!empty( $_POST['unblockContact'])){
			if($contactscont->unblock ($_POST['unblockContact'])){
				$contacts=$contactscont->getcontacts($_SESSION["userid"]);
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
	if( isset( $_POST['chat'])){
		if($contactscont->checkblock($contactscont->getContactUser($_POST['phoneNumber'])['0']['id'])){
			header("location:chat.php?phonenum=".$_POST['phoneNumber']);
		}
	}	
	
	if( isset( $_POST['call'])){
		if($contactscont->checkblock($contactscont->getContactUser($_POST['phoneNumber'])['0']['id'])){
			$callcontroller = new callcontroller;
			$call = new call;
			$notficationcontroller = new notificationcontroller;
			$notfication = new notfication;
			
			$notfication->setuserID($contactscont->getContactUser($_POST['phoneNumber'])['0']['id']);
			$notfication->setcontent("You have missed a call from ".$_SESSION['username']);
			$call->setreceiverid($contactscont->getContactUser($_POST['phoneNumber'])['0']['id']); 
			$call->setID($_SESSION["userid"]);
			$notficationcontroller->addnotification($notfication);
			if($callcontroller->call($call)){
				header("location:call.php?phonenum=".$_POST['phoneNumber']);
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
	if( isset( $_POST['deleteAcc'])){
		if($usercontroller->deleteAcc($_SESSION["userid"])){
			header("location:sign-in.php?logout");

		}
			else{
			$errMsg=$_SESSION["errMsg"];
			if($errMsg!==""){
				echo "<script>alert('$errMsg')</script>";
			}
			}
		
	}
	if( isset( $_FILES['cover'] ) && isset($_POST['email']) && isset( $_POST['password']) && isset( $_POST['phone']) && isset( $_POST['name1'])){
		$location="dist/img/avatars/ ".date("h-i-s").$_FILES['cover']['name'];
		if($_POST['name1']!=$_SESSION['username']||$_POST['email']!=$_SESSION['useremail']||$_POST['password']!=$_SESSION['userpassword']||$_POST['phone']!=$_SESSION['userphone']||$location!=$_SESSION['userphoto']){
			$authcontroller =new authcontroller;
			$client = new user;
			
			if(move_uploaded_file($_FILES['cover']['tmp_name'],$location)){
				$client->setpphoto($location);
			}
			else{
				$client->setpphoto($_SESSION['userphoto']);
			}
			$client ->setusername($_POST['name1']);
			$client ->setemail($_POST['email']);
			$client ->setpassword($_POST['password']);
			$client ->setphone($_POST['phone']);
			if($authcontroller->editprofile ($client)){
				$authcontroller->getNewInfo($_SESSION['userid']);
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
	<title>Caller-ID</title>
	<meta name="description" content="#">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap core CSS -->
	<link href="dist/css/lib/bootstrap.min.css" type="text/css" rel="stylesheet">
	<!-- Swipe core CSS -->
	<link href="dist/css/swipe.min.css" type="text/css" rel="stylesheet">
	<!-- Favicon -->
	<link href="dist/img/favicon.png" type="image/png" rel="icon">
</head>
<body>
	
	<main>
		<div class="layout">
			<!-- Start of Navigation -->
			<div class="navigation">
				<div class="container">
					<div class="inside">
						<div class="nav nav-tab menu">
							<a href="#allmembers" data-toggle="tab" class="show"><i class="material-icons">person_pin_circle</i></a>
							<button class="btn"><img class="avatar-xl" <?php echo "src='".$_SESSION["userphoto"]."'"?> alt="avatar"></button>
							<a href="#members" data-toggle="tab" class="show"><i class="material-icons active">account_circle</i></a>
							<a href="#discussions" data-toggle="tab" class="show"><i class="material-icons">chat_bubble_outline</i></a>
							<a href="#calllog" data-toggle="tab" class="show "><i class="material-icons ">phone</i></a>
							<a href="#notifications" data-toggle="tab" class="show "><i class="material-icons ">notifications_none</i></a>
							<a href="#settings" data-toggle="tab" class="show "><i class="material-icons">settings</i></a>
							<a href="sign-in.php?logout"><button class="btn power" onclick="visitPage();"><i class="material-icons">power_settings_new</i></button></a>
						</div>
					</div>
				</div>
			</div>
			<!-- End of Navigation -->
			<!-- Start of Sidebar -->
			<div class="sidebar" id="sidebar">
				<div class="container">
					<div class="col-md-12">
						<div class="tab-content">
							<!-- Start of Contacts -->
							<div class="tab-pane fade active show"  id="members">
								<div class="search">
									<form class="form-inline position-relative">
										<input type="search" class="form-control" id="people" placeholder="Search for people...">
										<button type="button" class="btn btn-link loop"><i class="material-icons">search</i></button>
									</form>
									<button class="btn create" data-toggle="modal" data-target="#exampleModalCenter"><i class="material-icons">person_add</i></button>
									
								</div>
								<div class="list-group sort">
									<button class="btn filterMembersBtn show active" data-toggle="list" data-filter="all">All</button>
									<button class="btn filterMembersBtn show" data-toggle="list" data-filter="offline" style="color: #da3e3e;">Blocked</button>
								</div>						
								<div class="contacts" >
									<h1>Contacts</h1>
									<div class="list-group" id="contacts" role="tablist">
										<?php
											if($contacts){
												foreach($contacts as $contact){
													?>
													<a href="#" class="filterMembers all <?php if($contact['blocked']){echo "offline";}else{echo "online";} ?> contact" data-toggle="list">
														<img class="avatar-md" <?php echo "src='".$contact['pphoto']."'"; ?> data-toggle="tooltip" data-placement="top" title="" alt="avatar" data-original-title="<?php echo $contact["phone1"] ?>">
														<div class="status">
															<i class="material-icons <?php if($contact['blocked']){echo "offline";}else{echo "online";} ?>" style="color:  <?php if($contact['blocked']){echo "#da3e3e";}?>;">fiber_manual_record</i>
														</div>
														<div class="data">
															
															<?php
																echo "<h5>" .$contact['name']."</h5>";
															
															?>
															
														</div>
														<div class="dropdown">
															<button class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="material-icons md-30">more_vert</i></button>
															<div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-194px, 30px, 0px);">
																<form method="POST">
																	<button class="dropdown-item connect" name="call" <?php if($contact['blocked']){echo "disabled";}else{echo "";} ?>><i class="material-icons">phone_in_talk</i>Voice Call</button>
																	<input type="hidden" name="contactId" value="<?php echo $contact['id'];?>">
																	<button class="dropdown-item connect" name="chat" <?php if($contact['blocked']){echo "disabled";}else{echo "";} ?>><i class="material-icons">chat</i>Chat</button>
																	<input type="hidden" name="phoneNumber" value="<?php echo $contact['phone1'];?>">
																	<input type="hidden" name="contactName" value="<?php echo $contact['name'];?>">
																	<input type="hidden" name="contactemail" value="<?php echo $contact['email'];?>">
																	<input type="hidden" name="contactphoto" value="<?php echo $contact['pphoto'];?>">
																</form>
																<form method="POST" id="dropdownform" action="edit contact.php">
																	<input type="hidden" name="contactId" value="<?php echo $contact['id'];?>">
																	<input type="hidden" name="phoneNumber" value="<?php echo $contact['phone1'];?>">
																	<input type="hidden" name="contactName" value="<?php echo $contact['name'];?>">
																	<input type="hidden" name="contactemail" value="<?php echo $contact['email'];?>">
																	<input type="hidden" name="contactphoto" value="<?php echo $contact['pphoto'];?>">
																	<button class="dropdown-item" ><i class="material-icons">edit</i>Edit</button>
																	<hr>
																</form>
																<?php if(!$contact['blocked']){?>
																<form action="" method="POST">
																	<input type="hidden" name="blockContact" value="<?php echo $contact['id'];?>">
																	<button class="dropdown-item" name="block"><i class="material-icons" style="color: #da3e3e;">block</i>Block Contact</button>
																</form>
																<?php ;} else{?>
																<form action="" method="POST">
																	<input type="hidden" name="unblockContact" value="<?php echo $contact['id'];?>">
																	<button class="dropdown-item" name="unblock"><i class="material-icons" style="color: #da3e3e;">lock_open</i>Unblock Contact</button>
																</form>
																<?php ;} ?>
																<form action="" method="POST">
																	<input type="hidden" name="delcontact" value="<?php echo $contact['id'];?>">
																	<button class="dropdown-item" name="delete" data-toggle="modal" data-target="#deleteconfirm"><i class="material-icons" style="color: #da3e3e;">delete</i>Delete Contact</button>
																</form>
															</div>
														</div>
													</a>
													<?php
												}
											}
										?>

										
										
									</div>
									
								</div>
								
							</div>
							<!-- End of Contacts -->

											<!-- Start of ContactsSearch -->
							<div class="tab-pane fade" id="allmembers">
								<div class="search">
									<form class="form-inline position-relative" method="POST" >
										<input type="search" class="form-control" name="search" id="people" placeholder="Search for people...">
										<button type="button" class="btn btn-link loop"><i class="material-icons">search</i></button>
									</form>
									
									
								</div>
					
								<div class="contacts">
									<h1>Global Search</h1>
									<div class="list-group" id="contacts" role="tablist">
										<?php
										if(isset($users)){
											if($users){
												foreach($users as $user){
													?>
													
															<a href="#" class="filterMembers all contact" data-toggle="list">
																<img class="avatar-md" <?php echo "src='".$user['pphoto']."'"; ?> data-toggle="tooltip" data-placement="top" title="" alt="avatar" data-original-title="<?php echo $user["phone"] ?>">
																
																<div class="data">
																	
																	<?php
																		echo "<h5>" .$user['name']."</h5>";
																	
																	?>
																	
																</div>

															</a>
														
													<?php
												}
											}
										}
										?>


									</div>
								</div>
							</div>
							<!-- End of Contacts -->



							<!-- Start of Discussions -->
							<div id="discussions" class="tab-pane fade">
								<div class="search">
									<form class="form-inline position-relative">
										<input type="search" class="form-control" id="conversations" placeholder="Search for conversations...">
										<button type="button" class="btn btn-link loop"><i class="material-icons">search</i></button>
									</form>
								</div>
														
								<div class="discussions">
									<h1>Messages</h1>
									<div class="list-group" id="chats" role="tablist">
									<?php
											if($contacts){
												foreach($contacts as $contact){
													?>
													<a href="<?php if(!$contact['blocked']){echo "chat.php?phonenum=".$contact['phone1'];} ?>" 
														role="tab" class="filterDiscussions all single"  id="list-chat-list">
														<img class="avatar-md" <?php echo "src='".$contact['pphoto']."'"; ?> data-toggle="tooltip" data-placement="top" title="" alt="avatar" data-original-title="Janette">
														<div class="status">
															<i class="material-icons <?php if($contact['blocked']){echo "offline";}else{echo "online";} ?> contact""\ style="color:  <?php if($contact['blocked']){echo "#da3e3e";}?>;">fiber_manual_record</i>
														</div>
														<div class="new bg-yellow">
															<span>+</span>
														</div>
														<div class="data">
															<?php
																echo "<h5>".$contact['name']."</h5>";
															?>
															
															<p>	<?php echo "{$contact['name']} ";?>sent you a message!</p>
														</div>
													</a>
													<?php
												}
											}
										?>							
																			



									</div>
								</div>
							</div>
							<!-- End of Discussions -->
							<!-- Start of Notifications -->
							<div id="notifications" class="tab-pane fade">
								<div class="search">
									<form class="form-inline position-relative">
										<input type="search" class="form-control" id="notice" placeholder="Filter notifications...">
										<button type="button" class="btn btn-link loop"><i class="material-icons filter-list">filter_list</i></button>
									</form>
								</div>
														
								<div class="notifications">
									<h1>Notifications</h1>
									<div class="list-group" id="alerts" role="tablist">
									<?php
											if($notfications){
												foreach($notfications as $notfication){
													foreach($contacts as $contact){
														$c=substr($notfication['content'],28) ;
														if($c==$contact['name']){
															$thisContact=$contact;
															break;
														}

													}
													?>
													<a href="#" class="filterNotifications all latest notification" data-toggle="list">
														<img class="avatar-md" src="<?php echo $thisContact['pphoto'] ?>" data-toggle="tooltip" data-placement="top" title="" alt="avatar" data-original-title="Janette">
														
														<div class="data">
															<p><?php echo $notfication['content'] ?></p>
															<span><?php echo $notfication['timestamp'] ?></span>
														</div>
													</a>
													<?php
												}
											}
										?>
										
										
										
										
										
										
										
										
									</div>
								</div>
							</div>
							<!-- End of Notifications -->

								<!-- Start of Calllog -->
								<div id="calllog" class="tab-pane fade">
								<div class="search">
									<form class="form-inline position-relative">
										<input type="search" class="form-control" id="notice" placeholder="Filter Calls...">
										<button type="button" class="btn btn-link loop"><i class="material-icons filter-list">filter_list</i></button>
									</form>
								</div>
														
								<div class="notifications">
									<h1>Call log</h1>
									<div class="list-group" id="alerts" role="tablist">
									<?php
											if($calls){
												foreach($calls as $call){
													foreach($contacts as $contact){
														if($call['userId']==$contactscont->getContactUser($contact['phone1'])['0']["id"]){
															$thisContact=$contact;
															break;
														}

													}	
													?>
													
													<a href="#" class="filterNotifications all latest notification" data-toggle="list">
														<img class="avatar-md" src="<?php echo $thisContact['pphoto'] ; ?>" data-toggle="tooltip" data-placement="top" title="" alt="avatar" data-original-title="<?php echo $thisContact['name'] ?>">
														<div class="status">
															<i class="material-icons" style="color:red;">phone_missed</i>
														</div>
														<div class="data">
															<p><?php echo $thisContact['name'] ?></p>
															<span><?php echo $call['timestamp'] ?></span>
														</div>
													</a>
													<?php
												}
											}
										?>
										
										
										
										
										
										
										
										
									</div>
								</div>
							</div>
							<!-- End of Calllog -->



							<!-- Start of Settings -->
							<div class="tab-pane fade" id="settings">			
								<div class="settings">
									<div class="profile">
										<img class="avatar-xxl" style="margin:10px;" src="<?php echo $_SESSION['userphoto'] ?>" alt="avatar">
										<h1 style="font-size:30px;"><a href="#"><?php echo $_SESSION['username'] ?></a></h1>

									</div>
									<div class="categories" id="accordionSettings">
										<h1>Settings</h1>
										<!-- Start of My Account -->
										<div class="category">
											<a href="#" class="title collapsed" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
												<i class="material-icons md-30 online">person_outline</i>
												<div class="data">
													<h5>My Account</h5>
													<p>Update your profile details</p>
												</div>
												<i class="material-icons">keyboard_arrow_right</i>
											</a>
											<div class="collapse" id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionSettings" styl="">
												<div class="content">
													
													<form action="index.php" method="POST" enctype="multipart/form-data">
													<div class="upload">
														<div class="data">
															<?php
																	echo '<img class="avatar-xl" src="'.$_SESSION['userphoto'].'" alt="imag">';
																?>
															<label>
																<input type="file" name ="cover" id="cover">
																<span class="btn button">Upload avatar</span>
															</label>
														</div>
														<p>For best results, use an image at least 256px by 256px in either .jpg or .png format!</p>
													</div>
														
														<div class="parent">
															<div class="field">
																<label for="firstName">Name <span>*</span></label>
																<input name ="name1" type="text" class="form-control" id="firstName" placeholder="Name" value="<?php echo $_SESSION['username']; ?>" required="">
															</div>
														</div>
														<div class="field">
															<label for="email">Email <span>*</span></label>
															<input name ="email" type="email" class="form-control" id="email" placeholder="Enter your email address" value="<?php echo $_SESSION["useremail"]; ?>" required="">
														</div>
														<div class="field">
															<label for="password">Password</label>
															<input name= "password"type="password" class="form-control" id="password" placeholder="Enter a new password" value = "<?php echo $_SESSION["userpassword"]; ?> " required="">
														</div>
														<div class="field">
															<label for="phone">Phone</label>
															<input name = "phone" type="tel" pattern="[0-1]{2}[0-5]{1}[0-9]{8}" class="form-control" id="phone" placeholder="Enter a new phone" value="<?php echo $_SESSION["userphone"]; ?>" required="">
														</div>														
														<button name="deleteAcc" class="btn btn-link w-100">Delete Account</button>
														<button type="submit" class="btn button w-100" >Apply</button>
													</form>
												</div>
											</div>
										</div>
										<!-- End of My Account -->
										<!-- Start of Appearance Settings -->
										<div class="category">
											<a href="#" class="title collapsed" id="headingFive" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
												<i class="material-icons md-30 online">colorize</i>
												<div class="data">
													<h5>Appearance</h5>
													<p>Customize the look of Swipe</p>
												</div>
												<i class="material-icons">keyboard_arrow_right</i>
											</a>
											<div class="collapse" id="collapseFive" aria-labelledby="headingFive" data-parent="#accordionSettings">
												<div class="content no-layer">
													<div class="set">
														<div class="details">
															<h5>Turn Off Lights</h5>
															<p>The dark mode is applied to core areas of the app that are normally displayed as light.</p>
														</div>
														<label class="switch">
															<input type="checkbox">
															<span class="slider round mode"></span>
														</label>
													</div>
												</div>
											</div>
										</div>
										<!-- End of Appearance Settings -->

										<!-- Start of Logout -->
										<div class="category">
											<a href="sign-in.php?logout" class="title collapsed">
												<i class="material-icons md-30 online">power_settings_new</i>
												<div class="data">
													<h5>Power Off</h5>
													<p>Log out of your account</p>
												</div>
												<i class="material-icons">keyboard_arrow_right</i>
											</a>
										</div>
										<!-- End of Logout -->
									</div>
								</div>
							</div>
							<!-- End of Settings -->
						</div>
					</div>
				</div>
			</div>

			<!-- edit contact-->
			<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="requests">
						<div class="title">
							<h1>Add contact</h1>
							<button type="button" class="btn" data-dismiss="modal" aria-label="Close"><i class="material-icons">close</i></button>
						</div>
						<div class="content">
						<form class="requests" method="post" id="my-form" enctype="multipart/form-data">
							<div class="form-parent">
								<div class="form-group">
									<input type="text" name="inputName" id="inputName" class="form-control" placeholder="Username" required>
									<button class="btn icon"><i class="material-icons">person_outline</i></button>
								</div>
								<div class="form-group">
									<input type="tel" pattern="[0-1]{2}[0-5]{1}[0-9]{8}"  name="inputphone" id="inputphone" class="form-control" placeholder="Phone Number" required>
									<i class="material-icons">local_phone</i>
								</div>
								<div class="form-group">
									<input type="email"name="inputEmail" id="inputEmail" class="form-control" placeholder="Email Address" >
									<button class="btn icon"><i class="material-icons">mail_outline</i></button>
								</div>
								<div class="upload">
									<div class="data">
										
										<label>
											<input class="form-control" type="file" name ="image" id="image">
											<span class="btn button">Upload avatar</span>
										</label>
									</div>
									<p>For best results, use an image at least 256px by 256px in either .jpg or .png format!</p>
								</div>
							</div>
							
							
							<button type="submit" class="btn button" >Add contact</button>
							
						</form>
						</div>
					</div>
				</div>
			</div>
			<!-- end add new contact-->
			
			<div class="modal fade" id="deleteconfirm" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="requests">
						<div class="title">
							<h1>Are you sure you want to delete this contact ?</h1>
							<button type="button" class="btn" data-dismiss="modal" aria-label="Close"><i class="material-icons">close</i></button>
						</div>
						<div class="content">
								<button type="submit" class="btn button w-100 btn-danger">Yes</button>
						</div>
					</div>
				</div>
			</div>
			
			
			
			
			
			
		</div> <!-- Layout -->
	</main>
	<!-- Bootstrap/Swipe core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="dist/js/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script>window.jQuery || document.write('<script src="dist/js/vendor/jquery-slim.min.js"><\/script>')</script>
	<script src="dist/js/vendor/jquery-slim.min.js"></script>
	<script src="dist/js/vendor/popper.min.js"></script>
	<script src="dist/js/swipe.min.js"></script>
	<script src="dist/js/bootstrap.min.js"></script>
	
	


</body></html>