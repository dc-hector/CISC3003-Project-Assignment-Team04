<?php include("inc/connect.inc.php"); ?>
<?php 
ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
    $user = "";
} else {
    $user = $_SESSION['user_login'];
    $result = mysqli_query($con, "SELECT * FROM user WHERE id='$user'");
    $get_user_email = mysqli_fetch_assoc($result);
    $uname_db = $get_user_email != null ? $get_user_email['firstName'] : null;
}

// 搜索验证逻辑
$search_value = "";
if (isset($_GET['keywords']) && trim($_GET['keywords']) != "") {
    $search_value = mysqli_real_escape_string($con, trim($_GET['keywords']));
} else {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Results - MaxDeal</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
	
</head>
<body>
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

    <!-- 分类标题 -->
    <div class="c-category-header">
        <h2>Search Results for "<?= htmlspecialchars($search_value) ?>"</h2>
    </div>

    <!-- 产品容器 -->
    <div class="c-product-container">
        <div class="c-product-grid">
            <?php 
            $query = "SELECT * FROM products 
                     WHERE pName LIKE '%$search_value%' 
                     AND available >= 1 
                     ORDER BY id DESC";
            $getposts = mysqli_query($con, $query) or die(mysqli_error($con));

            if (mysqli_num_rows($getposts) > 0) {
                while ($row = mysqli_fetch_assoc($getposts)) {
                    $id = $row['id'];
                    $pName = htmlspecialchars($row['pName']);
                    $price = number_format($row['price'], 2);
                    $picture = htmlspecialchars($row['picture']);
                    $item = htmlspecialchars($row['item']);
            ?>
                    <article class="c-product-card">
                        <a href="OurProducts/view_product.php?pid=<?= $id ?>">
                            <img src="image/product/<?= $item ?>/<?= $picture ?>" 
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
                echo '<p class="c-empty-message">No products found matching your search.</p>';
            }
            ?>
        </div>
    </div>


</body>
</html>