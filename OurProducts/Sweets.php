<?php include ( "../inc/connect.inc.php" ); ?>
<?php 
ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
	$user = "";
}
else {
	$user = $_SESSION['user_login'];
	$result = mysqli_query($con, "SELECT * FROM user WHERE id='$user'");
		$get_user_email = mysqli_fetch_assoc($result);
			$uname_db = $get_user_email['firstName'];
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Sweets</title>
	<link rel="stylesheet" type="text/css" href="../css/main.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<?php include ( "../inc/mainheader.inc.php" ); ?>
   <div class="c-category-header">
        <h2>Product List</h2>
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
				<th><a href="Sweets.php" style="text-decoration: none;color: black;padding: 4px 12px;background-color: #4e8df5;border-radius: 12px;">Sweets</a></th>
				<th><a href="Soap&Detergent.php" style="text-decoration: none;color: white;padding: 4px 12px;background-color: #8ac0ff;border-radius: 12px;">Soap&Detergent</a></th>
				<th><a href="Shampoo.php" style="text-decoration: none;color: white;padding: 4px 12px;background-color: #8ac0ff;border-radius: 12px;">Shampoo</a></th>
				<th><a href="Hygene.php" style="text-decoration: none;color: white;padding: 4px 12px;background-color: #8ac0ff; border-radius: 12px;">Hygiene</a></th>
			</tr>
		</table>
	</div>
    <div class="c-product-container">
        <div class="c-product-grid">
            <?php 
            $getposts = mysqli_query($con, 
                "SELECT * FROM products 
                WHERE available >= 1 AND item = 'sweet'
                ORDER BY id DESC LIMIT 12") or die(mysqli_error($con));
            
            if (mysqli_num_rows($getposts) > 0) {
                while ($row = mysqli_fetch_assoc($getposts)) {
                    $id = $row['id'];
                    $pName = htmlspecialchars($row['pName']);
                    $price = number_format($row['price'], 2);
                    $picture = htmlspecialchars($row['picture']);
            ?>
                    <article class="c-product-card">
                        <a href="view_product.php?pid=<?= $id ?>">
                            <img src="../image/product/sweet/<?= $picture ?>" 
                                 class="c-product-image"
                                 alt="<?= $pName ?>">
                            <div class="c-product-content">
                                <h3 class="c-product-name"><?= $pName ?></h3>
                                <div class="c-product-price">$<?= $price ?></div>
                            </div>
                        </a>
                    </article>
            <?php 
                }
            } else {
                echo '<p class="c-empty-message">Currently no available sweets.</p>';
            }
            ?>
        </div>
    </div>
</body>
</html>