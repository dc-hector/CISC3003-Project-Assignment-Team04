<?php 
include ("inc/connect.inc.php"); // 这会引入 $con 变量而不是 $conn
ob_start();
session_start();

// 验证数据库连接
if ($con->connect_error) {
    die("Database connection failed: " . $con->connect_error);
}

$error = '';
$success = '';
$show_password_form = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email'])) {
        // 第一阶段：验证邮箱
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        
        // 查询数据库
        $stmt = $con->prepare("SELECT id FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $_SESSION['reset_email'] = $email;
            $show_password_form = true;
        } else {
            $error = "Email not found in our system";
        }
        $stmt->close();
        
    } elseif (isset($_POST['new_password']) && isset($_SESSION['reset_email'])) {
        // 第二阶段：处理密码重置
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        
        // 密码验证
        if (strlen($new_password) < 8) {
            $error = "Password must be at least 8 characters";
            $show_password_form = true;
        } elseif ($new_password !== $confirm_password) {
            $error = "Passwords do not match";
            $show_password_form = true;
        } else {
            // 哈希新密码 - 注意：在登录系统中使用的是 md5 哈希
            $hashed_password = md5($new_password);
            
            // 更新数据库
            $stmt = $con->prepare("UPDATE user SET password = ? WHERE email = ?");
            $stmt->bind_param("ss", $hashed_password, $_SESSION['reset_email']);
            
            if ($stmt->execute()) {
                $success = "Password updated successfully!";
                unset($_SESSION['reset_email']);
                $show_password_form = false;
                
                // 在成功更新密码后，延迟3秒然后重定向到登录页面
                header("Refresh: 3; URL=login.php");
            } else {
                $error = "Error updating password. Please try again later.";
                $show_password_form = true;
            }
            $stmt->close();
        }
    }
}
$con->close(); // 使用 $con 而不是 $conn
?>

<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
    <link rel="stylesheet" type="text/css" href="./css/main.css">
    <style>
        /* 添加白色文本的样式 */
        body {
            color: white;
        }
        .text-success {
            color: white;
            font-weight: bold;
        }
        .forgetpass-error-msg {
            color: white;
        }
        .redirect-message {
            color: white;
        }
        .redirect-message a {
            color: #4fc3f7; /* 淡蓝色，更容易在暗背景上看清 */
            text-decoration: underline;
        }
        h2 {
            color: white;
        }
    </style>
</head>
<body class="signin-body">
<div class="holecontainer">
    <div class="forgetpass-container">
        <div class="forgetpass-form_content">
            <h2>Password Reset</h2>
            
            <?php if ($error): ?>
                <div class="forgetpass-error-msg"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="text-success"><?= htmlspecialchars($success) ?></div>
                <p class="redirect-message">You will be redirected to the login page in 3 seconds. If not, please <a href="login.php">click here</a>.</p>
            <?php endif; ?>

            <?php if (!$show_password_form && !$success): ?>
                <!-- 邮箱验证表单 -->
                <form method="POST">
                    <div class="signup_form">
                        <input type="email" 
                               name="email" 
                               class="forgetpass-input" 
                               placeholder="Enter your email"
                               required
                               autofocus>
                        <button type="submit" 
                                class="forgetpass-button">
                            Verify Email
                        </button>
                    </div>
                </form>
            <?php elseif ($show_password_form && !$success): ?>
                <!-- 密码重置表单 -->
                <form method="POST">
                    <div class="signup_form">
                        <input type="password" 
                               name="new_password" 
                               class="forgetpass-input" 
                               placeholder="New Password"
                               minlength="8"
                               required>
                        
                        <input type="password" 
                               name="confirm_password" 
                               class="forgetpass-input" 
                               placeholder="Confirm Password"
                               minlength="8"
                               required>
                        
                        <button type="submit" 
                                class="forgetpass-button">
                            Reset Password
                        </button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>