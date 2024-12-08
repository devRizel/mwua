
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
<?php include 'theme/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Barcode Scanner</title>
    <script>
        var barcode = '';
        var interval;
        
        document.addEventListener('keydown', function(evt) {
            if (interval) {
                clearInterval(interval);
            }
            if (evt.code == 'Enter') {
                if (barcode) {
                    handleBarcode(barcode);
                    barcode = '';
                }
                return;
            }
            if (evt.key != 'Shift') {
                barcode += evt.key;
                interval = setInterval(() => barcode = '', 20);
            }
        });

        function handleBarcode(scannedBarcode) {
            document.querySelector('#last-barcode').innerHTML = scannedBarcode;
        }
    </script>
    <style>
           #last-barcode {
    text-align: center;
    width: 100px; 
    margin: 0 auto; 
}
    </style>
</head>
<body>
    <h1>Simple Barcode Scanner</h1>
    <strong>Last scanned barcode:</strong>
    <center>
        <form method="post" action="" id="serialForm">
             <input readonly id="last-barcode" type="text" maxlength="5" class="form-control" name="scan" placeholder="Barcode" value="<?php echo isset($serial) ? $serial : ''; ?>" required>
        </form>
    </center>
    <script src="css/log.js"></script>
    <?php include_once('layouts/recapt.php'); ?>
</body>
</html>

