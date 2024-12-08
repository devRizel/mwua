
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

// Handle the search for serial
if (isset($_POST['scan'])) {
    $serial = $_POST['scan'];
    $product = find_by_serial('other', $serial);  // A function to find product by serial
} else {
    $product = null;  // No product found initially
}

$all_other_images = find_all('other_images');

// Function to fetch product by serial number
function find_by_serial($table, $serial) {
    global $db;
    $sql = "SELECT * FROM {$db->escape($table)} WHERE serial = '{$db->escape($serial)}' LIMIT 1";
    $result = $db->query($sql);
    if ($result && $db->num_rows($result) > 0) {
        return $db->fetch_assoc($result);
    }
    return null;
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
        <a class="navbar-brand js-scroll-trigger" href="index.php" style="color: white;">INVENTORY MANAGEMENT SYSTEM</a>
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
<center>
    <form method="post" action="" id="serialForm">
        <input id="last-barcode" type="text" maxlength="5" class="form-control" name="scan" placeholder="Barcode" value="<?php echo isset($serial) ? $serial : ''; ?>" required>
    </form>
</center>
<div class="panel-body">
    <?php if ($product): ?>
    <form method="post" action="product1view?id=<?php echo (int)$product['id'] ?>">
        <div class="container">
            <div class="row custom-gutter justify-content-center">
                <div class="col-md-3 col-6 mb-3 text-center">
                    <label for="other_images">Peripheral Devices Barcode</label>
                    <div class="img-container d-flex justify-content-center align-items-center" style="height: 200px;">
                        <?php
                        $saved_image_id = $product['other_images'];
                        foreach ($all_other_images as $photo) {
                            if ($photo['id'] == $saved_image_id) {
                                echo '<img class="card-img-top" 
                                      src="uploads/products/' . $photo['file_name'] . '" 
                                      alt="' . $photo['file_name'] . '" 
                                      onclick="selectImage(\'' . $photo['id'] . '\', \'other_images\')">';
                            }
                        }
                        if (empty($product['other_images']) || $product['other_images'] === '0') {
                            echo '<img class="img-thumbnail" src="uploads/products/no_image.png" alt="No Image Available">';
                        }
                        ?>
                    </div>
                    <input type="hidden" id="other_images" name="other_images" value="<?php echo (int)$product['other_images']; ?>">
                </div>
            </div>
            <br><br><br><br>
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
                        <center><label for="Donated By">Donated By</label></center>
                        <input type="text" class="form-control" name="donate" value="<?php echo htmlspecialchars($product['donate']); ?>" readonly>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4">
                        <center><label for="Date-Received">Date Received</label></center>
                        <input type="text" class="form-control" name="dreceived" value="<?php echo htmlspecialchars($product['dreceived']); ?>" readonly>
                    </div>
                    <div class="col-md-4">
                        <center><label for="Serial Num">Serial Num.</label></center>
                        <input type="text" class="form-control" name="serial" value="<?php echo htmlspecialchars($product['serial']); ?>" readonly>
                    </div>
                    <div class="col-md-4">
                        <center><label for="Recieved By">Received By</label></center>
                        <input type="text" class="form-control" name="recievedby" value="<?php echo htmlspecialchars($product['recievedby']); ?>" readonly>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php elseif(isset($_POST['scan'])): ?>
    <center><p id="noProductMessage">No found with that Barcode Number.</p></center>
    <?php endif; ?>
</div>
<script>
    var barcode = '';
    var interval;

    // Input event listener for the "last-barcode" input field
    document.getElementById('last-barcode').addEventListener('input', function() {
        // Automatically submit the form when 5 characters are entered
        if (this.value.length === 5) {
            document.getElementById('serialForm').submit();
        }

        // If the input is cleared, reload the page to reset it
        if (this.value === '') {
            window.location.href = 'generatescannbarcode4.php?access=allowed';  // Adjust this to your original page if necessary
        }

        // Hide the "No product found" message when the input is cleared
        var noProductMessage = document.getElementById('noProductMessage');
        if (this.value === '' && noProductMessage) {
            noProductMessage.style.display = 'none';
        } else if (this.value !== '' && noProductMessage) {
            noProductMessage.style.display = 'block';
        }
    });

    // Keydown event listener to capture barcode scanning
    document.addEventListener('keydown', function(evt) {
        if (interval) {
            clearInterval(interval);
        }

        // Check for Enter key to process the barcode
        if (evt.code == 'Enter') {
            if (barcode) {
                handleBarcode(barcode);
                barcode = ''; // Clear barcode after processing
            }
            return;
        }

        // Capture other keys except Shift for barcode
        if (evt.key != 'Shift') {
            barcode += evt.key;
            interval = setInterval(() => barcode = '', 20);
        }
    });

    // Function to handle the barcode and display it in the input field
    function handleBarcode(scannedBarcode) {
        // Set the scanned barcode into the input field with id "last-barcode"
        document.getElementById('last-barcode').value = scannedBarcode;
    }
</script>

<script type="text/javascript" src="css/title.js"></script>
<script src="css/log.js"></script>
<?php include_once('layouts/recapt.php'); ?>
</body>
<?php $conn->close(); ?>
</html>
