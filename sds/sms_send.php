<link rel="icon" type="image/x-icon" href="../uploads/users/rizel.png">
<?php include '../theme/header.php'; ?>

<?php
session_start();
require_once '../vendor/autoload.php';

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
    header("Location: ../index.html");
    exit();
}

if (!isset($_GET['access']) || $_GET['access'] !== 'allowed') {
    header("Location: ../index.html");
    exit();
}

class SMSGateway {
  private $apiUrl;
  private $apiKey;

  public function __construct() {
    $this->apiUrl = 'https://51x82g.api.infobip.com/sms/2/text/advanced';
    $this->apiKey = '770111100f0a3e95a69f217e3b833e83-1337f8bf-31d2-4ba4-9cf9-a5a2ceebb1e6';
}

  public function sendSMS($phone, $message) {
      try {
          $data = [
              "messages" => [
                  [
                      "destinations" => [
                          ["to" => $phone]
                      ],
                      "text" => $message
                  ]
              ]
          ];

          $ch = curl_init();
          curl_setopt_array($ch, [
              CURLOPT_URL => $this->apiUrl,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_POST => true,
              CURLOPT_POSTFIELDS => json_encode($data),
              CURLOPT_HTTPHEADER => [
                  'Authorization: App ' . $this->apiKey,
                  'Content-Type: application/json'
              ]
          ]);

          $response = curl_exec($ch);

          if (curl_errno($ch)) {
              error_log('Infobip SMS Error: ' . curl_error($ch));
              return false;
          }

          curl_close($ch);

          $result = json_decode($response, true);
          if (isset($result['messages'][0]['status']['groupName']) &&
              $result['messages'][0]['status']['groupName'] === "PENDING") {
              return true;
          }

          error_log('Infobip SMS Error: ' . $response);
          return false;
      } catch (Exception $e) {
          error_log('Infobip SMS Exception: ' . $e->getMessage());
          return false;
      }
  }
}

function sendSMS($phone, $message) {
  $smsGateway = new SMSGateway();
  if (substr($phone, 0, 1) === '0') {
      $phone = '+63' . substr($phone, 1);
  }

  return $smsGateway->sendSMS($phone, $message);
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

function standardizePhoneNumber($phone) {
    $phone = preg_replace('/[^0-9]/', '', $phone);

    if (substr($phone, 0, 2) === '63') {
        $phone = '0' . substr($phone, 2);
    }
    
    return $phone;
}

function formatPhoneForSMS($phone) {
    $phone = preg_replace('/[^0-9]/', '', $phone);

    if (substr($phone, 0, 1) === '0') {
        return '+63' . substr($phone, 1);
    }

    if (substr($phone, 0, 2) === '63') {
        return '+' . $phone;
    }

    return '+63' . $phone;
}

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $phone = $_POST['phone'];

        $standardizedPhone = standardizePhoneNumber($phone);
        
        error_log("Looking up standardized phone: " . $standardizedPhone);
        
        $stmt = $conn->prepare("SELECT id FROM users WHERE phone = ?");
        if (!$stmt) {
            throw new Exception("Database prepare error: " . $conn->error);
        }
        
        $stmt->bind_param("s", $standardizedPhone);
        if (!$stmt->execute()) {
            throw new Exception("Database execute error: " . $stmt->error);
        }
        
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $otp = sprintf("%06d", mt_rand(0, 999999));
            $_SESSION['reset_phone'] = $standardizedPhone;
            $_SESSION['OTP_TIMESTAMP'] = time();
            
            $update_stmt = $conn->prepare("UPDATE users SET SMSOTP = ?, OTP_TIMESTAMP = CURRENT_TIMESTAMP WHERE phone = ?");
            if (!$update_stmt) {
                throw new Exception("Database prepare error: " . $conn->error);
            }
            
            $update_stmt->bind_param("ss", $otp, $standardizedPhone);
            
            if (!$update_stmt->execute()) {
                throw new Exception("Failed to update OTP: " . $update_stmt->error);
            }
            
            $smsPhone = formatPhoneForSMS($standardizedPhone);
            
            $message = "Your OTP is: " . $otp . ". You can use this to reset your password. Have a Good Day. - IT Team!";
             
            error_log("Attempting to send SMS to: " . $smsPhone);
            error_log("Message content: " . $message);
            
            if (!sendSMS($smsPhone, $message)) {
                throw new Exception("Failed to send SMS. Please try again later.");
            }
            
            $_SESSION['success_message'] = "OTP sent successfully! Please check your phone.";
            header("Location: sms_otp.php?access=allowed");
            exit();
            
        } else {
            throw new Exception("Phone number not found.");
        }
        
    } catch (Exception $e) {
        $error = $e->getMessage();
        error_log("Forgot Password Error: " . $error);
    } finally {
        if (isset($stmt) && $stmt instanceof mysqli_stmt) {
            $stmt->close();
        }
        if (isset($update_stmt) && $update_stmt instanceof mysqli_stmt) {
            $update_stmt->close();
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <title>OTP Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            width: 100%;
    max-width: 400px;
    padding: 20px;
    border: 1px solid #ccc;
    background-color: #fff;
    box-sizing: border-box;
    border-color: #333;
    text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }
        label {
            font-size: 16px;
            color: #333;
            display: block;
            margin-bottom: 8px;
        }
        .instructions {
            font-size: 14px;
            color: #555;
            margin-top: 10px;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }
        .success {
            color: green;
            margin-bottom: 10px;
        }

        .login {
            font-size: 14px;
            color: black;
            margin-top: 10px;
            font-weight:bold;
            cursor:pointer;
        }

        .login a{
            color: grey;
        }
        body {
    background: url('https://itinventorymanagement.com/uploads/users/riz.png');
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
.txt2:hover {
    text-decoration: underline; 
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
</head>
<body>

    <div class="container">
    <div class="text-center">
                <img src="https://itinventorymanagement.com/uploads/users/rizel.png" alt="IT Department Logo" style="width: 120px; height: auto; margin-bottom: 20px;">
             </div>
             <br>
        <h2>Enter Your Phone Number</h2>

        <?php if ($error): ?>
    <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <?php if ($success): ?>
    <div class="success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>


        <form method="POST">
            <div class="wrap-input100 validate-input">
                 <input id="phone" class="input100"  type="til" name="phone" pattern="[0-9]*" placeholder="Enter your phone number" maxlength="11" required>
                 <span class="focus-input100"></span>
                 <span class="symbol-input100">
                 <i class="fa fa-phone" aria-hidden="true"></i>
                 </span>
            </div>
            <div class="container-login100-form-btn">
                 <button class="login100-form-btn" name="submit" type="submit">Send OTP</button>
            </div>
            <div class="text-center p-t-12">
                <a class="txt2" href="../Security_Detected.php?access=allowed">
                    Back to Login
                </a>
            </div>
        </form>
    </div>
    <script>
    document.getElementById('phone').addEventListener('input', function (e) {
        this.value = this.value.replace(/[^0-9]/g, ''); 
    });
</script>
</body>
</html>
