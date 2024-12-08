<?php
$url = implode(explode('/jsv', strtolower($_SERVER['REQUEST_URI'])));
$active = "w3-blue";
?>

<div class="w3-bar w3-top w3-black w3-large dont-print" style="z-index:4">
  <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i> Menu</button>
  <span class="w3-bar-item w3-right" style="font-family: sans-serif;"><?php echo NAME_X; ?></span>
</div>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left dont-print" style="z-index:3;width:300px;" id="mySidebar"><br>
  <div class="w3-container w3-row">
    <div class="w3-col s4">
      <img src="img/pig.png" class="w3-circle w3-margin-right" style="width:46px">
    </div>
    <div class="w3-col s8 w3-bar">
      <span>Welcome, <strong><?php echo ucwords($_SESSION['name']); ?></strong></span><br>
    </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Menu</h5>
  </div>
  <div class="w3-bar-block">
    <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i> Close Menu</a>
    <a href="dashboard.php" class="w3-bar-item w3-button w3-padding <?= $url == '/dashboard.php' ? $active : '' ?>"><i class="fa fa-home fa-fw" style="color: #c6322d !important;"></i> Dashboard</a>
    <a href="manage-pig.php" class="w3-bar-item w3-button w3-padding <?= $url == '/manage-pig.php' || $url == '/add-pig.php' || str_contains($url ,'/edit-pig.php') || str_contains($url ,'/quarantine.php') || str_contains($url ,'/sold.php') ? $active : '' ?>"><i class="fa fa-eye fa-fw" style="color: #c6322d !important;"></i> Manage Pigs</a>
    <a href="manage-breed.php" class="w3-bar-item w3-button w3-padding <?= str_contains($url, '/manage-breed.php') ? $active : '' ?>"><i class="fa fa-reorder fa-fw" style="color: #c6322d !important;"></i> Manage Breeds</a>
    <a href="manage-classification.php" class="w3-bar-item w3-button w3-padding <?= $url == '/manage-classification.php' ? $active : '' ?>"><i class="fa fa-sort fa-fw" style="color: #c6322d !important;"></i> Manage Classification</a>
    <a href="manage-feed.php" class="w3-bar-item w3-button w3-padding <?= str_contains($url, '/manage-feed.php') ? $active : '' ?>"><i class="fa fa-stack-overflow fa-fw" style="color: #c6322d !important;"></i> Manage Feeds</a>
    <a href="manage-vitamins.php" class="w3-bar-item w3-button w3-padding <?= str_contains($url, '/manage-vitamins.php') ? $active : '' ?>"><i class="fa fa-medkit fa-fw" style="color: #c6322d !important;"></i> Manage Vitamins</a>
    <a href="manage-quarantine.php" class="w3-bar-item w3-button w3-padding <?= $url == '/manage-quarantine.php' ? $active : '' ?>"><i class="fa fa-lock fa-fw" style="color: #c6322d !important;"></i> Quarantine</a>
    <a href="manage-sold.php" class="w3-bar-item w3-button w3-padding <?= $url == '/manage-sold.php' || str_contains($url ,'/receipt.php') ? $active : '' ?>"><i class="fa fa-diamond fa-fw" style="color: #c6322d !important;"></i> Sold</a>
    <a href="manage-sales.php" class="w3-bar-item w3-button w3-padding <?= $url == '/manage-sales.php' ? $active : '' ?>"><i class="fa fa-bar-chart fa-fw" style="color: #c6322d !important;"></i> Sales</a>
    <a href="logout.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-power-off fa-fw" style="color: #c6322d !important;"></i> Log out</a><br><br>
  </div>
</nav>


<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>