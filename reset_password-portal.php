
<link rel="icon" type="image/x-icon" href="uploads/users/rizel.png">
<?php include 'setting/system.php'; ?>
<?php include 'theme/head.php'; ?>
<?php include 'theme/header.php'; ?>
<div class="forgot-password-wrapper">
    <div class="forgot-password">
    <div class="text-center">
       <img src="uploads/users/rizel.png" alt="IT Department Logo" style="width: 120px; height: auto; margin-bottom: 20px;">
      <h1 class="text-center">Reset Password</h1>
      </div>
        <form method="post" autocomplete="off" class="animated-form">

            <div class="wrap-input100 validate-input">
        <input id="verification"   class="input100" type="text" name="verification" placeholder="Enter Your Verification">
        <span class="focus-input100"></span>
        <span class="symbol-input100">
        </span>
      </div>

            <div class="wrap-input100 validate-input">
        <input id="NewPassword"  class="input100" type="password" name="new" placeholder="Enter your new password">
        <span class="focus-input100"></span>
        <span class="symbol-input100">
            <i class="fa fa-lock" aria-hidden="true"></i>
        </span>
        <i id="toggleNewPassword" class="fa fa-eye" style="position: absolute; right: 25px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
      </div>

            <div class="wrap-input100 validate-input">
        <input id="ConfirmPassword"   class="input100" type="password" name="confirm" placeholder="Enter your confirm password">
        <span class="focus-input100"></span>
        <span class="symbol-input100">
            <i class="fa fa-lock" aria-hidden="true"></i>
        </span>
        <i id="togglePassword" class="fa fa-eye" style="position: absolute; right: 25px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
      </div>

      <div class="container-login100-form-btn">
        <button class="login100-form-btn"  name="submit" type="submit">
        Submit
        </button>
      </div>

      <div class="text-center p-t-12">
        <a class="txt2" href="Security_Detected.php?access=allowed">
        Back to Login
        </a>
      </div>

        </form>

        <?php

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

        if (isset($_POST['submit'])) {
            $verification = trim($_POST['verification']);
            $new = $_POST['new'];
            $confirm = $_POST['confirm'];
        
            $q = $db->query("SELECT * FROM users WHERE verification = '$verification' LIMIT 1");
            $count = $q->rowCount();
        
            if ($count > 0) {
                if (strlen($new) < 8) {
                    $error = 'Password must be at least 8 characters.';
                } else if ($new !== $confirm) {
                    $error = 'Passwords Don\'t Match';
                } else {
                  
                    $hashedPassword = password_hash($new, PASSWORD_BCRYPT);
                    $update = $db->query("UPDATE users SET password = '$hashedPassword', verification = NULL WHERE verification = '$verification'");
                    
                    if ($update) {
                        $message = "Password Updated Successfully. Login with your New Password.";
                        ?>
                        <script>
                            setTimeout(() => {
                                window.location.href = "Security_Detected.php?access=allowed"
                            }, 3000);
                        </script>
                        <?php
                    }
                }
            } else {
                $error = 'Verification Incorrect.';
            }
        }
        ?>
    </div>
</div>
<style>
body {
    background: url('uploads/users/riz.png');
    background-size: cover; 
    background-position: center; 
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
    border: 1px solid #ccc;
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
  .forgot-password-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    padding: 15px;
    box-sizing: border-box;
  }

  .forgot-password {
    width: 100%;
    max-width: 400px;
    padding: 20px;
    border: 1px solid #333;
    background-color: #fff;
    animation: borderAnimation 5s infinite;
    box-sizing: border-box;
  }

</style>


<!---START---->
<!---START---->
<!---START---->
<?php
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
<!---END---->
<!---END---->
<!---END---->


<?php
date_default_timezone_set('Asia/Manila');
  ob_start();
  require_once('includes/load.php');
  if($session->isUserLoggedIn(true)) { redirect('home.php', false);}
?>
<script src="css/log.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
<script>
  document.getElementById('togglePassword').style.display = 'none';
  document.getElementById('ConfirmPassword').addEventListener('input', function() {
    var togglePassword = document.getElementById('togglePassword');
    togglePassword.style.display = this.value.length > 0 ? 'block' : 'none';
  });

  document.getElementById('togglePassword').addEventListener('click', function() {
    var passwordInput = document.getElementById('ConfirmPassword');
    var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    this.classList.toggle('fa-eye');
    this.classList.toggle('fa-eye-slash');
  });
</script>
<script>
  document.getElementById('toggleNewPassword').style.display = 'none';
  document.getElementById('NewPassword').addEventListener('input', function() {
    var togglePassword = document.getElementById('toggleNewPassword');
    togglePassword.style.display = this.value.length > 0 ? 'block' : 'none';
  });

  document.getElementById('toggleNewPassword').addEventListener('click', function() {
    var passwordInput = document.getElementById('NewPassword');
    var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    this.classList.toggle('fa-eye');
    this.classList.toggle('fa-eye-slash');
  });
</script>
   <script src="css/sweetalert.js"></script>
<?php
if (isset($error)) { ?>
    <script type="text/javascript">
        swal({
            title: 'Opps!',
            text: '<?php echo $error; ?>',
            icon: "error",
            button: "OK",
      }).then(() => {
            window.location.href = href;
        });
    </script>
<?php } ?>
<?php
if (isset($message)) { ?>
    <script type="text/javascript">
        swal({
            title: 'Success',
            text: '<?php echo $message; ?>',
            icon: "success",
            button: "OK",
      }).then(() => {
            window.location.href = href;
        });
    </script>
<?php } ?>
<?php include_once('layouts/recapt.php'); ?>