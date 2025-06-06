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
    $umob_db = $get_user_email['mobile'];
    $uadd_db = $get_user_email['address'];
}

if (isset($_REQUEST['uid'])) {
    $user2 = mysqli_real_escape_string($con, $_REQUEST['uid']);
    if($user != $user2){
        header('location: index.php');
    }
} else {
    header('location: index.php');
}

$search_value = "";
?>

<!DOCTYPE html>
<html>
<head>
    <title>MaxDeal - My Profile</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body style="min-width: 980px;">

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
                        placeholder="Search groceries..." value="<?php echo $search_value; ?>" />
                    <input type="submit" value="Search" class="srcbutton c-button c-prim-button" />
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

    <!-- Navigation Categories -->
    <div class="c-category-nav" style="padding:1rem; background:var(--light-color);">
        <a href="mycart.php?uid=<?php echo $user?>" class="c-button c-sec-button">My Cart</a>
        <a href="profile.php?uid=<?php echo $user?>" class="c-button c-prim-button">My Orders</a>
        <a href="my_delivery.php?uid=<?php echo $user?>" class="c-button c-sec-button">Delivery History</a>
        <a href="settings.php?uid=<?php echo $user?>" class="c-button c-sec-button">Settings</a>
    </div>

    <!-- Main Content -->
    <div class="c-order-container">
        <div class="c-category-title c-section-title">
            <h3>My Order History</h3>
        </div>
        
        <div class="c-order-content" style="flex-direction: column; padding: 20px;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr style="font-weight: bold; background-color: #3A5487; color: white; text-align: left;">
                    <th style="padding: 12px;">Product Name</th>
                    <th style="padding: 12px;">Price</th>
                    <th style="padding: 12px;">Quantity</th>
                    <th style="padding: 12px;">Order Date</th>
                    <th style="padding: 12px;">Delivery Date</th>
                    <th style="padding: 12px;">Delivery Place</th>
                    <th style="padding: 12px;">Status</th>
                    <th style="padding: 12px;">Preview</th>
                </tr>
                
                <?php 
                $query = "SELECT * FROM orders WHERE uid='$user' ORDER BY id DESC";
                $run = mysqli_query($con, $query);
                
                if(mysqli_num_rows($run) > 0) {
                    while ($row = mysqli_fetch_assoc($run)) {
                        $pid = $row['pid'];
                        $quantity = $row['quantity'];
                        $oplace = $row['oplace'];
                        $mobile = $row['mobile'];
                        $odate = $row['odate'];
                        $ddate = $row['ddate'];
                        $dstatus = $row['dstatus'];
                        
                        //get product info
                        $query1 = "SELECT * FROM products WHERE id='$pid'";
                        $run1 = mysqli_query($con, $query1);
                        $row1 = mysqli_fetch_assoc($run1);
                        $pId = $row1['id'];
                        $pName = substr($row1['pName'], 0, 50);
                        $price = $row1['price'];
                        $picture = $row1['picture'];
                        $item = $row1['item'];
                        $category = $row1['category'];
                ?>
                <tr style="border-bottom: 1px solid #e1e1e1;">
                    <td style="padding: 12px;"><?php echo $pName; ?></td>
                    <td style="padding: 12px;"><?php echo $price; ?></td>
                    <td style="padding: 12px;"><?php echo $quantity; ?></td>
                    <td style="padding: 12px;"><?php echo $odate; ?></td>
                    <td style="padding: 12px;"><?php echo $ddate; ?></td>
                    <td style="padding: 12px;"><?php echo $oplace; ?></td>
                    <td style="padding: 12px;">
                        <span style="padding: 4px 8px; border-radius: 4px; background-color: <?php echo ($dstatus == 'Delivered') ? '#d4edda' : '#fff3cd'; ?>; color: <?php echo ($dstatus == 'Delivered') ? '#155724' : '#856404'; ?>;">
                            <?php echo $dstatus; ?>
                        </span>
                    </td>
                    <td style="padding: 12px;">
                        <a href="OurProducts/view_product.php?pid=<?php echo $pId; ?>">
                            <img src="image/product/<?php echo $item.'/'.$picture; ?>" style="height: 60px; width: 60px; object-fit: cover; border-radius: 4px;">
                        </a>
                    </td>
                </tr>
                <?php 
                    }
                } else {
                ?>
                <tr>
                    <td colspan="8" style="padding: 30px; text-align: center;">
                        <div class="c-empty-message">
                            <i class="fas fa-shopping-bag" style="font-size: 48px; color: #ccc; margin-bottom: 20px;"></i>
                            <p>You don't have any orders yet.</p>
                            <a href="index.php" class="c-button c-prim-button" style="display: inline-block; margin-top: 20px;">Start Shopping</a>
                        </div>
                    </td>
                </tr>
                <?php
                }
                ?>
            </table>
        </div>
    </div>



</body>
</html>