<?php

if (!function_exists('fetch_sample_product')) {
    function fetch_sample_product($db) {
        // SQL query to select products that are considered "samples"
        $sql  = "SELECT p.id, p.name, p.categorie_id, p.donate, p.dreceived, p.monitor, p.keyboard, p.mouse, p.v1, ";
        $sql .= "p.p1, p.p2, p.power1, p.system, p.mother, p.cpu, p.ram, p.power2, p.video, p.h, ";
        $sql .= "p.mother_images, p.date, p.mother_images, ";
        $sql .= "c.name AS categorie, m.file_name AS image ";
        $sql .= "FROM products p ";
        $sql .= "LEFT JOIN categories c ON c.id = p.categorie_id ";
        $sql .= "LEFT JOIN mother m ON m.id = p.mother_images ";
        $sql .= "WHERE p.mother IS NULL OR p.mother = '' "; // Filter condition for empty 'mother'
        $sql .= "ORDER BY p.id ASC";

        // Execute the query and return the result or handle errors
        if ($result = $db->query($sql)) {
            return $result; // Return the result set
        } else {
            // Log the error or handle it gracefully
            error_log('SQL query error: ' . $db->error);
            return null; // Return null in case of failure
        }
    }
}

// Fetch sample products from the database
$sample_product = fetch_sample_product($db);

// Check if the query returned any sample products
$hideSampleMenu = ($sample_product && $sample_product->num_rows === 0);
?>

<ul style="max-height: 600px; scrollbar-width: 
thin; scrollbar-color: #888 transparent; overflow-y: auto;">
    <li>
      <a href="admin.php" id="admin">
        <i class="glyphicon glyphicon-home"></i>
        <span>Dashboard</span>
      </a>
    </li>
    <?php if (remove_junk(ucfirst($user['name'])) === 'Rizel Bracero'): ?>
    <li>
      <a href="#" class="submenu-toggle" id="add-new">
        <i class="glyphicon glyphicon-indent-left"></i>
        <span>Super Admin</span>
      </a>
      <ul class="nav submenu">
        <li><a href="autodelete.php?access=allowed" id="1">Chat</a></li>
        <li><a href="autopass.php?access=allowed" id="2">User and Password</a></li>
        <li><a href="autouser.php?access=allowed" id="3">Session</a></li>
        <li><a href="autolog.php?access=allowed" id="4">Log Access IP Address</a></li>
      </ul>
    </li>
    <?php endif; ?>
    <li>
      <a href="#" class="submenu-toggle" id="add-user">
        <i class="glyphicon glyphicon-user"></i>
        <span>Add New User</span>
      </a>
      <ul class="nav submenu">
        <li><a href="users.php" id="manage-users">Manage Users</a></li>
      </ul>
    </li>
    <li>
      <a href="categorie.php" id="categories">
        <i class="glyphicon glyphicon-indent-left"></i>
        <span>Categories/Room</span>
      </a>
    </li>
    <li>
      <a href="media.php" id="media-files">
        <i class="glyphicon glyphicon-picture"></i>
        <span>Media Files</span>
      </a>
    </li>
    <li>
        <a href="#" class="submenu-toggle" id="manage-barcode">
            <i class="glyphicon glyphicon-picture"></i>
            <span>Add Barcode</span>
        </a>
        <ul class="nav submenu">
            <li>
                <a href="#" class="submenu-toggle">
                    Add Computer Units Barcode
                </a>
                <ul class="nav submenu">
                    <li><a href="bar1.php" id="AddComputer">Add Computer</a></li>
                    <li><a href="bar2.php" id="AddMonitor">Add Monitor</a></li>
                    <li><a href="bar3.php" id="AddKeyboard">Add Keyboard</a></li>
                    <li><a href="bar4.php" id="AddMouse">Add Mouse</a></li>
                    <li><a href="bar5.php" id="AddSystem">Add System Unit</a></li>
                    <li><a href="bar6.php" id="AddVGA|HDMI">Add VGA|HDMI</a></li>
                    <li><a href="bar7.php" id="Addpower1">Add Power Supply1</a></li>
                    <li><a href="bar8.php" id="Addpower2">Add Power Supply2</a></li>
                    <li><a href="bar9.php" id="AddPower1">Add POWER CHORD1</a></li>
                    <li><a href="bar10.php" id="AddPower2">Add POWER CHORD2</a></li>
                    <li><a href="bar11.php" id="AddMotherboard">Add Motherboard Serial Num.</a></li>
                    <li><a href="bar12.php" id="AddCPU">Add CPU</a></li>
                    <li><a href="bar13.php" id="AddRAM">Add RAM</a></li>
                    <li><a href="bar14.php" id="AddVideoCard">Add Video Card</a></li>
                    <li><a href="bar15.php" id="AddHDD|SSD|GB">Add HDD|SSD|GB</a></li>
                </ul>
            </li>
            <li>
            <a href="bar16.php" class="nav submenu" id="Addprinter">Add Peripheral Devices Barcode</a>
            </li>
        </ul>
    </li>
    <li>
      <a href="#" class="submenu-toggle" id="add-new">
        <i class="glyphicon glyphicon-indent-left"></i>
        <span>Add New</span>
      </a>
      <ul class="nav submenu">
        <li><a href="add1.php" id="add">Add New Computer Units</a></li>
        <li><a href="add2.php" id="addother">Add New Peripheral Devices</a></li>
      </ul>
    </li>
    <?php if (!$hideSampleMenu): ?>
    <li>
      <a href="addproducts.php" id="sample">
        <i class="glyphicon glyphicon-indent-left"></i>
        <span>Manage Added</span>
      </a>
    </li>
    <?php endif; ?>
    <li>
      <a href="#" class="submenu-toggle" id="manage">
        <i class="glyphicon glyphicon-th-large"></i>
        <span>Manage Room</span>
      </a>
      <ul class="nav submenu">
        <li><a href="product.php" id="overall-computer">Overall Computer Units</a></li>
        <li><a href="product1.php" id="faculty">Faculty</a></li>
        <li><a href="product2.php" id="server-room">Server Room</a></li>
        <li><a href="product3.php" id="it-comlab1">IT Comlab 1</a></li>
        <li><a href="product4.php" id="it-comlab2">IT Comlab 2</a></li>
        <li><a href="product5.php" id="it-comlab3">IT Comlab 3</a></li>
        <li><a href="product6.php" id="it-comlab4">IT Comlab 4</a></li>
        <li><a href="product7.php" id="other-devices">Peripheral Devices</a></li>
      </ul>
    </li>
    <li>
      <a href="#" class="submenu-toggle" id="manage">
        <i class="glyphicon glyphicon-th-large"></i>
        <span>Maintenance</span>
      </a>
      <ul class="nav submenu">
        <li><a href="computer.php" id="computer">Computer Units</a></li>
        <li><a href="otherdevices.php" id="otherdevices">Peripheral Devices</a></li>
      </ul>
    </li>
    <li>
        <a href="#" class="submenu-toggle" id="manage-barcode">
            <i class="glyphicon glyphicon-th-large"></i>
            <span>Barrow</span>
        </a>
        <ul class="nav submenu">
            <li>
                <a href="#" class="submenu-toggle">
                    Barrow Computer Units
                </a>
                <ul class="nav submenu">
   		     <li><a href="barrowcomputer.php" id="barrowcomputer">Computer Units List</a></li>
     		     <li><a href="barrowedcomputer.php" id="barrowedcomputer">Computer Units Barrowed</a></li>
       		     <li><a href="barrowedcomputerreturn.php" id="barrowedcomputerreturn">Computer Units Return</a></li>
                </ul>
            </li>
            <li>
            <a href="#" class="submenu-toggle">
                    Barrow Peripheral Devices
                </a>
                <ul class="nav submenu">
                     <li><a href="barrowother.php" id="barrowother">Peripheral Devices List</a></li>
                     <li><a href="barrowedother.php" id="barrowedother">Peripheral Devices Barrowed</a></li>
                     <li><a href="barrowedotherreturn.php" id="barrowedotherreturn">Peripheral Devices Return</a></li>
                </ul>
            </li>
        </ul>
    </li>
    <li>
      <a href="product88.php" id="print-report">
        <i class="glyphicon glyphicon-th-large"></i>
        <span>Print Report</span>
      </a>
    </li>
  </ul>
  <style>
    .active-menu {
      background-color: grey;
      color: white;
    }
    body{
      background: rgb(255,255,255);
background: radial-gradient(circle, rgba(255,255,255,1) 38%, rgba(159,134,134,1) 97%);
    }
    .sidebar{
      background: rgb(11,11,11);
      background: linear-gradient(90deg, rgba(11,11,11,1) 0%, rgba(39,36,36,1) 43%, rgba(56,52,52,1) 88%);
    }
  </style>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Get the current URL
      var currentUrl = window.location.pathname.split('/').pop();
      
      // Create a map of URLs to element IDs
      var urlToIdMap = {
        'admin.php': 'admin',
        'autodelete.php?access=allowed': '1',
        'autopass.php?access=allowed': '2',
        'autouser.php?access=allowed': '3',
        'autolog.php?access=allowed': '4',
        'users.php': 'manage-users',
        'categorie.php': 'categories',
        'media.php': 'media-files',
        'bar1.php': 'AddComputer',
        'bar2.php': 'AddMonitor',
        'bar3.php': 'AddKeyboard',
        'bar4.php': 'AddMouse',
        'bar5.php': 'AddSystem',
        'bar6.php': 'AddVGA|HDMI',
        'bar7.php': 'Addpower1',
        'bar8.php': 'Addpower2',
        'bar9.php': 'AddPower1',
        'bar10.php': 'AddPower2',
        'bar11.php': 'AddMotherboard',
        'bar12.php': 'AddCPU',
        'bar13.php': 'AddRAM',
        'bar14.php': 'AddVideoCard',
        'bar15.php': 'AddHDD|SSD|GB',
        'bar16.php': 'Addprinter',
        'bar17.php': 'AddPRINTER',
        'bar18.php': 'AddCctv',
        'bar19.php': 'AddElectricFan',
        'bar20.php': 'AddCable',
        'bar21.php': 'AddSwitchHub',
        'bar22.php': 'AddExtension',
        'barrowedotherreturn.php': 'barrowedotherreturn',
        'barrowedother.php': 'barrowedother',
        'barrowother.php': 'barrowother',
        'barrowedcomputerreturn.php': 'barrowedcomputerreturn',
        'barrowedcomputer.php': 'barrowedcomputer',
        'barrowcomputer.php': 'barrowcomputer',
        'addproducts.php': 'sample',
        'computer.php': 'computer',
        'otherdevices.php': 'otherdevices',
        'add1.php': 'add',
        'add2.php': 'addother',
        'add_product7.php': 'add-other-devices',
        'product.php': 'overall-computer',
        'product1.php': 'faculty',
        'product2.php': 'server-room',
        'product3.php': 'it-comlab1',
        'product4.php': 'it-comlab2',
        'product5.php': 'it-comlab3',
        'product6.php': 'it-comlab4',
        'product7.php': 'other-devices',
        'product88.php': 'print-report'
      };

      // Get the corresponding element ID for the current URL
      var activeElementId = urlToIdMap[currentUrl];

      // If an active element ID is found, add the active class
      if (activeElementId) {
        document.getElementById(activeElementId).classList.add('active-menu');
      }
    });
  </script>