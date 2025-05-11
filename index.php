<?php include ( "inc/connect.inc.php" ); ?>
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
    $uname_db = $get_user_email != null ? $get_user_email['firstName'] : null;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>MaxDeal-Team04</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="/js/homeslideshow.js"></script>
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
                        placeholder="Search groceries..." />
                    <input type="submit" value="Search" class="srcbutton c-button c-prim-button" />
                </form>
            </div>

            <!-- User Menu -->
   			<div class="user-status c-user-status">
				<?php if($user != ""): ?>
				<a href="profile.php?uid=<?php echo $user; ?>" class="user-avatar">
					<i class="fas fa-user-circle"></i>
					<?php echo $uname_db; ?>
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

    <!-- Main Content -->

    <div class="home-welcome-text c-hero" style="
        background-image: url(image/hero-deals.jpg); 
        background-color: rgba(255,255,255,0.3); 
        background-blend-mode: lighten;
        background-size:cover;
        background-position: center;
        ">
        <div class="welcome-content c-hero-content">
            <h1>Welcome To MaxDeal</h1>
            <h2>We provide quality products at competitive prices.</h2>
        </div>
    </div>

    <!-- Product Categories -->
    <div class="home-prodlist">
        <div class="category-title c-section-title">
            <h3>Products Category</h3>
        </div>
        <div class="category-grid c-grid">
            <ul>
                <li>
                    <a href="OurProducts/NoodlesCanned.php">
                        <img src="./image/product/noodles/n.jpg" class="home-prodlist-imgi">
                        <span>Noodles & Canned</span>
                    </a>
                </li>
                <li>
                    <a href="OurProducts/Snacks.php">
                        <img src="./image/product/snack/sn.jpg" class="home-prodlist-imgi">
                        <span>Snacks</span>
                    </a>
                </li>
                <li>
                    <a href="OurProducts/Sweets.php">
                        <img src="./image/product/sweet/s.jpg" class="home-prodlist-imgi">
                        <span>Sweet</span>
                    </a>
                </li>
                <li>
                    <a href="OurProducts/Hygene.php">
                        <img src="./image/product/hygiene/hy.jpg" class="home-prodlist-imgi">
                        <span>Hygiene</span>
                    </a>
                </li>
                <li>
                    <a href="OurProducts/Shampoo.php">
                        <img src="./image/product/shampoo/pall.jpg" class="home-prodlist-imgi">
                        <span>Shampoo</span>
                    </a>
                </li>
                <li>
                    <a href="OurProducts/Soap&Detergent.php">
                        <img src="./image/product/soap/sp.jpg" class="home-prodlist-imgi">
                        <span>Soap & Detergent</span>
                    </a>
                </li>
                <li>
                    <a href="OurProducts/Drinks.php">
                        <img src="./image/product/drink/dr.jpg" class="home-prodlist-imgi">
                        <span>Drinks</span>
                    </a>
                </li>
                <li>
                    <a href="OurProducts/Seasonings.php">
                        <img src="./image/product/seasoning/cond.jpg" class="home-prodlist-imgi">
                        <span>Seasonings</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        CISC3003-Project Assignment-Team04
    </footer>

</body>

</html>