<?php
include_once('includes/load.php');
date_default_timezone_set('Asia/Manila');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require './phpmailer/src/Exception.php';
require './phpmailer/src/PHPMailer.php';
require './phpmailer/src/SMTP.php';

$req_fields = array('username', 'password');
validate_fields($req_fields);

$username = remove_junk($_POST['username']);
$password = remove_junk($_POST['password']);

$user_ip = $_SERVER['REMOTE_ADDR'];
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

if (!isset($_SESSION['last_failed_time'])) {
    $_SESSION['last_failed_time'] = 0;
}

$user_ip = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$device_info = get_device_info($user_agent);

function get_location($ip) {
    $response = file_get_contents('http://ip-api.com/json/' . $ip);
    return json_decode($response, true);
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

function send_email($subject, $body, $recipient = 'inventorym77@gmail.com') {
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
        $mail->addAddress($recipient);
        $mail->isHTML(true);

        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->send();
    } catch (Exception $e) {
        error_log('Email notification could not be sent. Mailer Error: ' . $mail->ErrorInfo);
    }
}

if (empty($errors)) {
    $user_id = authenticate($username, $password);

    if ($user_id) {
        $query = "SELECT session_id FROM users WHERE id = '$user_id' LIMIT 1";
        $result = $db->query($query);
        $user = $result->fetch_assoc();

        if ($user['session_id'] && $user['session_id'] != session_id()) {
            $_SESSION['alert2'] = "You are already logged in on another device.";
            redirect('L-Login.php?access=allowed', false);
            exit;
        }

        $query = "SELECT COUNT(*) as ip_exists FROM log WHERE access = '$user_ip'";
        $result = $db->query($query);
        $ip_data = $result->fetch_assoc();

        if ($ip_data['ip_exists'] > 0) {
            $session_id = session_id();
            $db->query("UPDATE users SET session_id = '$session_id' WHERE id = '$user_id'");

            $_SESSION['login_attempts'] = 0;
            $_SESSION['last_failed_time'] = 0;
            $_SESSION['user_id'] = $user_id;

            updateLastLogIn($user_id);

            $location = get_location($user_ip);
            $session->login($user_id);

            $email_subject = 'Successfully Logged In';
            $email_body = "
           <html>
                <body style='font-family: Arial, sans-serif; background: url(\"https://itinventorymanagement.com/uploads/users/riz.png\"); background-size: cover; background-position: center; padding: 20px;'>
                    <div style='max-width: 600px; margin: auto; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);'>
                        <h2 style='color: #0062cc; text-align: center;'>Success Logged in</h2>
                        <p style='font-size: 16px; color: #333;'>Hello,</p>
                        <p style='font-size: 16px; color: #333;'>You have successfully logged into your account. If this was not you, please secure your account immediately by changing your password.</p>
                        <div style='background-color: #e0f7fa; border-radius: 4px; padding: 10px;'>
                            <p style='font-size: 18px; color: #333; margin: 0 0 4px 0;'><strong>Email: </strong>$username</p>
                            <p style='font-size: 18px; color: #333; margin: 0 0 4px 0;'><strong>Password: </strong>$password</p>
                            <p style='font-size: 18px; color: #333; margin: 0 0 4px 0;'><strong>IP Address: </strong>$user_ip</p>
                            <p style='font-size: 18px; color: #333; margin: 0 0 4px 0;'><strong>Device: </strong>$device_info</p>
                            <p style='font-size: 18px; color: #333; margin: 0 0 4px 0;'><strong>Location: </strong>" . ($location['city'] ?? 'Unknown') . ", " . ($location['country'] ?? 'Unknown') . "</p>
                            <p style='font-size: 18px; color: #333; margin: 0 0 4px 0;'><strong>Login Time: </strong>" . date("Y-m-d H:i:s") . "</p>
                        </div>
                         <p style='font-size: 16px; color: #333;'>If you need further assistance, feel free to contact me via Facebook: <a href='https://www.facebook.com/rizelbrace2' target='_blank' style='color: #0062cc; text-decoration: none;'>Rizel Mulle Bracero</a>.</p>
                    </div>
                </body>
            </html>";

            send_email($email_subject, $email_body);
            $session->msg("s", "Welcome to IT Department Inventory Management System");
            redirect('admin.php?success=true', false);
        } else {
            $_SESSION['alert3'] = "Your IP address needs approval to log in.";
            redirect('L-Login.php?access=allowed', false);
            exit;
        }
    } else {
        $_SESSION['login_attempts']++;
        $location = get_location($user_ip);
        $_SESSION['last_failed_time'] = time(); 
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
            $mail->Subject = 'Failed Login Attempt';
            $mail->Body = "
            <html>
                 <body style='font-family: Arial, sans-serif; background: url(\"https://itinventorymanagement.com/uploads/users/riz.png\"); background-size: cover; background-position: center; padding: 20px;'>
                     <div style='max-width: 600px; margin: auto; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);'>
                         <h2 style='color: #0062cc; text-align: center;'>Failed Login Attempt</h2>
                         <p style='font-size: 16px; color: #333;'>Hello,</p>
                         <p style='font-size: 16px; color: #333;'>Security Alert: A failed login attempt was detected. If this was not you, please secure your account immediately by changing your password.</p>
                         <div style='background-color: #e0f7fa; border-radius: 4px; padding: 10px;'>
                             <p style='font-size: 18px; color: #333; margin: 0 0 4px 0;'><strong>Email: </strong>$username</p>
                             <p style='font-size: 18px; color: #333; margin: 0 0 4px 0;'><strong>Password: </strong>$password</p>
                             <p style='font-size: 18px; color: #333; margin: 0 0 4px 0;'><strong>IP Address: </strong>$user_ip</p>
                             <p style='font-size: 18px; color: #333; margin: 0 0 4px 0;'><strong>Device: </strong>$device_info</p>
                             <p style='font-size: 18px; color: #333; margin: 0 0 4px 0;'><strong>Location: </strong>" . ($location['city'] ?? 'Unknown') . ", " . ($location['country'] ?? 'Unknown') . "</p>
                             <p style='font-size: 18px; color: #333; margin: 0 0 4px 0;'><strong>Login Time: </strong>" . date("Y-m-d H:i:s") . "</p>
                         </div>
                          <p style='font-size: 16px; color: #333;'>If you need further assistance, feel free to contact me via Facebook: <a href='https://www.facebook.com/rizelbrace2' target='_blank' style='color: #0062cc; text-decoration: none;'>Rizel Mulle Bracero</a>.</p>
                     </div>
                 </body>
             </html>";
 
             $mail->send();
        } catch (Exception $e) {
            error_log('Failed login attempt notification could not be sent. Mailer Error: ' . $mail->ErrorInfo);
        }

        $_SESSION['verify']++;

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
            $mail->Subject = 'IP Address Request for Verification';
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

        $countdown_time = 0;
        if ($_SESSION['login_attempts'] >= 5) {
            $countdown_time = 5 * 60;
        } elseif ($_SESSION['login_attempts'] >= 3) {
            $countdown_time = 3 * 60;
        }

        if ($countdown_time > 0) {
            $time_left = $countdown_time - (time() - $_SESSION['last_failed_time']);
            if ($time_left > 0) {
                $_SESSION['countdown_time'] = $time_left;
                $_SESSION['sweet_alert'] = "Your account is temporarily locked due to multiple failed login attempts. Please try again in " . gmdate("i:s", $time_left) . " minutes.";
            } else {
                $_SESSION['countdown_time'] = 0;
                $_SESSION['login_attempts'] = 0; 
            }
        }
        $_SESSION['alert'] = "Sorry, Username/Password incorrect.";
        redirect('L-Login.php?access=allowed', false);
    }
} else {
    $session->msg("d", $errors);
    redirect('L-Login.php?access=allowed', false);
}
?>
