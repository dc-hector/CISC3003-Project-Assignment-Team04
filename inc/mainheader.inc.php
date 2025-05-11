    <div class="c-header l-homepage s-bg-dark">

        <!-- Logo Area -->
    <a href="../index.php" class="c-logo-link">
      <div class="c-logo">
        <h1 class="c-logo-max">Max</h1>
        <h1 class="c-logo-deal">Deal</h1>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
      </div>
    </a>

       
        <div class="header-group c-search-auth">
          
        <div id="srcheader" class="c-search-form">
       <form id="newsearch" method="get" action="../search.php"> 
      <input type="text" class="srctextinput c-search-bar" name="keywords" placeholder="Search groceries...">
       <input type="submit" value="Search" class="srcbutton c-button c-prim-button">
     </form>
       </div>
            </div>
   			<div class="user-status c-user-status">
				<?php if($user != ""): ?>
				<a href="../profile.php?uid=<?php echo $user; ?>" class="user-avatar">
					<i class="fas fa-user-circle"></i>
					<?php echo $uname_db; ?>
				</a>
                <?php else: ?>
                <div class="auth-links c-auth-links">
                    <div class="c-button c-auth-button">
                        <a href="../signin.php" class="uiloginbutton">
                            SIGN UP
                        </a>
                    </div>

                    <div class="c-button c-auth-button">
                        <a href="../login.php" class="uiloginbutton">
                            LOG IN
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>