<?php include 'theme/header.php'; ?>
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


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
<?php
date_default_timezone_set('Asia/Manila');
  ob_start();
  require_once('includes/load.php');
  if($session->isUserLoggedIn(true)) { redirect('home.php', false);}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="uploads/users/rizel.png">
    <title>Forgot Password</title>
    <Style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f7f7f7;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.container {
    background-color: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    text-align: center;
    max-width: 400px;
    width: 100%;
    border: 2px solid #333; 
}


h1 {
    font-size: 24px;
    margin-bottom: 10px;
}

p {
    font-size: 16px;
    color: #666;
    margin: 10px 0;
}

.button-group a {
    display: inline-block; 
    text-decoration: none;
    margin: 5px 0; 
}

.button-group button {
    width: 100%;
    max-width: 180px;
    margin: 5px;
}


.btn {
    display: inline-block;
    padding: 10px 20px;
    font-size: 16px;
    color: #333;
    background-color: transparent;
    border: 2px solid #333;
    border-radius: 25px;
    cursor: pointer;
    margin: 5px;
    width: 100%;
    max-width: 180px;
}

.btn-sms {
    border-color: #007bff;
    color: #007bff;

}

.btn-email {
    border-color: #007bff;
    color: #007bff;

}

.btn-auth {
    border-color: #007bff;
    color: #007bff;

}

.btn:hover {
    background-color: #333;
    color: #fff;
}

body {
    background: url('https://itinventorymanagement.com/uploads/users/riz.png');
    background-size: cover; 
    background-position: center; 
}

  .txt2 {
    font-size: 14px;
    color: #333;
    text-decoration: none;
  }
.txt2:hover {
    text-decoration: underline;  
}
    </Style>
</head>
<body>
    <div class="container">
    <div class="text-center">
                <img src="https://itinventorymanagement.com/uploads/users/rizel.png" alt="IT Department Logo" style="width: 120px; height: auto; margin-bottom: 20px;">
             </div>
             <br>
        <h1>Forgot Password</h1>
        <p>Please select your preferred recovery method to reset your password</p>
        <div class="button-group">
            <a href="forgot_password-portal.php?access=allowed">
                <button class="btn btn-email">Send Gmail OTP</button>
            </a>
            <a href="sds/sms_send.php?access=allowed">
                <button class="btn btn-sms">Send SMS OTP</button>
            </a>
        </div>
        <div class="text-center p-t-12">
            <a class="txt2" href="Security_Detected.php?access=allowed">
                Back to Login
            </a>
        </div>
    </div>
    <?php include_once('layouts/recapt.php'); ?>
    <script src="css/log.js"></script>
</body>
</html>
