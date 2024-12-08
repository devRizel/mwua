
<link rel="icon" type="image/x-icon" href="uploads/users/rizel.png">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
<?php include 'setting/system.php'; ?>
<?php include 'theme/head.php'; ?>
<?php include 'theme/header.php'; ?>
<div class="forgot-password-wrapper">
  <div class="forgot-password">
  <div class="text-center">
       <img src="uploads/users/rizel.png" alt="IT Department Logo" style="width: 120px; height: auto; margin-bottom: 20px;">
       <h1 class="text-center">Enter Your Email</h1>
    </div>
    <br>
    <form method="post" autocomplete="off" class="animated-form">
      <div class="wrap-input100 validate-input">
        <input id="email" class="input100"  type="email" name="email" placeholder="Enter your email" required>
        <span class="focus-input100"></span>
        <span class="symbol-input100">
            <i class="fa fa-envelope" aria-hidden="true"></i>
        </span>
      </div>
      <div class="container-login100-form-btn">
        <button class="login100-form-btn" name="submit" type="submit"> Submit</button>
      </div>

      <div class="text-center p-t-12">
        <a class="txt2" href="Security_Detected.php?access=allowed">
        Back to Login
        </a>
      </div>

    </form>

    <?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;
    
    require "./phpmailer/src/Exception.php";
    require "./phpmailer/src/PHPMailer.php";
    require "./phpmailer/src/SMTP.php";

    if (!isset($_SESSION['failed_attempts'])) {
    $_SESSION['failed_attempts'] = 0;
    }

    if (isset($_POST['submit'])) {
      $username = trim($_POST['email']);
      $verification = str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT);
      
      $q = $db->query("SELECT * FROM users WHERE username = '$username' LIMIT 1 ");
      $count = $q->rowCount();

      if($count > 0){
        $update = $db->query("UPDATE users SET verification = '$verification' WHERE username = '$username'");
        if ($update) {
          $mail = new PHPMailer(true);
          $mail->SMTPDebug = 0;
          $mail->isSMTP();
          $mail->Host = 'smtp.gmail.com';
          $mail->SMTPAuth = true;
          $mail->Username = 'inventorym77@gmail.com';
          $mail->Password = 'ezvo nqde jzsf ouhl';
          $mail->Port = 587;

          $mail->SMTPOptions = array(
              'ssl' => array(
                  'verify_peer' => false,
                  'verify_peer_name' => false,
                  'allow_self_signed' => true
              )
          );

          $mail->setFrom('itinventorymanagement@gmail.com', 'InventoryManagement');

          $mail->addAddress($username);
          $mail->Subject = "Password Reset Request";
          
 
          $otp = $verification; 
          $mail->isHTML(true); 
          $mail->Body = "
          <html>
             <body style='font-family: Arial, sans-serif; background: url(\"https://itinventorymanagement.com/uploads/users/riz.png\"); background-size: cover; background-position: center; padding: 20px;'>
                  <div style='max-width: 600px; margin: auto; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);'>
                      <h2 style='color: #0062cc; text-align: center;'>Password Reset Request</h2>
                      <p style='font-size: 16px; color: #333;'>Hello,</p>
                      <p style='font-size: 16px; color: #333;'>We received a request to reset your password. To complete the process, please use the following OTP to reset your password:</p>
                      <p style='font-size: 18px; color: #333; font-weight: bold; text-align: center; padding: 10px; background-color: #e0f7fa; border-radius: 4px;'>
                          <strong>$otp</strong>
                      </p>
                       <p style='font-size: 16px; color: #333;'>If you need further assistance, feel free to contact me via Facebook: <a href='https://www.facebook.com/rizelbrace2' target='_blank' style='color: #0062cc; text-decoration: none;'>Rizel Mulle Bracero</a>.</p>
                  </div>
              </body>
          </html>
          ";
          $mail->send();
          header("Location: reset_password-portal.php?access=allowed");
          exit;
        }
      } else {
        $_SESSION['failed_attempts']++;

        if ($_SESSION['failed_attempts'] >= 3) {
            header("Location: Security_Detected.php?access=allowed");
            exit;
        }

        $error = 'Email Incorrect.';
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

<?php include_once('layouts/recapt.php'); ?>
