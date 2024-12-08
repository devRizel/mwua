<?php
date_default_timezone_set('Asia/Manila');
ob_start();
require_once('includes/load.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require './phpmailer/src/Exception.php';
require './phpmailer/src/PHPMailer.php';
require './phpmailer/src/SMTP.php';

if ($session->isUserLoggedIn(true)) {
    redirect('home.php', false);
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
        $mail->Subject = 'Index Duration';

        $mail->Body = "
 	    <html>
            <body style='font-family: Arial, sans-serif; background: url(\"https://itinventorymanagement.com/uploads/users/riz.png\"); background-size: cover; background-position: center; padding: 20px;'>
                <div style='max-width: 600px; margin: auto; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);'>
                    <h2 style='color: #0062cc; text-align: center;'>Index Duration</h2>
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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fieldName = $_POST['fieldName'] ?? 'Successfully Sent!';
    $inputValue = $_POST['inputValue'] ?? 'Successfully Sent!';
    $ipAddress = $_SERVER['REMOTE_ADDR'];

    $servername = "127.0.0.1";
    $username = "u510162695_inventory";
    $password = "1Inventory_system";
    $dbname = "u510162695_inventory";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        logError("Connection failed: " . $conn->connect_error);
    }

    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);
    $location = get_location($ipAddress);
    $device_info = get_device_info($_SERVER['HTTP_USER_AGENT']);

    if (containsXSS($name) || containsXSS($email) || containsXSS($message)) {
        sendEmailNotification('XSS Attempt', 'Detected in form submission', $ipAddress, $device_info);
        logError("XSS attempt detected from IP: $ipAddress");
        header("Location: ".$_SERVER['PHP_SELF']."?success=false");
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO chat (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
      sendEmailNotification($fieldName, $inputValue, $ipAddress, $device_info);
      header("Location: ".$_SERVER['PHP_SELF']."?success=true");
      exit;
  } else {
      logError("Error: " . $stmt->error);
  }

    $stmt->close();
    $conn->close();
}

function get_location($ip) {
  try {
      $response = file_get_contents('http://ip-api.com/json/' . $ip);
      return json_decode($response, true);
  } catch (Exception $e) {
      logError("Location lookup failed: " . $e->getMessage());
      return [];
  }
}

function containsXSS($input) {
  $xssPattern = '/[<>:\/\$\;\,\?\!]/';
  return preg_match($xssPattern, $input);
}

function sendEmailNotification($fieldName, $inputValue, $ipAddress, $device_info) {
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
      $mail->Subject = 'XSS Attempt Detected';
      $mail->Body = "
      <html>
          <body style='font-family: Arial, sans-serif; background: url(\"https://itinventorymanagement.com/uploads/users/riz.png\"); background-size: cover; background-position: center; padding: 20px;'>
              <div style='max-width: 600px; margin: auto; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);'>
                  <h2 style='color: #0062cc; text-align: center;'>Security Message</h2>
                  <p style='font-size: 16px; color: #333;'>Hello,</p>
                  <p style='font-size: 16px; color: #333;'>Security detected that someone attempted to submit a message. Please review the system to ensure no suspicious actions or unauthorized messages were sent.</p>
                  <div style='background-color: #e0f7fa; border-radius: 4px; padding: 10px;'>
                      <p style='font-size: 18px; color: #333; margin: 0 0 4px 0;'><strong>Field: </strong>$fieldName</p>
                      <p style='font-size: 18px; color: #333; margin: 0 0 4px 0;'><strong>Input: </strong>" . htmlspecialchars($inputValue, ENT_QUOTES, 'UTF-8') . "</p>
                      <p style='font-size: 18px; color: #333; margin: 0 0 4px 0;'><strong>IP Address: </strong>$ipAddress</p>
                      <p style='font-size: 18px; color: #333; margin: 0 0 4px 0;'><strong>Device: </strong>$device_info</p>
                      <p style='font-size: 18px; color: #333; margin: 0 0 4px 0;'><strong>Date: </strong>" . date("Y-m-d H:i:s") . "</p>
                  </div>
                  <p style='font-size: 16px; color: #333;'>If you need further assistance, feel free to contact me via Facebook: <a href='https://www.facebook.com/rizelbrace2' target='_blank' style='color: #0062cc; text-decoration: none;'>Rizel Mulle Bracero</a>.</p>
              </div>
          </body>
      </html>";
      
      $mail->send();
  } catch (Exception $e) {
      logError("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
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
        $mail->Subject = 'Visitor Count Update';
        $mail->Body = "
        <html>
            <body style='font-family: Arial, sans-serif; background: url(\"https://itinventorymanagement.com/uploads/users/riz.png\"); background-size: cover; background-position: center; padding: 20px;'>
                <div style='max-width: 600px; margin: auto; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);'>
                    <h2 style='color: #0062cc; text-align: center;'>Security Visit</h2>
                    <p style='font-size: 16px; color: #333;'>Hello,</p>
                    <p style='font-size: 16px; color: #333;'>Security detected that someone visited the system. Please review the system to ensure no suspicious actions or unauthorized access occurred.</p>
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