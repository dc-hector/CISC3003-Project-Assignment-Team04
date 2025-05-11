<?php include ( "inc/connect.inc.php" ); ?>

<?php
ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
}
else {
	header("location: index.php");
}
$emails = "";
$passs = "";
if (isset($_POST['login'])) {
	if (isset($_POST['email']) && isset($_POST['password'])) {
		$user_login = mysqli_real_escape_string($con, $_POST['email']);
		$user_login = mb_convert_case($user_login, MB_CASE_LOWER, "UTF-8");	
		$password_login = mysqli_real_escape_string($con, $_POST['password']);		
		$num = 0;
		$password_login_md5 = md5($password_login);
		$result = mysqli_query($con, "SELECT * FROM user WHERE (email='$user_login') AND password='$password_login_md5' AND activation='yes'");
		$num = mysqli_num_rows($result);
		$get_user_email = mysqli_fetch_assoc($result);
			$get_user_uname_db = $get_user_email['id'];
		if ($num>0) {
			$_SESSION['user_login'] = $get_user_uname_db;
			setcookie('user_login', $user_login, time() + (365 * 24 * 60 * 60), "/");
			
			if (isset($_REQUEST['ono'])) {
				$ono = mysqli_real_escape_string($con, $_REQUEST['ono']);
				header("location: orderform.php?poid=".$ono."");
			}else {
				header('location: index.php');
			}
			exit();
		}
		else {
			$result1 = mysqli_query($con, "SELECT * FROM user WHERE (email='$user_login') AND password='$password_login_md5' AND activation='no'");
		$num1 = mysqli_num_rows($result1);
		$get_user_email1 = mysqli_fetch_assoc($result1);
			$get_user_uname_db1 = $get_user_email1['id'];
		if ($num1>0) {
			$emails = $user_login;
			$activacc ='';
		}else {
			$emails = $user_login;
			$passs = $password_login;
			$error_message = '<br><br>
				<div class="maincontent_text" style="text-align: center; font-size: 18px;">
				<font face="bookman">Email or Password incorrect.<br>
				</font></div>';
		}
			
		}
	}

}
$acemails = "";
$acccode = "";
if(isset($_POST['activate'])){
	if(isset($_POST['actcode'])){
		$user_login = mysqli_real_escape_string($con, $_POST['acemail']);
		$user_login = mb_convert_case($user_login, MB_CASE_LOWER, "UTF-8");	
		$user_acccode = mysqli_real_escape_string($con, $_POST['actcode']);
		$result2 = mysqli_query($con, "SELECT * FROM user WHERE (email='$user_login') AND confirmCode='$user_acccode'");
		$num3 = mysqli_num_rows($result2);
		echo $user_login;
		if ($num3>0) {
			$get_user_email = mysqli_fetch_assoc($result2);
			$get_user_uname_db = $get_user_email['id'];
			$_SESSION['user_login'] = $get_user_uname_db;
			setcookie('user_login', $user_login, time() + (365 * 24 * 60 * 60), "/");
			mysqli_query($con, "UPDATE user SET confirmCode='0', activation='yes' WHERE email='$user_login'");
			if (isset($_REQUEST['ono'])) {
				$ono = mysqli_real_escape_string($con, $_REQUEST['ono']);
				header("location: orderform.php?poid=".$ono."");
			}else {
				header('location: index.php');
			}
			exit();
		}else {
			$emails = $user_login;
			$error_message = '<br><br>
				<div class="maincontent_text" style="text-align: center; font-size: 18px;">
				<font face="bookman">Code not matched!<br>
				</font></div>';
		}
	}else {
		$error_message = '<br><br>
				<div class="maincontent_text" style="text-align: center; font-size: 18px;">
				<font face="bookman">Activation code not matched!<br>
				</font></div>';
	}

}

?>

<!doctype html>
<html>
    <head>
        <title>Login - MaxDeal</title>
        <link rel="stylesheet" type="text/css" href="css/main.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </head>
    <body>
        <!-- 统一Header -->
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

                <div class="auth-links c-auth-links">
                    <?php if(!isset($_SESSION['user_login'])): ?>
                    <div class="c-button c-auth-button">
                        <a href="signin.php">SIGN UP</a>
                    </div>
                    <div class="c-button c-auth-button">
                        <a href="login.php">LOG IN</a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- 登录表单容器 -->
        <div class="c-product-container" style="max-width: 500px; margin: 50px auto;">
            <div class="c-product-info">
                <?php if (isset($activacc)): ?>
                <h2 class="c-category-header">Account Activation</h2>
                <?php else: ?>
                <h2 class="c-category-header">User Login</h2>
                <?php endif; ?>

                <?php if(isset($error_message)) echo $error_message; ?>

                <form action="" method="POST" class="registration">
                    <div style="display: grid; gap: 1rem;">
                        <?php if(isset($activacc)): ?>
                        <input type="email" name="acemail" class="c-search-bar" placeholder="Email" value="<?php echo $emails; ?>">
                        <input type="text" name="actcode" class="c-search-bar" placeholder="Activation Code">
                        <button type="submit" name="activate" class="c-button c-prim-button">Activate Account</button>
                        <?php else: ?>
                        <input type="email" name="email" class="c-search-bar" placeholder="Email" value="<?php echo $emails; ?>">
                        <input type="password" name="password" class="c-search-bar" placeholder="Password">
                        <button type="submit" name="login" class="c-button c-prim-button">Log In</button>
                        <?php endif; ?>
                    </div>
                </form>

                <div style="text-align: center; margin-top: 20px;">
                    <a href="forgetpass.php" style="color: var(--primary-color);">Forgot Password?</a>
                </div>
            </div>
        </div>


    </body>
</html>