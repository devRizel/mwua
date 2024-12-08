<link rel="icon" type="image/x-icon" href="uploads/users/rizel.png">
<?php
$page_title = 'All Product';
require_once('includes/load.php');

// Checking what level user has permission to view this page
page_require_level(2);

function fetch_products() {
    global $db; // Use global variable inside the function
  
    
    // Modify SQL query to include a WHERE clause that filters out products with media_id = 0 or NULL
    $sql  = "SELECT p.id, p.name, p.categorie_id, p.recievedby, p.donate, p.dreceived, p.monitor, p.keyboard, p.mouse, p.v1, ";
    $sql .= "p.p1, p.p2, p.power1, p.system, p.mother, p.cpu, p.ram, p.power2, p.video, p.h, ";
    $sql .= "p.media_id, p.date, ";
    $sql .= "c.name AS categorie, ";
    $sql .= "m.file_name AS image, ";
    $sql .= "p.computer_images, p.monitor_images, p.mouse_images, p.system_images, p.vgahdmi_images, ";
    $sql .= "p.power1_images, p.power2_images, p.chord1_images, p.chord2_images, p.mother_images, ";
    $sql .= "p.cpu_images, p.ram_images, p.video_images, p.hddssdgb_images ";
    $sql .= "FROM products p ";
    $sql .= "LEFT JOIN categories c ON c.id = p.categorie_id ";
    $sql .= "LEFT JOIN media m ON m.id = p.media_id ";
    $sql .= "WHERE p.media_id IS NOT NULL AND p.media_id != '0' ";
    $sql .= "ORDER BY p.id ASC";
    
    $result = $db->query($sql);
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : array(); // Fetch as associative array
  }
  
  
  // Fetch products from the database
  $products = fetch_products();

$other = join_other_table();

// Define the desired order of names
$desired_order = array(
    "Server Room",
    "Com lab 2",
    "Com lab 1",
    "Com lab 4",
    "Faculty",
    "Com lab 3"
);

// Function to determine position in desired order array
function custom_sort_by_name($item) {
    global $desired_order;
    $name = $item['name'];
    $position = array_search($name, $desired_order);
    return ($position === false) ? count($desired_order) : $position;
}

// Sort products based on custom sort function
usort($products, function($a, $b) {
    return custom_sort_by_name($a) - custom_sort_by_name($b);
});

// Sort other items based on custom sort function
usort($other, function($a, $b) {
    return custom_sort_by_name($a) - custom_sort_by_name($b);
});


function fetch_return_computers() {
    global $db; // Use global variable inside the function

    // Modify SQL query to include a WHERE clause that filters out products with media_id = 0 or NULL
    $sql  = "SELECT p.id, p.name, p.categorie_id, p.barrow, p.recievedby, p.donate, p.dreceived, p.monitor, p.keyboard, p.mouse, p.v1, ";
    $sql .= "p.p1, p.p2, p.power1, p.system, p.mother, p.cpu, p.ram, p.power2, p.video, p.h, ";
    $sql .= "p.media_id, p.date, ";
    $sql .= "c.name AS categorie, ";
    $sql .= "m.file_name AS image, ";
    $sql .= "p.computer_images, p.monitor_images, p.mouse_images, p.system_images, p.vgahdmi_images, ";
    $sql .= "p.power1_images, p.power2_images, p.chord1_images, p.chord2_images, p.mother_images, ";
    $sql .= "p.cpu_images, p.ram_images, p.video_images, p.hddssdgb_images ";
    $sql .= "FROM products p ";
    $sql .= "LEFT JOIN categories c ON c.id = p.categorie_id ";
    $sql .= "LEFT JOIN media m ON m.id = p.media_id ";
    $sql .= "WHERE p.media_id IS NOT NULL AND p.media_id != '0' ";
    $sql .= "AND p.barrow IS NOT NULL AND p.barrow != '' "; // Filter to include only rows with data in "barrow"
    $sql .= "AND p.barrow LIKE '%Return%' "; // Filter to include only rows where "barrow" contains the word "Return"
    $sql .= "AND (p.computer_images NOT LIKE '%Maintenance%' AND p.monitor_images NOT LIKE '%Maintenance%' AND ";
    $sql .= "p.mouse_images NOT LIKE '%Maintenance%' AND p.system_images NOT LIKE '%Maintenance%' AND ";
    $sql .= "p.vgahdmi_images NOT LIKE '%Maintenance%' AND p.power1_images NOT LIKE '%Maintenance%' AND ";
    $sql .= "p.power2_images NOT LIKE '%Maintenance%' AND p.chord1_images NOT LIKE '%Maintenance%' AND ";
    $sql .= "p.chord2_images NOT LIKE '%Maintenance%' AND p.mother_images NOT LIKE '%Maintenance%' AND ";
    $sql .= "p.cpu_images NOT LIKE '%Maintenance%' AND p.ram_images NOT LIKE '%Maintenance%' AND ";
    $sql .= "p.video_images NOT LIKE '%Maintenance%' AND p.hddssdgb_images NOT LIKE '%Maintenance%' AND ";
    $sql .= "p.keyboard_images NOT LIKE '%Maintenance%') "; 
    $sql .= "ORDER BY p.id ASC";
    

    $result = $db->query($sql);
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : array(); // Fetch as associative array
}

// Fetch return computers from the database
$return_computers = fetch_return_computers();

// Sort products based on custom sort function
usort($return_computers, function($a, $b) {
    return custom_sort_by_name($a) - custom_sort_by_name($b);
});



function fetch_return_other_devices() {
    global $db;
  
    $sql = "SELECT 
              p.id, 
              p.name, 
              p.categorie_id, 
              p.donate, 
              p.dreceived, 
              p.media_id, 
              p.date,
              p.serial, 
              p.barrow,
              c.name AS categorie, 
              m.file_name AS image,
              p.other_images
            FROM 
              other p 
            LEFT JOIN 
              categories c ON c.id = p.categorie_id 
            LEFT JOIN 
              media m ON m.id = p.media_id 
            WHERE 
              p.other_images NOT LIKE '%Maintenance%' 
            AND 
              p.barrow LIKE '%Return%' 
            ORDER BY 
              p.id ASC";
  
    return find_by_sql($sql);
  }
  // Fetch the products and assign them to $return_other_devices
  $return_other_devices = fetch_return_other_devices();

  usort($return_other_devices, function($a, $b) {
    return custom_sort_by_name($a) - custom_sort_by_name($b);
});

function fetch_computer_maintenance() {
    global $db; // Use global variable inside the function

    $sql  = "SELECT p.id, p.name, p.categorie_id, p.recievedby, p.donate, p.dreceived, p.monitor, p.keyboard, p.mouse, p.v1, ";
    $sql .= "p.p1, p.p2, p.power1, p.system, p.mother, p.cpu, p.ram, p.power2, p.video, p.h, ";
    $sql .= "p.media_id, p.date, ";
    $sql .= "c.name AS categorie, m.file_name AS image, ";
    $sql .= "p.computer_images, p.monitor_images, p.keyboard_images, p.mouse_images, p.system_images, ";
    $sql .= "p.vgahdmi_images, p.power1_images, p.power2_images, p.chord1_images, p.chord2_images, ";
    $sql .= "p.mother_images, p.cpu_images, p.ram_images, p.video_images, p.hddssdgb_images ";
    $sql .= "FROM products p ";
    $sql .= "LEFT JOIN categories c ON c.id = p.categorie_id ";
    $sql .= "LEFT JOIN media m ON m.id = p.media_id ";
    $sql .= "WHERE p.computer_images LIKE '%Maintenance%' OR ";
    $sql .= "p.monitor_images LIKE '%Maintenance%' OR ";
    $sql .= "p.keyboard_images LIKE '%Maintenance%' OR ";
    $sql .= "p.mouse_images LIKE '%Maintenance%' OR ";
    $sql .= "p.system_images LIKE '%Maintenance%' OR ";
    $sql .= "p.vgahdmi_images LIKE '%Maintenance%' OR ";
    $sql .= "p.power1_images LIKE '%Maintenance%' OR ";
    $sql .= "p.power2_images LIKE '%Maintenance%' OR ";
    $sql .= "p.chord1_images LIKE '%Maintenance%' OR ";
    $sql .= "p.chord2_images LIKE '%Maintenance%' OR ";
    $sql .= "p.mother_images LIKE '%Maintenance%' OR ";
    $sql .= "p.cpu_images LIKE '%Maintenance%' OR ";
    $sql .= "p.ram_images LIKE '%Maintenance%' OR ";
    $sql .= "p.video_images LIKE '%Maintenance%' OR ";
    $sql .= "p.hddssdgb_images LIKE '%Maintenance%'";

    $result = $db->query($sql);
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : array(); // Fetch as associative array
}

// Fetch computer maintenance products from the database
$computer_maintenance_products = fetch_computer_maintenance();

usort($computer_maintenance_products, function($a, $b) {
    return custom_sort_by_name($a) - custom_sort_by_name($b);
});

function fetch_other_devices_maintenance() {
    global $db;
  
    $sql = "SELECT 
              p.id, 
              p.name, 
              p.categorie_id, 
              p.donate, 
              p.dreceived, 
              p.media_id, 
              p.date,
              p.serial, 
              c.name AS categorie, 
              m.file_name AS image,
              p.other_images
            FROM 
              other p 
            LEFT JOIN 
              categories c ON c.id = p.categorie_id 
            LEFT JOIN 
              media m ON m.id = p.media_id 
            WHERE 
              p.other_images LIKE '%Maintenance%' 
            ORDER BY 
              p.id ASC";
  
    return find_by_sql($sql);
  }
  
  // Fetch the other devices for maintenance and assign them to $products
  $other_devices_maintenance = fetch_other_devices_maintenance();

  usort($other_devices_maintenance, function($a, $b) {
    return custom_sort_by_name($a) - custom_sort_by_name($b);
});

include_once('layouts/header.php');
?>

<style>
    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px; /* Adjust as needed */
    }

    .select-wrapper {
        margin-right: 20px;
    }

    .select-wrapper .form-control {
        width: 250px;
        text-align: left;
    }

    .report-section {
        display: none; /* Initially hide all report sections */
    }

    @media print {
        body * {
            visibility: hidden;
        }
        .report-image {
            display: block;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            margin: auto;
            max-width: 100%;
            height: auto;
            z-index: 1;
        }
        .table img {
            display: block;
            margin: 0 auto; /* Center align the images */
            max-width: 100%; /* Ensure images do not exceed their container */
            height: auto; /* Maintain aspect ratio */
        }
        #computer-report-table, #computer-report-table * {
            visibility: visible;
        }
        #computer-report-table {
            position: relative;
            top: 150px; /* Adjust this value as needed */
            width: 100%;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 180px; /* Adjust based on header height */
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .text-center {
            text-align: center;
        }
        @page {
            size: landscape;
            margin: 100%; /* Adjust as necessary */
        }
        .page-header {
            page-break-before: always;
        }
    }
</style>


<div class="header-container">
    <h2></h2>
    <div class="select-wrapper">
        <select class="form-control" name="Option" id="reportSelector"  style=" border-radius: 50% 10% 50% 10% / 10% 50% 10% 50%;">
            <option value="">Select Option Report</option>
            <option value="computer">Computer Units Report</option>
            <option value="other_device">Peripheral Devices Report</option>
            <option value="barrow">Return Computer Units Report</option>
            <option value="others">Return Peripheral Devices Report</option>
            <option value="main">Computer/s to be Repaired Report</option>
            <option value="ot">Peripheral Devices to be Repaired Report</option>
        </select>
    </div>
</div>

<h1 class="text-center">Select an Option Report to View</h1>

<!-- Display messages if needed -->
<div class="col-md-12">
    <?php echo display_msg($msg); ?>
</div>

<!-- Computer Report Section -->
<div class="row computer-report report-section">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <h1 class="text-center">Computer Units Report</h1>
                <div class="select-wrapper">
                    <select class="form-control" name="Room-Title"  style=" border-radius: 50% 10% 50% 10% / 10% 50% 10% 50%;">
                        <option value="Overall Computer">Overall Computer</option>
                        <option value="Faculty">Faculty</option>
                        <option value="Server Room">Server Room</option>
                        <option value="Com lab 1">IT Comlab 1</option>
                        <option value="Com lab 2">IT Comlab 2</option>
                        <option value="Com lab 3">IT Comlab 3</option>
                        <option value="Com lab 4">IT Comlab 4</option>
                    </select>
                </div>
                <div class="btn-group" style="float: right;">
                    <button id="generate-report-btn" class="btn btn-danger" onclick="printTable('computer-report-table')"
                      style=" border-radius: 50% 10% 50% 10% / 10% 50% 10% 50%;">Print</button>
                </div>
            </div>
            <div class="panel-body">
            <center><img src="uploads/users/print.png" class="report-image"></center>
                <div class="table-responsive">
                    <table id="computer-report-table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%;">#</th>
                                <th style="width: 10%;">Photo</th>
                                <th style="width: 10%;">Title Room</th>
                                <th class="text-center" style="width: 10%;">Device Name</th>
                                <th class="text-center" style="width: 10%;">Donated By</th>
                                <th class="text-center" style="width: 10%;">Date Received</th>
                                <th class="text-center" style="width: 10%;">Motherboard|Serial Num</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $counter = 1; // Initialize counter
                            foreach ($products as $product):
                            ?>
                                <tr>
                                    <td class="text-center"><?php echo $counter; ?></td>
                                    <td>
                                        <?php if ($product['media_id'] === '0'): ?>
                                            <img class="img-avatar img-circle" src="uploads/products/no_image.png" alt="">
                                        <?php else: ?>
                                            <img class="img-avatar img-circle" src="uploads/products/<?php echo $product['image']; ?>" alt="">
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo remove_junk($product['name']); ?></td>
                                    <td class="text-center"><?php echo remove_junk($product['categorie']); ?></td>
                                    <td class="text-center"><?php echo remove_junk($product['donate']); ?></td>
                                    <td class="text-center"><?php echo remove_junk($product['dreceived']); ?></td>
                                    <td class="text-center"><?php echo remove_junk($product['mother']); ?></td>
                                </tr>
                                <?php
                                $counter++;
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Other Device Report Section -->
<div class="row other-device-report report-section">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <h1 class="text-center">Peripheral Devices Report</h1>
                <div class="select-wrapper">
                    <select class="form-control" name="Room-Title"  style=" border-radius: 50% 10% 50% 10% / 10% 50% 10% 50%;">
                        <option value="Overall Devices">Overall Devices</option>
                        <option value="Faculty">Faculty</option>
                        <option value="Server Room">Server Room</option>
                        <option value="Com lab 1">IT Comlab 1</option>
                        <option value="Com lab 2">IT Comlab 2</option>
                        <option value="Com lab 3">IT Comlab 3</option>
                        <option value="Com lab 4">IT Comlab 4</option>
                    </select>
                </div>
                <div class="btn-group" style="float: right;">
                    <button class="btn btn-danger" onclick="printTable('other-device-table')"  style=" border-radius: 50% 10% 50% 10% / 10% 50% 10% 50%;">Print</button>
                </div>
            </div>
            <div class="panel-body">
            <center><img src="uploads/users/print.png" class="report-image"></center>
                <div class="table-responsive">
                    <table id="other-device-table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%;">#</th>
                                <th style="width: 10%;">Photo</th>
                                <th style="width: 10%;">Title Room</th>
                                <th class="text-center" style="width: 10%;">Device Name</th>
                                <th class="text-center" style="width: 10%;">Donated By</th>
                                <th class="text-center" style="width: 10%;">Date Received</th>
                                <th class="text-center" style="width: 10%;">Serial Num</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $counter = 1; // Initialize counter
                            foreach ($other as $item):
                            ?>
                                <tr class="other-device-item" data-room="<?php echo htmlspecialchars(remove_junk($item['name'])); ?>">
                                    <td class="text-center"><?php echo $counter; ?></td>
                                    <td>
                                        <?php if ($item['media_id'] === '0'): ?>
                                            <img class="img-avatar img-circle" src="uploads/products/no_image.png" alt="">
                                        <?php else: ?>
                                            <img class="img-avatar img-circle" src="uploads/products/<?php echo $item['image']; ?>" alt="">
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo remove_junk($item['name']); ?></td>
                                    <td class="text-center"><?php echo remove_junk($item['categorie']); ?></td>
                                    <td class="text-center"><?php echo remove_junk($item['donate']); ?></td>
                                    <td class="text-center"><?php echo remove_junk($item['dreceived']); ?></td>
                                    <td class="text-center"><?php echo remove_junk($item['serial']); ?></td>
                                </tr>
                                <?php
                                $counter++;
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Barrow Report Section -->
<div class="row barrow-report report-section">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <h1 class="text-center">Return Computer Units Report</h1>
                <div class="select-wrapper">
                    <select class="form-control" name="Room-Title" style="border-radius: 50% 10% 50% 10% / 10% 50% 10% 50%;">
                        <option value="Overall Devices">Overall Devices</option>
                        <option value="Faculty">Faculty</option>
                        <option value="Server Room">Server Room</option>
                        <option value="Com lab 1">IT Comlab 1</option>
                        <option value="Com lab 2">IT Comlab 2</option>
                        <option value="Com lab 3">IT Comlab 3</option>
                        <option value="Com lab 4">IT Comlab 4</option>
                    </select>
                </div>
                <div class="btn-group" style="float: right;">
                    <button id="generate-report-btn" class="btn btn-danger" onclick="printTable('barrow-report-table')" style="border-radius: 50% 10% 50% 10% / 10% 50% 10% 50%;">Print</button>
                </div>
            </div>
            <div class="panel-body">
                <center><img src="uploads/users/print.png" class="report-image"></center>
                <div class="table-responsive">
                    <table id="barrow-report-table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%;">#</th>
                                <th style="width: 10%;">Photo</th>
                                <th style="width: 10%;">Title Room</th>
                                <th class="text-center" style="width: 10%;">Device Name</th>
                                <th class="text-center" style="width: 10%;">Donated By</th>
                                <th class="text-center" style="width: 10%;">Date Received</th>
                                <th class="text-center" style="width: 10%;">Motherboard|Serial Num</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $counter = 1; // Initialize counter
                            foreach ($return_computers as $product): // Use $return_computers to loop through data
                            ?>
                                <tr>
                                    <td class="text-center"><?php echo $counter; ?></td>
                                    <td>
                                        <?php if ($product['media_id'] === '0'): ?>
                                            <img class="img-avatar img-circle" src="uploads/products/no_image.png" alt="">
                                        <?php else: ?>
                                            <img class="img-avatar img-circle" src="uploads/products/<?php echo $product['image']; ?>" alt="">
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo remove_junk($product['name']); ?></td>
                                    <td class="text-center"><?php echo remove_junk($product['categorie']); ?></td>
                                    <td class="text-center"><?php echo remove_junk($product['donate']); ?></td>
                                    <td class="text-center"><?php echo remove_junk($product['dreceived']); ?></td>
                                    <td class="text-center"><?php echo remove_junk($product['mother']); ?></td>
                                </tr>
                                <?php
                                $counter++;
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- others Device Report Section -->
<div class="row others-report report-section">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <h1 class="text-center">Return Peripheral Devices Report</h1>
                <div class="select-wrapper">
                    <select class="form-control" name="Room-Title" style="border-radius: 50% 10% 50% 10% / 10% 50% 10% 50%;">
                        <option value="Overall Devices">Overall Devices</option>
                        <option value="Faculty">Faculty</option>
                        <option value="Server Room">Server Room</option>
                        <option value="Com lab 1">IT Comlab 1</option>
                        <option value="Com lab 2">IT Comlab 2</option>
                        <option value="Com lab 3">IT Comlab 3</option>
                        <option value="Com lab 4">IT Comlab 4</option>
                    </select>
                </div>
                <div class="btn-group" style="float: right;">
                    <button class="btn btn-danger" onclick="printTable('other-device-table')" style="border-radius: 50% 10% 50% 10% / 10% 50% 10% 50%;">Print</button>
                </div>
            </div>
            <div class="panel-body">
                <center><img src="uploads/users/print.png" class="report-image"></center>
                <div class="table-responsive">
                    <table id="others-device-table" class="table table-bordered">
                        <thead>
                        <tr>
                                <th class="text-center" style="width: 5%;">#</th>
                                <th style="width: 10%;">Photo</th>
                                <th style="width: 10%;">Title Room</th>
                                <th class="text-center" style="width: 10%;">Device Name</th>
                                <th class="text-center" style="width: 10%;">Donated By</th>
                                <th class="text-center" style="width: 10%;">Date Received</th>
                                <th class="text-center" style="width: 10%;">Serial Num</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Fetch the products and assign them to $return_other_devices
                            $return_other_devices = fetch_return_other_devices();
                            $counter = 1; // Initialize counter
                            foreach ($return_other_devices as $item):
                            ?>
                                <tr class="other-device-item" data-room="<?php echo htmlspecialchars(remove_junk($item['name'])); ?>">
                                    <td class="text-center"><?php echo $counter; ?></td>
                                    <td>
                                        <?php if ($item['media_id'] === '0'): ?>
                                            <img class="img-avatar img-circle" src="uploads/products/no_image.png" alt="">
                                        <?php else: ?>
                                            <img class="img-avatar img-circle" src="uploads/products/<?php echo $item['image']; ?>" alt="">
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo remove_junk($item['name']); ?></td>
                                    <td class="text-center"><?php echo remove_junk($item['categorie']); ?></td>
                                    <td class="text-center"><?php echo remove_junk($item['donate']); ?></td>
                                    <td class="text-center"><?php echo remove_junk($item['dreceived']); ?></td>
                                    <td class="text-center"><?php echo remove_junk($item['serial']); ?></td>
                                </tr>
                                <?php
                                $counter++;
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- main Report Section -->
<div class="row main-report report-section">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <h1 class="text-center">Computer/s to be Repaired Report</h1>
                <div class="select-wrapper">
                    <select class="form-control" name="Room-Title" style="border-radius: 50% 10% 50% 10% / 10% 50% 10% 50%;">
                        <option value="Overall Computer">Overall Computer</option>
                        <option value="Faculty">Faculty</option>
                        <option value="Server Room">Server Room</option>
                        <option value="Com lab 1">IT Comlab 1</option>
                        <option value="Com lab 2">IT Comlab 2</option>
                        <option value="Com lab 3">IT Comlab 3</option>
                        <option value="Com lab 4">IT Comlab 4</option>
                    </select>
                </div>
                <div class="btn-group" style="float: right;">
                    <button id="generate-report-btn" class="btn btn-danger" onclick="printTable('main-report-table')" style="border-radius: 50% 10% 50% 10% / 10% 50% 10% 50%;">Print</button>
                </div>
            </div>
            <div class="panel-body">
                <center><img src="uploads/users/print.png" class="report-image"></center>
                <div class="table-responsive">
                    <table id="main-report-table" class="table table-bordered">
                        <thead>
                        <tr>
                                <th class="text-center" style="width: 5%;">#</th>
                                <th style="width: 10%;">Photo</th>
                                <th style="width: 10%;">Title Room</th>
                                <th class="text-center" style="width: 10%;">Device Name</th>
                                <th class="text-center" style="width: 10%;">Donated By</th>
                                <th class="text-center" style="width: 10%;">Date Received</th>
                                <th class="text-center" style="width: 10%;">Motherboard|Serial Num</th>
                            </tr>
                        </thead>
                        <tbody>
    <?php foreach ($computer_maintenance_products as $product): ?>
        <tr>
            <td class="text-center"><?php echo $counter; ?></td>
            <td>
                <?php if ($product['media_id'] === '0'): ?>
                    <img class="img-avatar img-circle" src="uploads/products/no_image.png" alt="">
                <?php else: ?>
                    <img class="img-avatar img-circle" src="uploads/products/<?php echo $product['image']; ?>" alt="">
                <?php endif; ?>
            </td>
            <td><?php echo remove_junk($product['name']); ?></td>
            <td class="text-center"><?php echo remove_junk($product['categorie']); ?></td>
            <td class="text-center"><?php echo remove_junk($product['donate']); ?></td>
            <td class="text-center"><?php echo remove_junk($product['dreceived']); ?></td>
            <td class="text-center"><?php echo remove_junk($product['mother']); ?></td>
        </tr>
        <?php
        $counter++;
    endforeach;
    ?>
</tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- ot Report Section -->
<div class="row ot-report report-section">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <h1 class="text-center">Peripheral Devices to be Repaired Report</h1>
                <div class="select-wrapper">
                    <select class="form-control" name="Room-Title" style="border-radius: 50% 10% 50% 10% / 10% 50% 10% 50%;">
                        <option value="Overall Devices">Overall Devices</option>
                        <option value="Faculty">Faculty</option>
                        <option value="Server Room">Server Room</option>
                        <option value="Com lab 1">IT Comlab 1</option>
                        <option value="Com lab 2">IT Comlab 2</option>
                        <option value="Com lab 3">IT Comlab 3</option>
                        <option value="Com lab 4">IT Comlab 4</option>
                    </select>
                </div>
                <div class="btn-group" style="float: right;">
                    <button class="btn btn-danger" onclick="printTable('ot-device-table')" style="border-radius: 50% 10% 50% 10% / 10% 50% 10% 50%;">Print</button>
                </div>
            </div>
            <div class="panel-body">
                <center><img src="uploads/users/print.png" class="report-image"></center>
                <div class="table-responsive">
                    <table id="ot-device-table" class="table table-bordered">
                        <thead>
                        <tr>
                                <th class="text-center" style="width: 5%;">#</th>
                                <th style="width: 10%;">Photo</th>
                                <th style="width: 10%;">Title Room</th>
                                <th class="text-center" style="width: 10%;">Device Name</th>
                                <th class="text-center" style="width: 10%;">Donated By</th>
                                <th class="text-center" style="width: 10%;">Date Received</th>
                                <th class="text-center" style="width: 10%;">Serial Num</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $counter = 1; // Initialize counter
                            foreach ($other_devices_maintenance as $item): // Changed from $other to $products
                            ?>
                                <tr class="other-device-item" data-room="<?php echo htmlspecialchars(remove_junk($item['name'])); ?>">
                                    <td class="text-center"><?php echo $counter; ?></td>
                                    <td>
                                        <?php if ($item['media_id'] === '0'): ?>
                                            <img class="img-avatar img-circle" src="uploads/products/no_image.png" alt="">
                                        <?php else: ?>
                                            <img class="img-avatar img-circle" src="uploads/products/<?php echo $item['image']; ?>" alt="">
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo remove_junk($item['name']); ?></td>
                                    <td class="text-center"><?php echo remove_junk($item['categorie']); ?></td>
                                    <td class="text-center"><?php echo remove_junk($item['donate']); ?></td>
                                    <td class="text-center"><?php echo remove_junk($item['dreceived']); ?></td>
                                    <td class="text-center"><?php echo remove_junk($item['serial']); ?></td>
                                </tr>
                                <?php
                                $counter++;
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>




<?php include_once('layouts/footer.php'); ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    var selector = document.getElementById('reportSelector');
    var counter = 1; // Initialize counter

    selector.addEventListener('change', function() {
        var selectedOption = this.value;

        if (selectedOption === 'computer') {
            showReport('computer-report');
            resetCounterDisplay('.computer-report'); 
            hideMainHeading(true); 
        } else if (selectedOption === 'other_device') {
            showReport('other-device-report');
            resetCounterDisplay('.other-device-report'); 
            hideMainHeading(true); 
        } else if (selectedOption === 'barrow') {
            showReport('barrow-report');
            resetCounterDisplay('.barrow-report'); 
            hideMainHeading(true);
        } else if (selectedOption === 'others') {
            showReport('others-report');
            resetCounterDisplay('.others-report'); 
            hideMainHeading(true); 
        } else if (selectedOption === 'main') {
            showReport('main-report');
            resetCounterDisplay('.main-report'); 
            hideMainHeading(true); 
        } else if (selectedOption === 'ot') {
            showReport('ot-report');
            resetCounterDisplay('.ot-report'); 
            hideMainHeading(true);
        } else {
            hideAllReports();
            hideMainHeading(false); 
        }
    });

    function showReport(reportType) {
        hideAllReports(); // Hide all reports first
        document.querySelector('.' + reportType).style.display = 'block';
    }

    function hideAllReports() {
        document.querySelectorAll('.report-section').forEach(function(report) {
            report.style.display = 'none';
        });
    }

    function hideMainHeading(hidden) {
        var mainHeading = document.querySelector('h1.text-center');
        if (mainHeading) {
            mainHeading.style.display = hidden ? 'none' : 'block';
        }
    }

    function resetCounterDisplay(reportSelector) {
        var rows = document.querySelectorAll(reportSelector + ' tbody tr');
        counter = 1; // Reset counter to 1
        rows.forEach(function(row, index) {
            var counterCell = row.querySelector('td:first-child');
            counterCell.textContent = counter++;
        });
    }

    // Change event listener for Room Title dropdown in Computer Report section
    var computerRoomSelector = document.querySelector('.computer-report select[name="Room-Title"]');
    if (computerRoomSelector) {
        computerRoomSelector.addEventListener('change', function() {
            var selectedRoom = this.value.trim(); // Get selected room name

            // Show all rows initially
            var rows = document.querySelectorAll('.computer-report tbody tr');
            rows.forEach(function(row) {
                row.style.display = ''; // Reset to default display
            });

            // Filter rows based on selected room
            if (selectedRoom !== 'Overall Computer') {
                var filteredRows = document.querySelectorAll('.computer-report tbody tr');
                counter = 1; // Reset counter to 1 for specific room
                filteredRows.forEach(function(row, index) {
                    var roomTitleCell = row.querySelector('td:nth-child(3)'); // Assuming room title is in the third cell
                    if (roomTitleCell.textContent.trim() !== selectedRoom) {
                        row.style.display = 'none';
                    } else {
                        // Update the displayed counter for filtered rows
                        var counterCell = row.querySelector('td:first-child');
                        counterCell.textContent = counter++;
                    }
                });
            } else {
                // If "Overall Computer" is selected, reset all counters
                resetCounterDisplay('.computer-report');
            }
        });
    }

     // Change event listener for Room Title dropdown in barrow Report section
var computerRoomSelector = document.querySelector('.barrow-report select[name="Room-Title"]');
if (computerRoomSelector) {
    computerRoomSelector.addEventListener('change', function() {
        var selectedRoom = this.value.trim(); // Get selected room name

        // Show all rows initially
        var rows = document.querySelectorAll('.barrow-report tbody tr');
        rows.forEach(function(row) {
            row.style.display = ''; // Reset to default display
        });

        // Filter rows based on selected room
        if (selectedRoom !== 'Overall Devices') {
            var counter = 1; // Reset counter to 1 for specific room
            rows.forEach(function(row) {
                var roomTitleCell = row.querySelector('td:nth-child(3)'); // Assuming room title is in the third cell
                if (roomTitleCell.textContent.trim() !== selectedRoom) {
                    row.style.display = 'none'; // Hide row if it doesn't match
                } else {
                    // Update the displayed counter for filtered rows
                    var counterCell = row.querySelector('td:first-child');
                    counterCell.textContent = counter++; // Increment counter for displayed rows
                }
            });
        } else {
            // If "Overall Devices" is selected, reset all counters
            resetCounterDisplay('.barrow-report');
        }
    });
}

 // Change event listener for Room Title dropdown in Other Device Report section
 var otherDeviceRoomSelector = document.querySelector('.ot-report select[name="Room-Title"]');
    if (otherDeviceRoomSelector) {
        otherDeviceRoomSelector.addEventListener('change', function() {
            var selectedRoom = this.value.trim(); // Get selected room name

            // Show all rows initially
            var rows = document.querySelectorAll('.ot-report tbody tr');
            rows.forEach(function(row) {
                row.style.display = ''; // Reset to default display
            });

            // Filter rows based on selected room
            if (selectedRoom !== 'Overall Devices') {
                var filteredRows = document.querySelectorAll('.ot-report tbody tr');
                counter = 1; // Reset counter to 1 for specific room
                filteredRows.forEach(function(row, index) {
                    var roomTitleCell = row.querySelector('td:nth-child(3)'); // Assuming room title is in the third cell
                    if (roomTitleCell.textContent.trim() !== selectedRoom) {
                        row.style.display = 'none';
                    } else {
                        // Update the displayed counter for filtered rows
                        var counterCell = row.querySelector('td:first-child');
                        counterCell.textContent = counter++;
                    }
                });
            } else {
                // If "Overall Devices" is selected, reset all counters
                resetCounterDisplay('.ot-report');
            }
        });
    }

     // Change event listener for Room Title dropdown in Computer Report section
     var computerRoomSelector = document.querySelector('.main-report select[name="Room-Title"]');
    if (computerRoomSelector) {
        computerRoomSelector.addEventListener('change', function() {
            var selectedRoom = this.value.trim(); // Get selected room name

            // Show all rows initially
            var rows = document.querySelectorAll('.main-report tbody tr');
            rows.forEach(function(row) {
                row.style.display = ''; // Reset to default display
            });

            // Filter rows based on selected room
            if (selectedRoom !== 'Overall Computer') {
                var filteredRows = document.querySelectorAll('.main-report tbody tr');
                counter = 1; // Reset counter to 1 for specific room
                filteredRows.forEach(function(row, index) {
                    var roomTitleCell = row.querySelector('td:nth-child(3)'); // Assuming room title is in the third cell
                    if (roomTitleCell.textContent.trim() !== selectedRoom) {
                        row.style.display = 'none';
                    } else {
                        // Update the displayed counter for filtered rows
                        var counterCell = row.querySelector('td:first-child');
                        counterCell.textContent = counter++;
                    }
                });
            } else {
                // If "Overall Computer" is selected, reset all counters
                resetCounterDisplay('.main-report');
            }
        });
    }

        // Change event listener for Room Title dropdown in Other Device Report section
        var otherDeviceRoomSelector = document.querySelector('.ot-report select[name="Room-Title"]');
    if (otherDeviceRoomSelector) {
        otherDeviceRoomSelector.addEventListener('change', function() {
            var selectedRoom = this.value.trim(); // Get selected room name

            // Show all rows initially
            var rows = document.querySelectorAll('.ot-report tbody tr');
            rows.forEach(function(row) {
                row.style.display = ''; // Reset to default display
            });

            // Filter rows based on selected room
            if (selectedRoom !== 'Overall Devices') {
                var filteredRows = document.querySelectorAll('.ot-report tbody tr');
                counter = 1; // Reset counter to 1 for specific room
                filteredRows.forEach(function(row, index) {
                    var roomTitleCell = row.querySelector('td:nth-child(3)'); // Assuming room title is in the third cell
                    if (roomTitleCell.textContent.trim() !== selectedRoom) {
                        row.style.display = 'none';
                    } else {
                        // Update the displayed counter for filtered rows
                        var counterCell = row.querySelector('td:first-child');
                        counterCell.textContent = counter++;
                    }
                });
            } else {
                // If "Overall Devices" is selected, reset all counters
                resetCounterDisplay('.ot-report');
            }
        });
    }

    // Change event listener for Room Title dropdown in Other Device Report section
    var otherDeviceRoomSelector = document.querySelector('.other-device-report select[name="Room-Title"]');
    if (otherDeviceRoomSelector) {
        otherDeviceRoomSelector.addEventListener('change', function() {
            var selectedRoom = this.value.trim(); // Get selected room name

            // Show all rows initially
            var rows = document.querySelectorAll('.other-device-report tbody tr');
            rows.forEach(function(row) {
                row.style.display = ''; // Reset to default display
            });

            // Filter rows based on selected room
            if (selectedRoom !== 'Overall Devices') {
                var filteredRows = document.querySelectorAll('.other-device-report tbody tr');
                counter = 1; // Reset counter to 1 for specific room
                filteredRows.forEach(function(row, index) {
                    var roomTitleCell = row.querySelector('td:nth-child(3)'); // Assuming room title is in the third cell
                    if (roomTitleCell.textContent.trim() !== selectedRoom) {
                        row.style.display = 'none';
                    } else {
                        // Update the displayed counter for filtered rows
                        var counterCell = row.querySelector('td:first-child');
                        counterCell.textContent = counter++;
                    }
                    
                });
            } else {
                // If "Overall Devices" is selected, reset all counters
                resetCounterDisplay('.other-device-report');
            }
        });
    }
});
function printTable(tableId) {
    var imgTag = document.querySelector('.report-image'); // Get the first image tag
    var imgContents = imgTag ? '<div class="page-header text-center">' + imgTag.outerHTML + '</div>' : '';

    var printContents = imgContents + document.getElementById(tableId).outerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    location.reload();
}
</script>