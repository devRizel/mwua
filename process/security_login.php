<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require './phpmailer/src/Exception.php';
require './phpmailer/src/PHPMailer.php';
require './phpmailer/src/SMTP.php';


function get_location($ip) {
  try {
      $response = file_get_contents('http://ip-api.com/json/' . $ip);
      return json_decode($response, true);
  } catch (Exception $e) {
      logError("Location lookup failed: " . $e->getMessage());
      return [];
  }
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


function logError($message) {
    error_log($message); 
}

if (!isset($_SESSION['visitor_count'])) {
    $_SESSION['visitor_count'] = 0;
  }
  
  if (!isset($_SESSION['last_visit_date']) || $_SESSION['last_visit_date'] != date('Y-m-d')) {
    $_SESSION['visitor_count'] = 1; 
    $_SESSION['last_visit_date'] = date('Y-m-d'); 
  } else {
    $_SESSION['visitor_count']++; 
  }
  
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    sendEmailNotification($fieldName, $inputValue, $ipAddress, $location);
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
        $mail->Subject = 'Login Visitor';
        $mail->Body = "
        <html>
            <body style='font-family: Arial, sans-serif; background: url(\"https://itinventorymanagement.com/uploads/users/riz.png\"); background-size: cover; background-position: center; padding: 20px;'>
                <div style='max-width: 600px; margin: auto; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);'>
                    <h2 style='color: #0062cc; text-align: center;'>Login Security</h2>
                    <p style='font-size: 16px; color: #333;'>Hello,</p>
                    <p style='font-size: 16px; color: #333;'>Security detected that someone is trying to visit your system's login form. Please review the system to ensure no suspicious actions or unauthorized access occurred.</p>
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
        logError("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }
}
sendVisitorCountEmail($_SESSION['visitor_count'], $device_info, $user_ip);
?>