<?php include ( "inc/connect.inc.php" ); ?>
<?php 

ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
	header("location: login.php");
}
else {
	$user = $_SESSION['user_login'];
	$result = mysqli_query($con, "SELECT * FROM user WHERE id='$user'");
		$get_user_email = mysqli_fetch_assoc($result);
			$uname_db = $get_user_email['firstName'];
			$uemail_db = $get_user_email['email'];
			$upass = $get_user_email['password'];

			$umob_db = $get_user_email['mobile'];
			$uadd_db = $get_user_email['address'];
}

if (isset($_REQUEST['uid'])) {
	
	$user2 = mysqli_real_escape_string($con, $_REQUEST['uid']);
	if($user != $user2){
		header('location: index.php');
	}
}else {
	header('location: index.php');
}

if (isset($_POST['changesettings'])) {
//declere veriable
$email = $_POST['email'];
$opass = $_POST['opass'];
$npass = $_POST['npass'];
$npass1 = $_POST['npass1'];
//triming name
	try {
		if(empty($_POST['email'])) {
			throw new Exception('Email can not be empty');
			
		}
			if(isset($opass) && isset($npass) && isset($npass1) && ($opass != "" && $npass != "" && $npass1 != "")){
				if( md5($opass) == $upass){
					if($npass == $npass1){
						$npass = md5($npass);
						mysqli_query($con, "UPDATE user SET password='$npass' WHERE id='$user'");
						$success_message = '
						<div class="signupform_text" style="font-size: 18px; text-align: center;">
						<font face="bookman">
							Password changed.
						</font></div>';
					}else {
					$success_message = '
						<div class="signupform_text" style=" color: red; font-size: 18px; text-align: center;">
						<font face="bookman">
							New password not matched!
						</font></div>';
					}
				}else {
				$success_message = '
					<div class="signupform_text" style=" color: red; font-size: 18px; text-align: center;">
					<font face="bookman">
						Fillup password field exactly.
					</font></div>';
				}
			}else {
				$success_message = '
					<div class="signupform_text" style=" color: red; font-size: 18px; text-align: center;">
					<font face="bookman">
						Fillup password field exactly.
					</font></div>';
				}

			if($uemail_db != $email) {
				if(mysqli_query($con, "UPDATE user SET  email='$email' WHERE id='$user'")){
					//success message
					$success_message = '
					<div class="signupform_text" style="font-size: 18px; text-align: center;">
					<font face="bookman">
						Settings change successfull.
					</font></div>';
				}
			}

	}
	catch(Exception $e) {
		$error_message = $e->getMessage();
	}
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Settings - MaxDeal</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
   <div class="c-header l-homepage s-bg-dark">
        <a href="index.php">
            <div class="c-logo">
                <h1 class="c-logo-max">Max</h1>
                <h1 class="c-logo-deal">Deal</h1>
            </div>
        </a>

        <div class="header-group c-search-auth">
            <div id="srcheader" class="c-search-form">
                <form id="newsearch" method="get" action="search.php">
                    <input type="text" class="srctextinput c-search-bar" name="keywords" placeholder="Search groceries...">
                    <input type="submit" value="Search" class="srcbutton c-button c-prim-button">
                </form>
            </div>

 			<div class="user-status c-user-status">
				<?php if($user != ""): ?>
				<a href="profile.php?uid=<?php echo $user; ?>" class="user-avatar">
					<i class="fas fa-user-circle"></i>
					<?php echo $uname_db; ?>
				</a>
				<a href="logout.php" class="c-button c-auth-button">
					LOG OUT
				</a>
				<?php endif; ?>
			</div>
		</div>
	</div>

 
    <div class="c-category-nav" style="padding:1rem; background:var(--light-color);">
        <a href="mycart.php?uid=<?php echo $user?>" class="c-button c-sec-button">My Cart</a>
        <a href="profile.php?uid=<?php echo $user?>" class="c-button c-sec-button">My Orders</a>
        <a href="my_delivery.php?uid=<?php echo $user?>" class="c-button c-sec-button">Delivery History</a>
        <a href="settings.php?uid=<?php echo $user?>" class="c-button c-prim-button">Settings</a>
    </div>

    <div class="settings-container">
        <div class="settings-form">
            <h2 class="settings-title">Account Settings</h2>
            <form action="" method="POST">
                <!-- 密码修改部分 -->
                <input class="settings-input" type="password" name="opass" placeholder="Old Password" required>
                <input class="settings-input" type="password" name="npass" placeholder="New Password" required>
                <input class="settings-input" type="password" name="npass1" placeholder="Confirm New Password" required>

                <!-- 邮箱修改部分 -->
                <input class="settings-input" type="email" name="email" placeholder="New Email" 
                    value="<?php echo $uemail_db; ?>" required>

                <!-- 提交按钮 -->
                <button type="submit" class="settings-button" name="changesettings">Update Settings</button>

                <!-- 消息提示 -->
                <?php if (isset($success_message)): ?>
                    <div class="settings-message settings-success"><?php echo $success_message; ?></div>
                <?php endif; ?>
            </form>
        </div>
    </div>

	
</body>
</html>