
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
$product = find_by_id('other', (int)$_GET['id']);
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
$all_other_images = find_all('other_images');
// Get IDs of images already saved in the database for this product
$saved_images = [
    'other_images' => $product['other_images'],
    // Add other image fields as needed
];

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
    .contact-link {
        color: black !important;
    }
    .img-container {
    width: 100%;
    height: 150px; /* Adjust the height as needed */
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #ddd; /* Optional border */
    overflow: hidden;
    background-color: #f9f9f9; /* Optional background color */
}

.img-container img {
    max-width: 100%;
    max-height: 100%;
    object-fit: cover; /* Ensures the image covers the container without distortion */
}

</style>
<body id="page-top">
<nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav" style="background-color: var(--accent-color);">
    <div class="container">
        <a class="iska"></a>
        <a class="navbar-brand js-scroll-trigger" href="generate2.php?access=allowed" style="color: white;">INVENTORY MANAGEMENT SYSTEM</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto my-2 my-lg-0">
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="Security_Detected.php?access=allowed" style="font-size: 20px; color: white;">Login Now</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<br><br><br><br>
<div class="panel-body">
<form method="post" action="product1view?id=<?php echo (int)$product['id'] ?>">
    <div class="container">
    <div class="row custom-gutter justify-content-center">
    <div class="col-md-3 col-6 mb-3 text-center">
        <label for="other_images">Peripheral Devices Barcode</label>
        <div class="img-container d-flex justify-content-center align-items-center" style="height: 200px;">
            <?php
            if (isset($saved_images['other_images'])) {
                $saved_image_id = $saved_images['other_images'];
                foreach ($all_other_images as $photo) {
                    if ($photo['id'] == $saved_image_id) {
                        echo '<img class="card-img-top" 
                              src="uploads/products/' . $photo['file_name'] . '" 
                              alt="' . $photo['file_name'] . '" 
                              onclick="selectImage(\'' . $photo['id'] . '\', \'other_images\')">';
                    }
                }
            }
            if (empty($saved_images['other_images']) || $saved_images['other_images'] === '0') {
                echo '<img class="img-thumbnail" src="uploads/products/no_image.png" alt="No Image Available">';
            }
            ?>
        </div>
        <input type="hidden" id="other_images" name="other_images" value="<?php echo (int)$saved_images['other_images']; ?>">
    </div>
</div>
<br><br><br>

        <div class="form-group">
            <div class="row">
                <div class="form-group col-md-3">
                    <center><label for="Room-Title">Room Title</label></center>
                    <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="Room-Title" disabled>
              <option value="">Select a Room</option>
              <?php foreach ($all_room as $room): ?>
                <option value="<?php echo htmlspecialchars(remove_junk($room['name'])); ?>" <?php if (remove_junk($room['name']) === remove_junk($product['name'])) echo 'selected="selected"'; ?>>
                  <?php echo htmlspecialchars(remove_junk($room['name'])); ?>
                </option>
              <?php endforeach; ?>
            </select>
                </div>
                <div class="col-md-3">
                <center><label for="Device-Category">Device Category</label></center>
                <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="Device-Category" disabled>
                  <option value="">Select a Category</option>
                  <?php foreach ($all_categories as $cat): ?>
                    <?php if ($cat['name'] != 'Computer'): ?>
                    <option value="<?php echo (int)$cat['id']; ?>" <?php 
                      if($product['categorie_id'] == $cat['id']) echo "selected"; ?>>
                      <?php echo remove_junk($cat['name']); ?>
                    </option>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </select>
                </div>
                <div class="col-md-3">
                <center><label for="Device-Photo">Device Photo</label></center>
                <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="Device-Photo" disabled>
                  <option value="">No image</option>
                  <?php foreach ($all_photo as $photo): ?>
                    <option value="<?php echo (int)$photo['id']; ?>" <?php if($product['media_id'] == $photo['id']) echo "selected"; ?>>
                      <?php echo $photo['file_name']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
                </div>
                <div class="col-md-3">
                <center> <label for="Device-Photo">Donated By</label></center>
                    <input style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" type="text" class="form-control" name="donate" value="<?php echo remove_junk($product['donate']); ?>" readonly>
                </div>
            </div>
        </div>

        <div class="form-group ">
            <div class="row ">
                <div class="col-md-4">
                <center><label for="Device-Photo">Date Received</label></center>
                <input style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4); pointer-events: none;" type="text" class="form-control datepicker" name="dreceived" required readonly value="<?php echo remove_junk($product['dreceived']);?>">
                </div>
                <div class="col-md-4">
                <center><label for="Device-Photo">Serial Num.</label></center>
                <input style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" type="text" class="form-control" name="serial" readonly value="<?php echo remove_junk($product['serial']);?>">
                </div>
                <div class="col-md-4">
                <center><label for="Device-Photo">Recieved By</label></center>
                <input style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" type="text" class="form-control" name="recievedby" readonly value="<?php echo remove_junk($product['recievedby']);?>">
                </div>
            </div>
        </div>
    </div>
</form>

</div>
<script type="text/javascript" src="css/title.js"></script>
<script src="css/log.js"></script>
<?php include_once('layouts/recapt.php'); ?>
</body>
<?php $conn->close(); ?>
</html>
