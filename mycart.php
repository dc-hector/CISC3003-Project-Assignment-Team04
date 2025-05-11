<?php
// 确保这是文件的第一行，没有空白或BOM标记
ob_start(); // 开启输出缓冲
session_start();
include("inc/connect.inc.php");

// 添加错误报告，方便调试
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 检查登录状态
if (!isset($_SESSION['user_login'])) {
    header("location: login.php");
    exit(); // 确保立即终止执行
}
else {
    $user = $_SESSION['user_login'];
    $result = mysqli_query($con, "SELECT * FROM user WHERE id='$user'");
    $get_user_email = mysqli_fetch_assoc($result);
    $uname_db = $get_user_email != null ? $get_user_email['firstName'] : null;
    $uemail_db = $get_user_email != null ? $get_user_email['email'] : null;
    $ulast_db= $get_user_email != null ? $get_user_email['lastName'] : null;
    $umob_db = $get_user_email != null ? $get_user_email['mobile'] : null;
    $uadd_db = $get_user_email != null ? $get_user_email['address'] : null;
}

// 检查成功消息
if (isset($_SESSION['order_success'])) {
    $success_message = $_SESSION['order_success'];
    unset($_SESSION['order_success']); // 使用后立即清除
}

// 验证URL参数
if (isset($_REQUEST['uid'])) {
    $user2 = mysqli_real_escape_string($con, $_REQUEST['uid']);
    if($user != $user2){
        header('location: index.php');
        exit();
    }
}else {
    header('location: index.php');
    exit();
}

// 处理删除购物车项
if (isset($_REQUEST['cid'])) {
    $cid = mysqli_real_escape_string($con, $_REQUEST['cid']);
    if(mysqli_query($con, "DELETE FROM orders WHERE pid='$cid' AND uid='$user'")){
        header('location: mycart.php?uid='.$user.'');
        exit();
    }else{
        header('location: index.php');
        exit();
    }
}

$search_value = "";
$error_message = ""; // 初始化错误消息变量

// 订单处理
if (isset($_POST['order'])) {
    $mbl = mysqli_real_escape_string($con, $_POST['mobile']);
    $addr = mysqli_real_escape_string($con, $_POST['address']);
    $del = isset($_POST['Delivery']) ? mysqli_real_escape_string($con, $_POST['Delivery']) : '';

    try {
        if(empty($mbl)) {
            throw new Exception('Mobile can not be empty');
        }
        if(empty($addr)) {
            throw new Exception('Address can not be empty');
        }
        if(empty($del)) {
            throw new Exception('Type of Delivery can not be empty');
        }

        // 验证购物车中是否有商品
        $result = mysqli_query($con, "SELECT * FROM cart WHERE uid='$user'");
        if(!$result) {
            throw new Exception('Database error: ' . mysqli_error($con));
        }
        
        $t = mysqli_num_rows($result);
        if($t <= 0) {
            throw new Exception('No product in cart. Add product first.');
        }

        // 计算总价
        $total = 0; 
        $result = mysqli_query($con, "SELECT * FROM cart WHERE uid='$user'");
        while ($get_p = mysqli_fetch_assoc($result)) {
            $pid = $get_p['pid'];
            $quantity = $get_p['quantity'];
            $product_query = mysqli_query($con, "SELECT * FROM products WHERE id='$pid'");
            if(!$product_query) {
                throw new Exception('Error fetching product: ' . mysqli_error($con));
            }
            $product = mysqli_fetch_assoc($product_query);
            $total += ($quantity * $product['price']); 
        }
        
        // 添加配送费
        $deliveryFee = (strpos($del, "Express Delivery") !== false) ? 100 : 0;
        $total += $deliveryFee; 
        $_SESSION['total'] = $total; // 存储在会话中

        // 插入订单
        $d = date("Y-m-d");
        $result = mysqli_query($con, "SELECT * FROM cart WHERE uid='$user'");
        $orderInserted = false;
        
        // 开始事务以确保数据一致性
        mysqli_autocommit($con, FALSE);
        
        while ($get_p = mysqli_fetch_assoc($result)) {
            $num = $get_p['quantity'];
            $pid = $get_p['pid'];
            
            // 修改后的SQL: 移除 total 列的引用
            $insert_query = "INSERT INTO orders (uid, pid, quantity, oplace, mobile, odate, delivery) 
                          VALUES ('$user','$pid',$num,'$addr','$mbl','$d','$del')";
            
            if (!mysqli_query($con, $insert_query)) {
                // 回滚事务并抛出异常
                mysqli_rollback($con);
                throw new Exception('Failed to insert order: ' . mysqli_error($con));
            }
            $orderInserted = true;
        }
        
        if ($orderInserted) {
            // 提交事务
            if(!mysqli_commit($con)) {
                throw new Exception('Failed to commit transaction: ' . mysqli_error($con));
            }
            
            $_SESSION['total'] = $total;
            // 将成功信息存入SESSION
            $_SESSION['order_success'] = '
            <div class="c-order-success" style="padding: 2rem; background: white; border-radius: 8px;">
            <h3 style="color:#4e8df5;font-size:2rem; margin-bottom: 1.5rem;">Payment & Delivery Details</h3>
            
            <div class="user-info">
                <h4 style="color:black;font-size:1.2rem; margin: 0.5rem 0;">First Name: 
                    <span style="color:#8ac0ff;">'.$uname_db.'</span>
                </h4>
                <h4 style="color:black;font-size:1.2rem; margin: 0.5rem 0;">Last Name: 
                    <span style="color:#8ac0ff;">'.$ulast_db.'</span>
                </h4>
                <h4 style="color:black;font-size:1.2rem; margin: 0.5rem 0;">Email: 
                    <span style="color:#8ac0ff;">'.$uemail_db.'</span>
                </h4>
                <h4 style="color:black;font-size:1.2rem; margin: 0.5rem 0;">Contact Number: 
                    <span style="color:#8ac0ff;">'.$umob_db.'</span>
                </h4>
                <h4 style="color:black;font-size:1.2rem; margin: 0.5rem 0;">Delivery Address: 
                    <span style="color:#8ac0ff;">'.$uadd_db.'</span>
                </h4>
                <h4 style="color:black;font-size:1.2rem; margin: 0.5rem 0;">Delivery Type: 
                    <span style="color:#8ac0ff;">'.$del.'</span>
                </h4>
            </div>
            
            <div class="total-section" style="margin-top: 2rem;">
                <h3 style="color:#4e8df5;font-size:1.5rem;">Total Amount: 
                    $'.number_format($_SESSION['total'], 2).'
                </h3>
            </div>
        </div>';

            // 删除购物车中的商品
            if(!mysqli_query($con, "DELETE FROM cart WHERE uid='$user'")) {
                // 不影响订单创建，只记录错误
                error_log('Failed to clear cart: ' . mysqli_error($con));
            }
            
            // 确保刷新输出缓冲区并清除
            ob_end_clean();
            
            // 使用PHP重定向
            header("Location: mycart.php?uid=$user");
            exit(); // 确保脚本停止执行
        }
    } catch(Exception $e) {
        // 如果在事务中发生错误，回滚事务
        mysqli_rollback($con);
        $error_message = $e->getMessage();
    }
    
    // 重置自动提交
    mysqli_autocommit($con, TRUE);
}

// HTML 输出部分开始
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Cart - MaxDeal</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

 
    <div class="c-category-nav" style="padding:1rem; background:var(--light-color);">
        <a href="mycart.php?uid=<?php echo $user?>" class="c-button c-prim-button">My Cart</a>
        <a href="profile.php?uid=<?php echo $user?>" class="c-button c-sec-button">My Orders</a>
        <a href="my_delivery.php?uid=<?php echo $user?>" class="c-button c-sec-button">Delivery History</a>
        <a href="settings.php?uid=<?php echo $user?>" class="c-button c-sec-button">Settings</a>
    </div>

    
    <div class="c-cart-container">
        <?php if(!empty($error_message)): ?>
            <div class="error-message" style="color: red; padding: 15px; background: #ffeeee; border-radius: 5px; margin-bottom: 15px;">
                Error: <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        
<?php if(isset($success_message)): ?>
    
    <div class="c-success-container" style="display: flex; justify-content: center; align-items: center; min-height: 70vh; margin: 2rem 0;">
        <div class="c-order-success" style="width: 100%; max-width: 800px; padding: 2rem; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.15);">
            <?php echo $success_message; ?>
       <div style="text-align: center; margin-top: 2rem;">
                <a href="index.php" class="c-button c-prim-button c-continue-btn">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
        <?php else: ?>
        <div class="c-cart-items">
            <table class="c-cart-table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Description</th>
                        <th>Preview</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $query = "SELECT * FROM cart WHERE uid='$user' ORDER BY id DESC";
                    $run = mysqli_query($con, $query);
                    $total = 0;
                    if(mysqli_num_rows($run) > 0):
                    while ($row=mysqli_fetch_assoc($run)): 
                        $pid = $row['pid'];
                        $quantity = $row['quantity'];
                        
                        $query1 = "SELECT * FROM products WHERE id='$pid'";
                        $run1 = mysqli_query($con, $query1);
                        $row1=mysqli_fetch_assoc($run1);
                        $total += ($quantity * $row1['price']);
                    ?>
                    <tr>
                        <td><?= substr($row1['pName'], 0, 50) ?></td>
                        <td>$<?= $row1['price'] ?></td>
                        <td>
                            <div class="c-quantity-control">
                                <a href="delete_cart.php?sid=<?= $pid ?>" class="c-quantity-btn">-</a>
                                <span><?= $quantity ?></span>
                                <a href="delete_cart.php?aid=<?= $pid ?>" class="c-quantity-btn">+</a>
                            </div>
                        </td>
                        <td><?= $row1['description'] ?></td>
                        <td>
                            <img src="image/product/<?= $row1['item'] ?>/<?= $row1['picture'] ?>" 
                                 class="home-prodlist-imgi" 
                                 style="height:75px;width:75px;">
                        </td>
                        <td>
                            <a href="delete_cart.php?cid=<?= $pid ?>" class="c-remove-btn">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <tr class="c-total-price">
                        <td colspan="6">Total: $<?= $total ?></td>
                    </tr>
                    <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 20px;">Your cart is empty</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if(mysqli_num_rows($run) > 0): ?>
        <form action="" method="POST" class="registration">
            <div class="c-form-group">
                <label class="c-input-label">First Name:</label>
                <input type="text" name="fullname" value="<?= $uname_db ?>" 
                       class="c-search-bar" required>
            </div>
            
            <div class="c-form-group">
                <label class="c-input-label">Last Name:</label>
                <input type="text" name="lastname" value="<?= $ulast_db ?>"
                       class="c-search-bar" required>
            </div>

            <div class="c-form-group">
                <label class="c-input-label">Mobile Number:</label>
                <input type="tel" name="mobile" value="<?= $umob_db ?>"
                       class="c-search-bar" required>
            </div>

            <div class="c-form-group">
                <label class="c-input-label">Delivery Address:</label>
                <textarea name="address" class="c-search-bar" required><?= $uadd_db ?></textarea>
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

            <button type="submit" name="order" 
                    class="c-button c-prim-button c-block">
                Confirm Order ($<span id="totalDisplay"><?= $total ?></span>)
            </button>
        </form>
        <?php endif; ?>
        <?php endif; ?>
    </div>
    
<script>
let baseTotal = <?= ($total ?? 0) ?>;
document.getElementById('totalDisplay').textContent = baseTotal.toFixed(2);

function updateTotal(isExpress) {
    const totalDisplay = document.getElementById('totalDisplay');
    let calculatedTotal = baseTotal;
    
    if (isExpress) {
        calculatedTotal += 100;
    }
    
    totalDisplay.textContent = calculatedTotal.toFixed(2);
}
</script>

</body>
</html>