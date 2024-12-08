
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
// Set timezone and start output buffering
date_default_timezone_set('Asia/Manila');
ob_start();
require_once('includes/load.php');

// Redirect if the user is already logged in
if($session->isUserLoggedIn(true)) { 
    redirect('home.php', false); 
}
$all_categories = find_all('categories');
$all_room = find_all('room');
$all_photo = find_all('media');
$all_computer = find_all('computer');
$all_monitor = find_all('monitor');
$all_keyboard = find_all('keyboard');
$all_mouse = find_all('mouse');
$all_system = find_all('system');
$all_vgahdmi = find_all('vgahdmi');
$all_power1 = find_all('power1');
$all_power2 = find_all('power2');
$all_chord1 = find_all('chord1');
$all_chord2 = find_all('chord2');
$all_mother = find_all('mother');
$all_cpu = find_all('cpu');
$all_ram = find_all('ram');
$all_video = find_all('video');
$all_hddssdgb = find_all('hddssdgb');

// Initialize an empty product array
$product = null;

// Handle the search for serial
if (isset($_POST['scan'])) {
    $serial = trim($_POST['scan']);  // Sanitize input
    if (!empty($serial)) {
        $product = find_by_serial('products', $serial);  // Fetch product by serial
    }
}

// Initialize saved images to handle null products gracefully
$saved_images = [
    'computer_images' => $product['computer_images'] ?? null,
    'monitor_images' => $product['monitor_images'] ?? null,
    'keyboard_images' => $product['keyboard_images'] ?? null,
    'mouse_images' => $product['mouse_images'] ?? null,
    'system_images' => $product['system_images'] ?? null,
    'vgahdmi_images' => $product['vgahdmi_images'] ?? null,
    'power1_images' => $product['power1_images'] ?? null,
    'power2_images' => $product['power2_images'] ?? null,
    'chord1_images' => $product['chord1_images'] ?? null,
    'chord2_images' => $product['chord2_images'] ?? null,
    'mother_images' => $product['mother_images'] ?? null,
    'cpu_images' => $product['cpu_images'] ?? null,
    'ram_images' => $product['ram_images'] ?? null,
    'video_images' => $product['video_images'] ?? null,
    'hddssdgb_images' => $product['hddssdgb_images'] ?? null,
    // Add other image fields as needed
];

// Function to fetch product by serial number
function find_by_serial($table, $serial) {
    global $db;
    $sql = "SELECT * FROM {$db->escape($table)} WHERE mother = '{$db->escape($serial)}' LIMIT 1";
    $result = $db->query($sql);
    if ($result && $db->num_rows($result) > 0) {
        return $db->fetch_assoc($result);
    }
    return null;  // Return null if no product found
}


// Include header
include('header.php');
include('ads/db_connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<link rel="icon" type="image/x-icon" href="uploads/users/rizel.png">
<title>Inventory Management System</title>

<style>
    body {
        background: url('uploads/users/riz.png');
        background-size: cover; 
        background-position: center; 
    }
    .iska {
        background: url(assets/image/fontsize.jpg);
        background-repeat: no-repeat;
        background-size: cover;
        margin-right: 5px;
        padding: 25px 25px;
        border-radius: 50%;
        float: left;
        display: flex;
    }
    .img-container {
        width: 100%;
        height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #ddd;
        overflow: hidden;
        background-color: #f9f9f9;
    }
    .img-container img {
        max-width: 100%;
        max-height: 100%;
        object-fit: cover;
    }
    #last-barcode {
    text-align: center;
    width: 100px; 
    margin: 0 auto; 
}

</style>

<body id="page-top">

<nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav" style="background-color: var(--accent-color);">
    <div class="container">
        <a class="iska"></a>
        <a class="navbar-brand js-scroll-trigger" href="index.php" >INVENTORY MANAGEMENT SYSTEM</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto my-2 my-lg-0">
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="Security_Detected.php?access=allowed" style="font-size: 20px; ">Login Now</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<br><br><br><br>
<center>
    <form method="post" action="" id="serialForm">
        <input id="last-barcode" type="text" maxlength="5" class="form-control" name="scan" placeholder="Barcode" value="<?php echo isset($serial) ? $serial : ''; ?>" required>
    </form>
</center>
<script type="text/javascript" src="css/title.js"></script>
<script src="css/log.js"></script>
<script src="css/bar11.js"></script>

<?php include_once('layouts/recapt.php'); ?>
</body>
<?php $conn->close(); ?>
</html>
