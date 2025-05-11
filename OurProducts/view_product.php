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
if (isset($_REQUEST['pid'])) {
    
    $pid = mysqli_real_escape_string($con, $_REQUEST['pid']);
}else {
    header('location: index.php');
}


$getposts = mysqli_query($con, "SELECT * FROM products WHERE id ='$pid'") or die(mysqlI_error($con));
                    if (mysqli_num_rows($getposts)) {
                        $row = mysqli_fetch_assoc($getposts);
                        $id = $row['id'];
                        $pName = $row['pName'];
                        $price = $row['price'];
                        $piece = $row['piece'];
                        $description = $row['description'];
                        $picture = $row['picture'];
                        $item = $row['item'];
                        $available = $row['available'];
                    }   


if (isset($_POST['addcart'])) {
    $getposts = mysqli_query($con, "SELECT * FROM cart WHERE pid ='$pid' AND uid='$user'") or die(mysqlI_error($con));
    if (mysqli_num_rows($getposts)) {
        header('location: ../mycart.php?uid='.$user.'');
    }else{
        if(mysqli_query($con, "INSERT INTO cart (uid,pid,quantity) VALUES ('$user','$pid', 1)")){
            header('location: ../mycart.php?uid='.$user.'');
        }else{
            header('location: index.php');
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Detail</title>
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <?php include ( "../inc/mainheader.inc.php" ); ?>

    <div class="c-product-detail">
        <div class="c-product-gallery">
            <img src="../image/product/<?= $item ?>/<?= $picture ?>" 
                 class="c-product-image-main"
                 alt="<?= $pName ?>">
        </div>
        
        <div class="c-product-info">
            <h1 class="c-product-title"><?= $pName ?></h1>
            <div class="c-product-price">$<?= number_format($price, 2) ?></div>
            
            <div class="c-product-meta">
                <div>Available: <?= $available ?> in stock</div>
                <div>Pieces per pack: <?= $piece ?></div>
            </div>

            <div class="c-product-description">
                <h3>Product Description</h3>
                <p><?= nl2br($description) ?></p>
            </div>

            <div class="c-product-actions">
                <form method="post" action="">
                    <input type="submit" name="addcart" 
                           value="Add to cart" 
                           class="c-button c-prim-button">
                </form>
                <form method="post" action="../orderform.php?poid=<?= $pid ?>">
                    <input type="submit" value="Order Now" 
                           class="c-button c-prim-button">
                </form>
            </div>
        </div>
    </div>
</body>
</html>