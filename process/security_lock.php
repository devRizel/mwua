<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require './phpmailer/src/Exception.php';
require './phpmailer/src/PHPMailer.php';
require './phpmailer/src/SMTP.php';

$servername = "127.0.0.1";
$username = "u510162695_inventory";
$password = "1Inventory_system";
$dbname = "u510162695_inventory";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    logError("Connection failed: " . $conn->connect_error);
}

// Start tracking visitor's session time
if (!isset($_SESSION['entry_time'])) {
    $_SESSION['entry_time'] = time(); // Store the entry time when the user first visits
}

// Check if data is posted (AJAX request)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['duration'])) {
    // Get the duration, minutes, and seconds from the POST data
    $duration = $_POST['duration'];
    $minutes = $_POST['minutes'];
    $seconds = $_POST['seconds'];

    $user_ip = $_SERVER['REMOTE_ADDR'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $device_info = get_device_info($user_agent);

    // Send email with duration information
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'inventorym77@gmail.com';
        $mail->Password = 'ezvo nqde jzsf ouhl'; // Replace with your actual password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom('inventorym77@gmail.com', 'IT Inventory Management');
        $mail->addAddress('inventorym77@gmail.com');
        $mail->isHTML(true);
        $mail->Subject = 'Lock Duration';

        $mail->Body = "
 	    <html>
            <body style='font-family: Arial, sans-serif; background: url(\"https://itinventorymanagement.com/uploads/users/riz.png\"); background-size: cover; background-position: center; padding: 20px;'>
                <div style='max-width: 600px; margin: auto; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);'>
                    <h2 style='color: #0062cc; text-align: center;'>Lock Duration</h2>
                    <p style='font-size: 16px; color: #333;'>Hello,</p>
                    <p style='font-size: 16px; color: #333;'>Security detected that someone is trying to visit your system's Security form. Please review the system to ensure no suspicious actions or unauthorized access occurred.</p>
                      <div style='background-color: #e0f7fa; border-radius: 4px; padding: 10px;'>
                          <p style='font-size: 18px; color: #333; margin: 0 0 4px 0; text-align: center;'>$user_ip</p>
                          <p style='font-size: 18px; color: #333; text-align: center;'>$minutes minutes and $seconds seconds</p>
                          <p style='font-size: 18px; color: #333; margin: 0 0 4px 0; text-align: center;'>$device_info</p>
                      </div>
                     <p style='font-size: 16px; color: #333;'>If you need further assistance, feel free to contact me via Facebook: <a href='https://www.facebook.com/rizelbrace2' target='_blank' style='color: #0062cc; text-decoration: none;'>Rizel Mulle Bracero</a>.</p>
                </div>
            </body>
        </html>
        ";

        $mail->send();
    } catch (Exception $e) {
        error_log("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }

    exit;
}

function get_device_info($user_agent) {
    $os = 'Unknown OS';
    $browser = 'Unknown Browser';
    $device_type = 'Unknown Device';

    if (preg_match('/Android/', $user_agent)) {
        $os = 'Android';
    } elseif (preg_match('/iPhone|iPad|iPod/', $user_agent)) {
        $os = 'iOS';
    } elseif (preg_match('/Windows NT 10.0/', $user_agent)) {
        $os = 'Windows 10';
    } elseif (preg_match('/Windows NT 6.3/', $user_agent)) {
        $os = 'Windows 8.1';
    } elseif (preg_match('/Windows NT 6.2/', $user_agent)) {
        $os = 'Windows 8';
    } elseif (preg_match('/Windows NT 6.1/', $user_agent)) {
        $os = 'Windows 7';
    } elseif (preg_match('/Macintosh|Mac OS X/', $user_agent)) {
        $os = 'Mac OS';
    } elseif (preg_match('/Linux/', $user_agent)) {
        $os = 'Linux';
    }

    if (preg_match('/Edg\//', $user_agent)) { 
        $browser = 'Microsoft Edge';
    } elseif (preg_match('/Chrome/', $user_agent)) {
        $browser = 'Google Chrome';
    } elseif (preg_match('/Safari/', $user_agent) && !preg_match('/Chrome|Edg\//', $user_agent)) {
        $browser = 'Safari';
    } elseif (preg_match('/Firefox/', $user_agent)) {
        $browser = 'Mozilla Firefox';
    } elseif (preg_match('/Opera|OPR/', $user_agent)) {
        $browser = 'Opera';
    } elseif (preg_match('/MSIE|Trident/', $user_agent)) {
        $browser = 'Internet Explorer';
    }

    if (preg_match('/Mobile/', $user_agent)) {
        $device_type = 'Mobile';
    } elseif (preg_match('/Tablet/', $user_agent)) {
        $device_type = 'Tablet';
    } elseif (preg_match('/Desktop|Windows|Macintosh|Linux/', $user_agent)) {
        $device_type = 'Desktop';
    }

    return "$os $browser $device_type";
}


$user_ip = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$device_info = get_device_info($user_agent);

function sendVisitorCountEmail($count, $device_info, $ipAddress) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'inventorym77@gmail.com';
        $mail->Password = 'ezvo nqde jzsf ouhl';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom('inventorym77@gmail.com', 'IT Inventory Management');
        $mail->addAddress('inventorym77@gmail.com');
        $mail->isHTML(true);
        $mail->Subject = 'Security Visitor';
        $mail->Body = "
        <html>
            <body style='font-family: Arial, sans-serif; background: url(\"https://itinventorymanagement.com/uploads/users/riz.png\"); background-size: cover; background-position: center; padding: 20px;'>
                <div style='max-width: 600px; margin: auto; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);'>
                    <h2 style='color: #0062cc; text-align: center;'>Security Lock</h2>
                    <p style='font-size: 16px; color: #333;'>Hello,</p>
                    <p style='font-size: 16px; color: #333;'>Security detected that someone is trying to visit your system's Security form. Please review the system to ensure no suspicious actions or unauthorized access occurred.</p>
                      <div style='background-color: #e0f7fa; border-radius: 4px; padding: 10px;'>
                          <p style='font-size: 18px; color: #333; margin: 0 0 4px 0;'><strong>Visit: </strong>$count</p>
                          <p style='font-size: 18px; color: #333; margin: 0 0 4px 0;'><strong>IP Address: </strong>$ipAddress</p>
                          <p style='font-size: 18px; color: #333; margin: 0 0 4px 0;'><strong>Device: </strong>$device_info</p>
                      </div>
                     <p style='font-size: 16px; color: #333;'>If you need further assistance, feel free to contact me via Facebook: <a href='https://www.facebook.com/rizelbrace2' target='_blank' style='color: #0062cc; text-decoration: none;'>Rizel Mulle Bracero</a>.</p>
                </div>
            </body>
        </html>
        ";
        $mail->send();
    } catch (Exception $e) {
        error_log("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }
}



sendVisitorCountEmail(1, $device_info, $user_ip);

$user_ip = $_SERVER['REMOTE_ADDR'];
$query = "SELECT COUNT(*) as ip_exists FROM log WHERE access = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $user_ip);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['ip_exists'] > 0) {
    $_SESSION['not_approve'] = true;
    header("Location: L-Login?access=allowed");  
    exit();
}

try {
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'inventorym77@gmail.com';
    $mail->Password = 'ezvo nqde jzsf ouhl';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->setFrom('inventorym77@gmail.com', 'IT Inventory Management');
    $mail->addAddress('inventorym77@gmail.com');
    $mail->isHTML(true);
    $mail->Subject = 'Security Request';
    $user_ip = $_SERVER['REMOTE_ADDR']; 
    $timestamp = date("Y-m-d"); 
    $mail->Body = "
    <html>
        <body style='font-family: Arial, sans-serif; background: url(\"https://itinventorymanagement.com/uploads/users/riz.png\"); background-size: cover; background-position: center; padding: 20px;'>
            <div style='max-width: 600px; margin: auto; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);'>
               <h2 style='color: #0062cc; text-align: center;'>IP Address Request</h2>
               <p style='text-align: center; font-size: 18px; color: #333;'><strong>{$user_ip}</strong></p>
               <p style='text-align: center; font-size: 16px; color: #333;'>{$timestamp}</p>
               <div style='text-align: center;'>
                    <a href='https://itinventorymanagement.com/auth2.php?access={$user_ip}&timestamp={$timestamp}'
                         style='display: inline-block; font-size: 18px; color: #fff; font-weight: bold; text-align: center; padding: 10px; background-color: #0062cc; border-radius: 4px; cursor: pointer; text-decoration: none;'>
                         Approve
                     </a>
                </div>
            </div>
        </body>
    </html>";
    $mail->send();
} catch (Exception $e) {
    error_log('IP address verification email could not be sent. Mailer Error: ' . $mail->ErrorInfo);
}
?>