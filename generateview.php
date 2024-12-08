
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

// Filter categories to include only "Computer"
$filtered_cat = array_filter($all_categories, function($cat) {
    return $cat['name'] == 'Computer';
});


$product = find_by_id('products', (int)$_GET['id']);
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

// Get IDs of images already saved in the database for this product
$saved_images = [
    'computer_images' => $product['computer_images'],
    'monitor_images' => $product['monitor_images'],
    'keyboard_images' => $product['keyboard_images'],
    'mouse_images' => $product['mouse_images'],
    'system_images' => $product['system_images'],
    'vgahdmi_images' => $product['vgahdmi_images'],
    'power1_images' => $product['power1_images'],
    'power2_images' => $product['power2_images'],
    'chord1_images' => $product['chord1_images'],
    'chord2_images' => $product['chord2_images'],
    'mother_images' => $product['mother_images'],
    'cpu_images' => $product['cpu_images'],
    'ram_images' => $product['ram_images'],
    'video_images' => $product['video_images'],
    'hddssdgb_images' => $product['hddssdgb_images'],
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
        <a class="navbar-brand js-scroll-trigger" href="generate.php?access=allowed" style="color: white;">INVENTORY MANAGEMENT SYSTEM</a>
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
        <label for="computer_images">Computer Units Barcode</label>
        <div class="img-container d-flex justify-content-center align-items-center" style="height: 200px;">
            <?php
            if (isset($saved_images['computer_images'])) {
                $saved_image_id = $saved_images['computer_images'];
                foreach ($all_computer as $photo) {
                    if ($photo['id'] == $saved_image_id) {
                        echo '<img class="card-img-top" 
                              src="uploads/products/' . $photo['file_name'] . '" 
                              alt="' . $photo['file_name'] . '" 
                              onclick="selectImage(\'' . $photo['id'] . '\', \'computer_images\')">';
                    }
                }
            }
            if (empty($saved_images['computer_images']) || $saved_images['computer_images'] === '0') {
                echo '<img class="img-thumbnail" src="uploads/products/no_image.png" alt="No Image Available">';
            }
            ?>
        </div>
        <input type="hidden" id="computer_images" name="computer_images" value="<?php echo (int)$saved_images['computer_images']; ?>">
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
                        <?php foreach ($filtered_cat as $cat): ?>
                            <option value="<?php echo (int)$cat['id']; ?>" <?php if ($product['categorie_id'] == $cat['id']) echo "selected"; ?>>
                                <?php echo htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                <center><label for="Device-Photo">Device Photo</label></center>
                    <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="Device-Photo" disabled>
                        <option value="">No image</option>
                        <?php foreach ($all_photo as $photo): ?>
                            <option value="<?php echo (int)$photo['id']; ?>" <?php if ($product['media_id'] == $photo['id']) echo "selected"; ?>>
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

        <div class="form-group">
            <div class="row">
                <div class="col-md-3">
                <center><label for="Device-Photo">Monitor</label></center>
                    <input style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" type="text" class="form-control" name="monitor" value="<?php echo remove_junk($product['monitor']); ?>" readonly>
                </div>
                <div class="col-md-3">
                <center><label for="Device-Photo">Keyboard</label></center>
                    <input style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" type="text" class="form-control" name="Keyboard" value="<?php echo remove_junk($product['Keyboard']); ?>" readonly>
                </div>
                <div class="col-md-3">
                <center><label for="Device-Photo">Date Received</label></center>
                    <input style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4); pointer-events: none;" type="text" class="form-control datepicker" name="dreceived" required readonly value="<?php echo remove_junk($product['dreceived']); ?>">
                </div>
                <div class="col-md-3">
                <center><label for="Device-Photo">Mouse</label></center>
                    <input style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" type="text" class="form-control" name="mouse" value="<?php echo remove_junk($product['mouse']); ?>" readonly>
                </div>
            </div>
        </div>

        <div class="form-group">
               <div class="row">
               <div class="col-md-3">
               <center> <label for="Device-Photo">VGA|HDMI</label></center>
                     <input style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" type="text" class="form-control" name="v1" value="<?php echo remove_junk($product['v1']);?>" readonly>
                  </div>
                 <div class="col-md-3">
                 <center> <label for="Device-Photo">Power Chord 1</label></center>
                     <input style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" type="text" class="form-control" name="p1" value="<?php echo remove_junk($product['p1']);?>" readonly>
                 </div>
                 <div class="col-md-3">
                 <center> <label for="Device-Photo">Power Chord 2</label></center>
                     <input style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" type="text" class="form-control" name="p2" value="<?php echo remove_junk($product['p2']);?>" readonly>
                  </div>
                  <div class="col-md-3">
                  <center><label for="Device-Photo">Power Supply|AVR</label></center>
                     <input style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" type="text" class="form-control" name="power1" value="<?php echo remove_junk($product['power1']);?>" readonly>
                 </div>
               </div>
          </div>

          <div class="form-group">
               <div class="row">
               <div class="col-md-3">
               <center> <label for="Device-Photo">System Unit Model</label></center>
                     <input style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" type="text" class="form-control" name="system" value="<?php echo remove_junk($product['system']);?>" readonly>
                  </div>
                 <div class="col-md-3">
                 <center> <label for="Device-Photo">Motherboard Model</label></center>
                     <input style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" type="text" class="form-control" name="mother" value="<?php echo remove_junk($product['mother']);?>" readonly>
                 </div>
                 <div class="col-md-3">
                 <center><label for="Device-Photo">CPU|Processesor</label></center>
                     <input style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" type="text" class="form-control" name="cpu" value="<?php echo remove_junk($product['cpu']);?>" readonly>
                  </div>
                  <div class="col-md-3">
                  <center> <label for="Device-Photo">RAM Quannty|Model</label></center>
                     <input style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" type="text" class="form-control" name="ram" value="<?php echo remove_junk($product['ram']);?>" readonly>
                 </div>
               </div>
          </div>

          <div class="form-group">
               <div class="row">
               <div class="col-md-3 ">
               <center> <label for="Device-Photo">Power Supply 2</label></center>
                     <input style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" type="text" class="form-control" name="power2" value="<?php echo remove_junk($product['power2']);?>" readonly>
                  </div>
                 <div class="col-md-3">
                 <center> <label for="Device-Photo">Video Card|GPU</label></center>
                     <input style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" type="text" class="form-control" name="video" value="<?php echo remove_junk($product['video']);?>" readonly>
                 </div>
                 <div class="col-md-3">
                 <center>   <label for="Device-Photo">HDD|SSD|GB</label></center>
                     <input style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" type="text" class="form-control" name="h" value="<?php echo remove_junk($product['h']);?>" readonly>
                  </div>
                  <div class="col-md-3">
                  <center>  <label for="Device-Photo">Received By</label></center>
                     <input style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" type="text" class="form-control" name="recievedby" value="<?php echo remove_junk($product['recievedby']);?>" readonly>
                  </div>
               </div>
          </div>

          <br><br><br>

        <div class="form-group">
               <div class="row">
               <div class="col-md-3">
               <center>  <label for="monitor_images" class="d-block">Monitor Barcode</label></center>
                    <div class="img-container">
                        <?php
                        if (isset($saved_images['monitor_images'])) {
                            $saved_image_id = $saved_images['monitor_images'];
                            foreach ($all_monitor as $photo) {
                                if ($photo['id'] == $saved_image_id) {
                                    echo '<img class="img-thumbnail selected" 
                                          src="uploads/products/' . $photo['file_name'] . '" 
                                          alt="' . $photo['file_name'] . '" 
                                          onclick="selectImage(\'' . $photo['id'] . '\', \'monitor_images\')">';
                                }
                            }
                        }
                        if (empty($saved_images['monitor_images']) || $saved_images['monitor_images'] === '0') {
                            echo '<img class="img-thumbnail" src="uploads/products/no_image.png" alt="No Image Available">';
                        }
                        ?>
                    </div>
                    <input type="hidden" id="monitor_images" name="monitor_images" value="<?php echo (int)$saved_images['monitor_images']; ?>">
                </div>
                <div class="col-md-3">
                <center><label for="keyboard_images" class="d-block">Keyboard Barcode</label></center>
    <div class="img-container">
        <?php
        if (isset($saved_images['keyboard_images'])) {
            $saved_image_id = $saved_images['keyboard_images'];
            foreach ($all_keyboard as $photo) {
                if ($photo['id'] == $saved_image_id) {
                    echo '<img class="img-thumbnail selected" 
                          src="uploads/products/' . $photo['file_name'] . '" 
                          alt="' . $photo['file_name'] . '" 
                          onclick="selectImage(\'' . $photo['id'] . '\', \'keyboard_images\')">';
                }
            }
        }
        if (empty($saved_images['keyboard_images']) || $saved_images['keyboard_images'] === '0') {
            echo '<img class="img-thumbnail" src="uploads/products/no_image.png" alt="No Image Available">';
        }
        ?>
    </div>
    <input type="hidden" id="keyboard_images" name="keyboard_images" value="<?php echo (int)$saved_images['keyboard_images']; ?>">
</div>

<div class="col-md-3">
<center><label for="mouse_images" class="d-block">Mouse Barcode</label></center>
    <div class="img-container">
        <?php
        if (isset($saved_images['mouse_images'])) {
            $saved_image_id = $saved_images['mouse_images'];
            foreach ($all_mouse as $photo) {
                if ($photo['id'] == $saved_image_id) {
                    echo '<img class="img-thumbnail selected" 
                          src="uploads/products/' . $photo['file_name'] . '" 
                          alt="' . $photo['file_name'] . '" 
                          onclick="selectImage(\'' . $photo['id'] . '\', \'mouse_images\')">';
                }
            }
        }
        if (empty($saved_images['mouse_images']) || $saved_images['mouse_images'] === '0') {
            echo '<img class="img-thumbnail" src="uploads/products/no_image.png" alt="No Image Available">';
        }
        ?>
    </div>
    <input type="hidden" id="mouse_images" name="mouse_images" value="<?php echo (int)$saved_images['mouse_images']; ?>">
</div>

<div class="col-md-3">
<center> <label for="system_images" class="d-block">System Unit Barcode</label></center>
    <div class="img-container">
        <?php
        if (isset($saved_images['system_images'])) {
            $saved_image_id = $saved_images['system_images'];
            foreach ($all_system as $photo) {
                if ($photo['id'] == $saved_image_id) {
                    echo '<img class="img-thumbnail selected" 
                          src="uploads/products/' . $photo['file_name'] . '" 
                          alt="' . $photo['file_name'] . '" 
                          onclick="selectImage(\'' . $photo['id'] . '\', \'system_images\')">';
                }
            }
        }
        if (empty($saved_images['system_images']) || $saved_images['system_images'] === '0') {
            echo '<img class="img-thumbnail" src="uploads/products/no_image.png" alt="No Image Available">';
        }
        ?>
    </div>
    <input type="hidden" id="system_images" name="system_images" value="<?php echo (int)$saved_images['system_images']; ?>">
</div>
               </div>
          </div>

          <div class="form-group">
               <div class="row">
               <div class="col-md-3">
               <center> <label for="vgahdmi_images" class="d-block">VGA|HDMI Barcode</label></center>
    <div class="img-container">
        <?php
        if (isset($saved_images['vgahdmi_images'])) {
            $saved_image_id = $saved_images['vgahdmi_images'];
            foreach ($all_vgahdmi as $photo) {
                if ($photo['id'] == $saved_image_id) {
                    echo '<img class="img-thumbnail selected" 
                          src="uploads/products/' . $photo['file_name'] . '" 
                          alt="' . $photo['file_name'] . '" 
                          onclick="selectImage(\'' . $photo['id'] . '\', \'vgahdmi_images\')">';
                }
            }
        }
        if (empty($saved_images['vgahdmi_images']) || $saved_images['vgahdmi_images'] === '0') {
            echo '<img class="img-thumbnail" src="uploads/products/no_image.png" alt="No Image Available">';
        }
        ?>
    </div>
    <input type="hidden" id="vgahdmi_images" name="vgahdmi_images" value="<?php echo (int)$saved_images['vgahdmi_images']; ?>">
</div>

<div class="col-md-3">
<center> <label for="power1_images" class="d-block">Power Supply1 Barcode</label></center>
    <div class="img-container">
        <?php
        if (isset($saved_images['power1_images'])) {
            $saved_image_id = $saved_images['power1_images'];
            foreach ($all_power1 as $photo) {
                if ($photo['id'] == $saved_image_id) {
                    echo '<img class="img-thumbnail selected" 
                          src="uploads/products/' . $photo['file_name'] . '" 
                          alt="' . $photo['file_name'] . '" 
                          onclick="selectImage(\'' . $photo['id'] . '\', \'power1_images\')">';
                }
            }
        }
        if (empty($saved_images['power1_images']) || $saved_images['power1_images'] === '0') {
            echo '<img class="img-thumbnail" src="uploads/products/no_image.png" alt="No Image Available">';
        }
        ?>
    </div>
    <input type="hidden" id="power1_images" name="power1_images" value="<?php echo (int)$saved_images['power1_images']; ?>">
</div>

<div class="col-md-3">
<center><label for="power2_images" class="d-block">Power Supply2 Barcode</label></center>
    <div class="img-container">
        <?php
        if (isset($saved_images['power2_images'])) {
            $saved_image_id = $saved_images['power2_images'];
            foreach ($all_power2 as $photo) {
                if ($photo['id'] == $saved_image_id) {
                    echo '<img class="img-thumbnail selected" 
                          src="uploads/products/' . $photo['file_name'] . '" 
                          alt="' . $photo['file_name'] . '" 
                          onclick="selectImage(\'' . $photo['id'] . '\', \'power2_images\')">';
                }
            }
        }
        if (empty($saved_images['power2_images']) || $saved_images['power2_images'] === '0') {
            echo '<img class="img-thumbnail" src="uploads/products/no_image.png" alt="No Image Available">';
        }
        ?>
    </div>
    <input type="hidden" id="power2_images" name="power2_images" value="<?php echo (int)$saved_images['power2_images']; ?>">
</div>

<div class="col-md-3">
<center><label for="chord1_images" class="d-block">Power Chord1 Barcode</label></center>
    <div class="img-container">
        <?php
        if (isset($saved_images['chord1_images'])) {
            $saved_image_id = $saved_images['chord1_images'];
            foreach ($all_chord1 as $photo) {
                if ($photo['id'] == $saved_image_id) {
                    echo '<img class="img-thumbnail selected" 
                          src="uploads/products/' . $photo['file_name'] . '" 
                          alt="' . $photo['file_name'] . '" 
                          onclick="selectImage(\'' . $photo['id'] . '\', \'chord1_images\')">';
                }
            }
        }
        if (empty($saved_images['chord1_images']) || $saved_images['chord1_images'] === '0') {
            echo '<img class="img-thumbnail" src="uploads/products/no_image.png" alt="No Image Available">';
        }
        ?>
    </div>
    <input type="hidden" id="chord1_images" name="chord1_images" value="<?php echo (int)$saved_images['chord1_images']; ?>">
</div>
               </div>
          </div>

          <div class="form-group">
               <div class="row">
               <div class="col-md-3">
               <center><label for="chord2_images" class="d-block">Power Chord2 Barcode</label></center>
    <div class="img-container">
        <?php
        if (isset($saved_images['chord2_images'])) {
            $saved_image_id = $saved_images['chord2_images'];
            foreach ($all_chord2 as $photo) {
                if ($photo['id'] == $saved_image_id) {
                    echo '<img class="img-thumbnail selected" 
                          src="uploads/products/' . $photo['file_name'] . '" 
                          alt="' . $photo['file_name'] . '" 
                          onclick="selectImage(\'' . $photo['id'] . '\', \'chord2_images\')">';
                }
            }
        }
        if (empty($saved_images['chord2_images']) || $saved_images['chord2_images'] === '0') {
            echo '<img class="img-thumbnail" src="uploads/products/no_image.png" alt="No Image Available">';
        }
        ?>
    </div>
    <input type="hidden" id="chord2_images" name="chord2_images" value="<?php echo (int)$saved_images['chord2_images']; ?>">
</div>

<div class="col-md-3">
<center><label for="mother_images" class="d-block">Motherboard Barcode</label></center>
    <div class="img-container">
        <?php
        if (isset($saved_images['mother_images'])) {
            $saved_image_id = $saved_images['mother_images'];
            foreach ($all_mother as $photo) {
                if ($photo['id'] == $saved_image_id) {
                    echo '<img class="img-thumbnail selected" 
                          src="uploads/products/' . $photo['file_name'] . '" 
                          alt="' . $photo['file_name'] . '" 
                          onclick="selectImage(\'' . $photo['id'] . '\', \'mother_images\')">';
                }
            }
        }
        if (empty($saved_images['mother_images']) || $saved_images['mother_images'] === '0') {
            echo '<img class="img-thumbnail" src="uploads/products/no_image.png" alt="No Image Available">';
        }
        ?>
    </div>
    <input type="hidden" id="mother_images" name="mother_images" value="<?php echo (int)$saved_images['mother_images']; ?>">
</div>

<div class="col-md-3">
<center><label for="cpu_images" class="d-block">CPU|Processor Barcode</label></center>
    <div class="img-container">
        <?php
        if (isset($saved_images['cpu_images'])) {
            $saved_image_id = $saved_images['cpu_images'];
            foreach ($all_cpu as $photo) {
                if ($photo['id'] == $saved_image_id) {
                    echo '<img class="img-thumbnail selected" 
                          src="uploads/products/' . $photo['file_name'] . '" 
                          alt="' . $photo['file_name'] . '" 
                          onclick="selectImage(\'' . $photo['id'] . '\', \'cpu_images\')">';
                }
            }
        }
        if (empty($saved_images['cpu_images']) || $saved_images['cpu_images'] === '0') {
            echo '<img class="img-thumbnail" src="uploads/products/no_image.png" alt="No Image Available">';
        }
        ?>
    </div>
    <input type="hidden" id="cpu_images" name="cpu_images" value="<?php echo (int)$saved_images['cpu_images']; ?>">
</div>

<div class="col-md-3">
<center> <label for="ram_images" class="d-block">RAM Quantity|Model Barcode</label></center>
    <div class="img-container">
        <?php
        if (isset($saved_images['ram_images'])) {
            $saved_image_id = $saved_images['ram_images'];
            foreach ($all_ram as $photo) {
                if ($photo['id'] == $saved_image_id) {
                    echo '<img class="img-thumbnail selected" 
                          src="uploads/products/' . $photo['file_name'] . '" 
                          alt="' . $photo['file_name'] . '" 
                          onclick="selectImage(\'' . $photo['id'] . '\', \'ram_images\')">';
                }
            }
        }
        if (empty($saved_images['ram_images']) || $saved_images['ram_images'] === '0') {
            echo '<img class="img-thumbnail" src="uploads/products/no_image.png" alt="No Image Available">';
        }
        ?>
    </div>
    <input type="hidden" id="ram_images" name="ram_images" value="<?php echo (int)$saved_images['ram_images']; ?>">
</div>
               </div>
          </div>

          <div class="form-group">
          <div class="row custom-gutter justify-content-center">
          <div class="col-md-3 col-6 mb-3 text-center">
          <center><label for="video_images" class="d-block">Video Card|GPU Barcode</label></center>
    <div class="img-container">
        <?php
        if (isset($saved_images['video_images'])) {
            $saved_image_id = $saved_images['video_images'];
            foreach ($all_video as $photo) {
                if ($photo['id'] == $saved_image_id) {
                    echo '<img class="img-thumbnail selected" 
                          src="uploads/products/' . $photo['file_name'] . '" 
                          alt="' . $photo['file_name'] . '" 
                          onclick="selectImage(\'' . $photo['id'] . '\', \'video_images\')">';
                }
            }
        }
        if (empty($saved_images['video_images']) || $saved_images['video_images'] === '0') {
            echo '<img class="img-thumbnail" src="uploads/products/no_image.png" alt="No Image Available">';
        }
        ?>
    </div>
    <input type="hidden" id="video_images" name="video_images" value="<?php echo (int)$saved_images['video_images']; ?>">
</div>

<div class="col-md-3">
<center><label for="hddssdgb_images" class="d-block">HDD|SSD|GB Barcode</label></center>
    <div class="img-container">
        <?php
        if (isset($saved_images['hddssdgb_images'])) {
            $saved_image_id = $saved_images['hddssdgb_images'];
            foreach ($all_hddssdgb as $photo) {
                if ($photo['id'] == $saved_image_id) {
                    echo '<img class="img-thumbnail selected" 
                          src="uploads/products/' . $photo['file_name'] . '" 
                          alt="' . $photo['file_name'] . '" 
                          onclick="selectImage(\'' . $photo['id'] . '\', \'hddssdgb_images\')">';
                }
            }
        }
        if (empty($saved_images['hddssdgb_images']) || $saved_images['hddssdgb_images'] === '0') {
            echo '<img class="img-thumbnail" src="uploads/products/no_image.png" alt="No Image Available">';
        }
        ?>
    </div>
    <input type="hidden" id="hddssdgb_images" name="hddssdgb_images" value="<?php echo (int)$saved_images['hddssdgb_images']; ?>">
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
