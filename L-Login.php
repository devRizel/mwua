<link rel="icon" type="image/x-icon" href="uploads/users/rizel.png">
<?php
function remove_php_extension($url) {
    return preg_replace('/\.php$/', '', $url);
}

$servername = "127.0.0.1";
$username = "u510162695_inventory";
$password = "1Inventory_system";
$dbname = "u510162695_inventory";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_ip = $_SERVER['REMOTE_ADDR'];

$query = "SELECT COUNT(*) as ip_exists FROM log WHERE access = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $user_ip);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['ip_exists'] == 0) {
    header("Location: index.html");
    exit();
}

if (!isset($_GET['access']) || $_GET['access'] !== 'allowed') {
    header("Location: index.html");
    exit();
}
?>
<?php include 'process/security_login.php'; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
<?php
date_default_timezone_set('Asia/Manila');
  ob_start();
  require_once('includes/load.php');
  if($session->isUserLoggedIn(true)) { redirect('home.php', false);}
?>
<?php include_once('layouts/header.php'); ?>
<div class="login-page-wrapper card-primary">
  <div class="login-page">
    <div class="text-center">
       <img src="uploads/users/rizel.png" alt="IT Department Logo" style="width: 120px; height: auto; margin-bottom: 20px;">
       <center><h1>BSIT</h1></center>
       <h4>Inventory Management System</h4>
    </div>
    <br>
    
    <center><?php echo display_msg($msg); ?></center>
    <form method="post"  action="<?= remove_php_extension('auth.php') ?>" class="clearfix">
      <div class="wrap-input100 validate-input">
        <input id="email" class="input100" type="email" name="username" placeholder="Enter your email" required>
        <span class="focus-input100"></span>
        <span class="symbol-input100">
            <i class="fa fa-envelope" aria-hidden="true"></i>
        </span>
      </div>

      <div class="wrap-input100 validate-input">
        <input id="password"  pattern="^[a-zA-Z0-9]+$" class="input100" type="password" name="password" placeholder="Enter your password">
        <span class="focus-input100"></span>
        <span class="symbol-input100">
            <i class="fa fa-lock" aria-hidden="true"></i>
        </span>
        <i id="togglePassword" class="fa fa-eye" style="position: absolute; right: 25px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
      </div>

        <div class="g-recaptcha" 
          data-sitekey="6LeXJ3sqAAAAAAb-tsUJO-EMzLW0Up5pX1SXhqGU"
          data-callback="recaptchaCallback">
        </div>
      <br>

      <div class="container-login100-form-btn">
        <button class="login100-form-btn" name="login" id="loginButton" disabled>
         Login
       </button>
      </div>

      <div class="text-center p-t-12">
        <a class="txt2" href="index.php">
          Back To Home
        </a>
        <span class="txt1">
          |
        </span>
        <a class="txt2" href="forgot_pass-portal.php?access=allowed">
          Forgot Password?
        </a>
      </div> 

      <div class="text-center p-t-136"></div>
    </form>
  </div>
</div>
<?php include_once('layouts/footer.php'); ?>
<?php include_once('theme/footer.php'); ?>
<style>
body {
    background: url('uploads/users/riz.png');
    background-size: cover; 
    background-position: center; 
}
.g-recaptcha {
    display: block; 
    margin: 10px auto; 
    box-sizing: border-box;
    width: 302px;
}
  .login-page-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 70vh;
    padding: 15px;
    box-sizing: border-box;
  }

  .login-page {
    width: 100%;
    max-width: 400px;
    padding: 20px;
    border: 1px solid #333;
    background-color: #fff;
    box-sizing: border-box;
    text-align: center;
  }

  .wrap-input100 {
    position: relative;
    width: 100%;
    margin-bottom: 20px;
  }

  .input100 {
    font-family: Poppins-Regular;
    font-size: 16px;
    color: #333;
    line-height: 1.2;
    display: block;
    width: 100%;
    background: #e6e6e6;
    height: 55px;
    border-radius: 25px;
    padding: 0 30px 0 68px;
    box-sizing: border-box;
  }

  .symbol-input100 {
    position: absolute;
    font-size: 18px;
    color: #999999;
    top: 50%;
    left: 35px;
    transform: translateY(-50%);
    transition: all 0.4s;
  }

  .container-login100-form-btn {
    width: 100%;
    display: flex;
    justify-content: center;
  }

  .login100-form-btn {
    font-family: Poppins-Medium;
    font-size: 16px;
    color: white;
    background-color: #333;
    border: none;
    border-radius: 25px;
    width: 100%;
    height: 50px;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 0 25px;
    transition: all 0.4s;
    cursor: pointer;
  }

  .txt1 {
    font-size: 14px;
    color: #999999;
    line-height: 1.5;
  }

  .txt2 {
    font-size: 14px;
    color: #333;
    text-decoration: none;
  }
</style>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
<script src="sweetalert.min.js"></script>
<?php
if (isset($_SESSION['sweet_alert']) && $_SESSION['sweet_alert']) {
    echo '<script>
        var countdownTime = ' . $_SESSION['countdown_time'] . '; 

        function startCountdown() {
            if (countdownTime > 0) {
                swal({
                    title: "Opps!",
                    text: "Too many attempts. Please try again in " + formatTime(countdownTime) + " minutes.",
                    icon: "error",
                    button: false, 
                    closeOnClickOutside: false,
                    closeOnEsc: false
                });

                countdownTime--;
                setTimeout(startCountdown, 1000); 
            } else {
                window.location.href = href;
            }
        }

        function formatTime(seconds) {
            var minutes = Math.floor(seconds / 60);
            var secs = seconds % 60;
            return minutes + ":" + (secs < 10 ? "0" : "") + secs;
        }

        startCountdown(); 
    </script>';

    unset($_SESSION['sweet_alert']);
    unset($_SESSION['countdown_time']);
}
?>
<?php
if (isset($_SESSION['alert']) && $_SESSION['alert']) {
    echo '<script>
        swal({
            title: "Opps!",
            text: "Sorry Username/Password incorrect.",
            icon: "error",
            button: "OK",
        }).then(() => {

            window.location.href = href;
        });
    </script>';
    unset($_SESSION['alert']);
}
?>
<?php
if (isset($_SESSION['alert2']) && $_SESSION['alert2']) {
    echo '<script>
        swal({
            title: "Opps!",
            text: "You are already logged in on another device.",
            icon: "error",
            button: "OK",
        }).then(() => {
           window.location.href = href;
        });
    </script>';
    unset($_SESSION['alert2']);
}
?>
<?php
if (isset($_SESSION['logout']) && $_SESSION['logout']) {
    echo '<script>
        swal({
            title: "Success",
            text: "Password updated. Please log in with your new one.",
            icon: "success",
            button: "OK",
        }).then(() => {
            window.location.href = href;
        });
    </script>';
    unset($_SESSION['logout']);
}
?>
<?php
if (isset($_SESSION['alert3']) && $_SESSION['alert3']) {
    echo '<script>
        swal({
            title: "Opps!",
            text: "Your IP address needs approval to log in.",
            icon: "error",
            button: "OK",
        }).then(() => {
            window.location.href = href;
        });
    </script>';
    unset($_SESSION['alert3']);
}
?>
<?php
if (isset($_SESSION['sql']) && $_SESSION['sql']) {
    echo '<script>
        swal({
            title: "Opps!",
            text: "Please login...",
            icon: "error",
            button: "OK",
        }).then(() => {
            window.location.href = href;
        });
    </script>';
    unset($_SESSION['sql']);
}
?>