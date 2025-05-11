<?php include ( "inc/connect.inc.php" ); ?>
<?php 

if (isset($_REQUEST['poid'])) {
	
	$poid = mysqli_real_escape_string($con, $_REQUEST['poid']);
}else {
	header('location: index.php');
}
ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
	$user = "";
	header("location: login.php?ono=".$poid."");
}
else {
	$user = $_SESSION['user_login'];
	$result = mysqli_query($con, "SELECT * FROM user WHERE id='$user'");
		$get_user_email = mysqli_fetch_assoc($result);

			$uname_db = $get_user_email['firstName'];
			$ulast_db=$get_user_email['lastName'];
			$uemail_db = $get_user_email['email'];

			$umob_db = $get_user_email['mobile'];
			$uadd_db = $get_user_email['address'];
}


$getposts = mysqli_query($con, "SELECT * FROM products WHERE id ='$poid'") or die(mysqlI_error($con));
					if (mysqli_num_rows($getposts)) {
						$row = mysqli_fetch_assoc($getposts);
						$id = $row['id'];
						$pName = $row['pName'];
						$price = $row['price'];
						$description = $row['description'];
						$picture = $row['picture'];
						$item = $row['item'];
						$category = $row['category'];
						$available =$row['available'];
					}	

//order

if (isset($_POST['order'])) {
//declere veriable
$mbl = $_POST['mobile'];
$addr = $_POST['address'];
$quan = $_POST['Quantity'];
$del = $_POST['Delivery'];
//triming name
	try {
		if(empty($_POST['mobile'])) {
			throw new Exception('Mobile can not be empty');
			
		}
		if(empty($_POST['address'])) {
			throw new Exception('Address can not be empty');
			
		}
		if(empty($_POST['Quantity'])) {
			throw new Exception('Quantity can not be empty');
			
		}
		if(empty($_POST['Delivery'])) {
			throw new Exception('Type of Delivery can not be empty');
			
		}

		
		// Check if email already exists
		
		
						$d = date("Y-m-d"); //Year - Month - Day
						
						// send email
						$msg = "
					
						Your Order suc

						
						";
						//if (@mail($uemail_db,"eBuyBD Product Order",$msg, "From:eBuyBD <no-reply@ebuybd.xyz>")) {
							
						if(mysqli_query($con, "INSERT INTO orders (uid,pid,quantity,oplace,mobile,odate,delivery) VALUES ('$user','$poid',$quan,'$_POST[address]','$_POST[mobile]','$d','$del')")){

							//success message
							

							
						$success_message = '
						<div class="signupform_content">
						<h2><font face="bookman"></font></h2>
						<script>
						alert("We will call you for confirmation very soon");
						</script>
						<div class="signupform_text" style="font-size: 18px; text-align: center;">
						<font face="bookman">

						</font></div></div>
						';
						

						

							
						}
						//}

	}
	catch(Exception $e) {
		$error_message = $e->getMessage();
	}
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Place Order - MaxDeal</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body style="min-width: 980px;">

	<!-- Main Header (matching index.php) -->
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
				<?php if($user != ""): ?>
					<a href="profile.php?uid=<?php echo $user; ?>" class="user-avatar">
						<i class="fas fa-user-circle"></i>
					</a>
				<?php else: ?>
					<div class="auth-links c-auth-links">
						<div class="c-button c-auth-button">
							<a href="signin.php" class="uiloginbutton">
								SIGN UP
							</a>
						</div>
						
						<div class="c-button c-auth-button">
							<a href="login.php" class="uiloginbutton">
								LOG IN
							</a>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<div class="categolis">
		<table>
			<tr>
				<th>
					<a href="NoodlesCanned.php" style="text-decoration: none;color: white;padding: 4px 12px;background-color: #8ac0ff;border-radius: 12px;">Noodles&Canned</a>
				</th>
				<th><a href="Seasonings.php" style="text-decoration: none;color: white;padding: 4px 12px;background-color: #8ac0ff ;border-radius: 12px;">Seasonings</a></th>
				<th><a href="Drinks.php" style="text-decoration: none;color: white;padding: 4px 12px;background-color: #8ac0ff;border-radius: 12px;">Drinks</a></th>
				<th><a href="Snacks.php" style="text-decoration: none;color: white;padding: 4px 12px;background-color: #8ac0ff;border-radius: 12px;">Snacks</a></th>
				<th><a href="Sweets.php" style="text-decoration: none;color: white;padding: 4px 12px;background-color: #8ac0ff;border-radius: 12px;">Sweets</a></th>
				<th><a href="Soap&Detergent.php" style="text-decoration: none;color: white;padding: 4px 12px;background-color: #8ac0ff;border-radius: 12px;">Soap&Detergent</a></th>
				<th><a href="Shampoo.php" style="text-decoration: none;color: white;padding: 4px 12px;background-color: #8ac0ff;border-radius: 12px;">Shampoo</a></th>
				<th><a href="Hygene.php" style="text-decoration: none;color: white;padding: 4px 12px;background-color: #8ac0ff;border-radius: 12px;">Hygiene</a></th>
			</tr>
		</table>
	</div>

	<!-- Main Content -->
	<div class="c-order-container">
		<div class="c-order-content">
			<div class="c-order-left">
				<!-- Product Preview -->
				<div class="c-product-preview">
					<?php
					echo '
						<div class="c-product-card">
							<a href="'.$category.'/view_product.php?pid='.$id.'">
								<img src="image/product/'.$item.'/'.$picture.'" class="c-product-img">
							</a>
							<div class="c-product-info">
								<h3>'.$pName.'</h3>
								<p class="c-product-price">Price: $'.$price.'</p>
							</div>
						</div>
					';
					?>
				</div>
			</div>

			<div class="c-order-right">
				<?php 
				if(isset($success_message)) {
					// Success Message
					echo '<div class="c-order-success">';
					echo $success_message;
					echo '<div class="c-order-details">';
					echo '<h2 class="c-order-title">Payment & Delivery Details</h2>';
					
					echo '<div class="c-order-info">';
					echo '<div class="c-info-row">';
					echo '<label>First Name:</label>';
					echo '<span>'. $uname_db.'</span>';
					echo '</div>';
					
					echo '<div class="c-info-row">';
					echo '<label>Last Name:</label>';
					echo '<span>' .$ulast_db.'</span>';
					echo '</div>';
					
					echo '<div class="c-info-row">';
					echo '<label>Email:</label>';
					echo '<span>' .$uemail_db.'</span>';
					echo '</div>';
					
					echo '<div class="c-info-row">';
					echo '<label>Contact Number:</label>';
					echo '<span>' .$umob_db.'</span>';
					echo '</div>';
					
					echo '<div class="c-info-row">';
					echo '<label>Home Address:</label>';
					echo '<span>'.$uadd_db.'</span>';
					echo '</div>';
					
					$del = $_POST['Delivery'] ;
					echo '<div class="c-info-row">';
					echo '<label>Type of Delivery:</label>';
					echo '<span>' .$del.'</span>';
					echo '</div>';
					
					$quan = $_POST['Quantity'];
					echo '<div class="c-info-row">';
					echo '<label>Quantity:</label>';
					echo '<span>' .$quan.'</span>';
					echo '</div>';
					echo '</div>';
					
					echo '<div class="c-order-total">';
					echo '<h3>Total: $'.($quan * $price).'</h3>';
					echo '</div>';
					echo '</div>';
					echo '</div>';
				}
				else {
					// Order Form
					echo '
						<div class="c-order-form">
							<h2 class="c-form-title">Place Your Order</h2>
							<p class="c-payment-note">
								<i class="fas fa-info-circle"></i> Accepting Cash On Delivery Only
							</p>
							
							<form action="" method="POST" class="c-form">
								<div class="c-form-group">
									<label for="fullname">First Name</label>
									<input name="fullname" id="fullname" placeholder="Your first name" 
										   required="required" type="text" value="'.$uname_db.'">
								</div>

								<div class="c-form-group">
									<label for="lastname">Last Name</label>
									<input name="lastname" id="lastname" placeholder="Your last name" 
										   required="required" type="text" value="'.$ulast_db.'">
								</div>

								<div class="c-form-group">
									<label for="mobile">Mobile Number</label>
									<input name="mobile" id="mobile" placeholder="Your mobile number" 
										   required="required" type="text" value="'.$umob_db.'">
								</div>

								<div class="c-form-group">
									<label for="address">Address</label>
									<input name="address" id="address" placeholder="Write your full address" 
										   required="required" type="text" value="'.$uadd_db.'">
								</div>

            <div class="c-delivery-options">
                <label>
                    <input type="radio" name="Delivery" 
                           value="Express Delivery +$100" 
                           onchange="updateTotal(true)" required>
                    Express Delivery (+$100)
                </label>
                <label>
                    <input type="radio" name="Delivery" 
                           value="Standard Delivery" 
                           onchange="updateTotal(false)" required>
                    Standard Delivery
                </label>
            </div>

								<div class="c-form-group">
									<label for="Quantity">Quantity</label>
									<input name="Quantity" id="Quantity" type="number" min="1" 
										   required="required" placeholder="Enter quantity">
								</div>

								<div class="c-form-actions">
									<button type="submit" name="order" class="c-button c-prim-button c-order-button">
										<i class="fas fa-shopping-cart"></i> Confirm Order
									</button>
								</div>
								';
								
								if (isset($error_message)) {
									echo '<div class="c-error-message">'.$error_message.'</div>';
								}
								
								echo '
							</form>
						</div>
					';
				}
				?>
			</div>
		</div>
	</div>

	<!-- Footer -->
	<footer>
		CISC3003-Project Assignment-Team04
	</footer>
</body>
</html>