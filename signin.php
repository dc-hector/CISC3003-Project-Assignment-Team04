<?php include ( "inc/connect.inc.php" ); ?>
<?php
ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
	$user = "";
}
else {
	header("location: index.php");
}

$u_fname = "";
$u_lname = "";
$u_email = "";
$u_mobile = "";
$u_address = "";
$u_pass = "";

if (isset($_POST['signup'])) {
//declere veriable
$u_fname = $_POST['first_name'];
$u_lname = $_POST['last_name'];
$u_email = $_POST['email'];
$u_mobile = $_POST['mobile'];
$u_address = $_POST['signupaddress'];
$u_pass = $_POST['password'];
//triming name
$_POST['first_name'] = trim($_POST['first_name']);
$_POST['last_name'] = trim($_POST['last_name']);
	try {
		if(empty($_POST['first_name'])) {
			throw new Exception('Fullname can not be empty');
			
		}
		if (is_numeric($_POST['first_name'][0])) {
			throw new Exception('Please write your correct name!');

		}
		if(empty($_POST['last_name'])) {
			throw new Exception('Lastname can not be empty');
			
		}
		if (is_numeric($_POST['last_name'][0])) {
			throw new Exception('lastname first character must be a letter!');

		}
		if(empty($_POST['email'])) {
			throw new Exception('Email can not be empty');
			
		}
		if(empty($_POST['mobile'])) {
			throw new Exception('Mobile can not be empty');
			
		}
		if(empty($_POST['password'])) {
			throw new Exception('Password can not be empty');
			
		}
		if(empty($_POST['signupaddress'])) {
			throw new Exception('Address can not be empty');
			
		}

		
		// Check if email already exists
		
		$check = 0;
		$e_check = mysqli_query($con, "SELECT email FROM `user` WHERE email='$u_email'");
		$email_check = mysqli_num_rows($e_check);
		if (strlen($_POST['first_name']) >2 && strlen($_POST['first_name']) <20 ) {
			if (strlen($_POST['last_name']) >2 && strlen($_POST['last_name']) <20 ) {
			if ($check == 0 ) {
				if ($email_check == 0) {
					if (strlen($_POST['password']) >1 ) {
						$d = date("Y-m-d"); //Year - Month - Day
						$_POST['first_name'] = ucwords($_POST['first_name']);
						$_POST['last_name'] = ucwords($_POST['last_name']);
						$_POST['last_name'] = ucwords($_POST['last_name']);
						$_POST['email'] = mb_convert_case($u_email, MB_CASE_LOWER, "UTF-8");
						$_POST['password'] = md5($_POST['password']);
						$confirmCode   = substr( rand() * 900000 + 100000, 0, 6 );
						// send email
						$msg = "
						...
						
						Your activation code: ".$confirmCode."
						Signup email: ".$_POST['email']."
						
						";
						//if (@mail($_POST['email'],"eBuyBD Activation Code",$msg, "From:eBuyBD <no-reply@ebuybd.xyz>")) {
							
						$result = mysqli_query($con, "INSERT INTO user (firstName,lastName,email,mobile,address,password,confirmCode) VALUES ('$_POST[first_name]','$_POST[last_name]','$_POST[email]','$_POST[mobile]','$_POST[signupaddress]','$_POST[password]','$confirmCode')");
						
						//success message
						$success_message = '
						<div class="signupform_content"><h2><font face="bookman">Registration successfull!</font></h2>
						<div class="signupform_text" style="font-size: 18px; text-align: center;">
						<font face="bookman">
							Email: '.$u_email.'<br>
							Activation code sent to your email. <br>
							Your activation code: '.$confirmCode.'
						</font></div></div>';
						//}else {
							//throw new Exception('Email is not valid!');
						//}
						
						
					}else {
						throw new Exception('Make strong password!');
					}
				}else {
					throw new Exception('Email already taken!');
				}
			}else {
				throw new Exception('Username already taken!');
			}
			}else {
			throw new Exception('Lastname must be 2-20 characters!');
		}
		}else {
			throw new Exception('Firstname must be 2-20 characters!');
		}

	}
	catch(Exception $e) {
		$error_message = $e->getMessage();
	}
}


?>


<!doctype html>
<html>
	<head>
		<title>Welcome to MaxDeal online shop</title>
		<link rel="stylesheet" type="text/css" href="css/main.css">
		<link rel="stylesheet" type="text/css" href="css/functional-tech-style.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body class="signin-body tech-style" style="min-width: 980px;">
	
	<!-- Main Header -->
	<div class="c-header l-homepage s-bg-dark">

		<!-- Logo Area -->
		<a href="index.php">
			<div class="c-logo">
				<h1 class="c-logo-max">Max</h1>
				<h1 class="c-logo-deal">Deal</h1>
			</div>
		</a>

		<!-- Combined Search and Auth Area -->
		<div class="header-group c-search-auth">
			<!-- Search Form -->
			<div id="srcheader" class="c-search-form">
				<form id="newsearch" method="get" action="search.php">
					<input type="text" class="srctextinput c-search-bar" name="keywords"
						placeholder="Search groceries..." />
					<input type="submit" value="Search" class="srcbutton c-button c-prim-button" />
				</form>
			</div>

			<!-- User Menu -->
			<div class="user-status c-user-status">
				<div class="auth-links c-auth-links">
					<div class="c-button c-auth-button">
						<a href="signin.php">
							SIGN UP
						</a>
					</div>

					<div class="c-button c-auth-button">
						<a href="login.php">
							LOG IN
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Signin Background Hero -->
	<div class="signin-hero" style="
		background-image: url('image/signin-bg.jpg'); 
		background-size: cover;
		background-position: center;
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		z-index: -1;
	">
		<div class="overlay" style="
			background-color: rgba(10, 10, 12, 0.7);
			width: 100%;
			height: 100%;
		"></div>
	</div>

		<?php 
			if(isset($success_message)) {echo $success_message;}
			else {
				echo '
					<div class="holecontainer">
						<div class="container">
							<div>
								<div>
									<div class="signupform_content">
										<h2>Sign Up Form!</h2>
										<div class="signupform_text"></div>
										<div>
											<form action="" method="POST" class="registration">
												<div class="signup_form">
													<div>
														<td >
															<input name="first_name" id="first_name" placeholder="First Name" required="required" class="first_name signupbox" type="text" size="30" value="'.$u_fname.'" >
														</td>
													</div>
													<div>
														<td >
															<input name="last_name" id="last_name" placeholder="Last Name" required="required" class="last_name signupbox" type="text" size="30" value="'.$u_lname.'" >
														</td>
													</div>
													<div>
														<td>
															<input name="email" placeholder="Enter Your Email" required="required" class="email signupbox" type="email" size="30" value="'.$u_email.'">
														</td
			>										</div>
													<div>
														<td>
															<input name="mobile" placeholder="Enter Your Mobile" required="required" class="email signupbox" type="text" size="30" value="'.$u_mobile.'">
														</td>
													</div>
													<div>
														<td>
															<input name="signupaddress" placeholder="Write Your Full Address" required="required" class="email signupbox" type="text" size="30" value="'.$u_address.'">
														</td>
													</div>
													<div>
														<td>
															<input name="password" id="password-1" required="required"  placeholder="Enter New Password" class="password signupbox " type="password" size="30" value="'.$u_pass.'">
														</td>
													</div>
													<div>
														<input name="signup" class="uisignupbutton signupbutton" type="submit" value="Sign Me Up!">
													</div>
													<div class="signup_error_msg">';
														
															if (isset($error_message)) {echo $error_message;}
															
														
													echo'</div>
												</div>
											</form>
											
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				';
			}

		 ?>
	</body>
</html>