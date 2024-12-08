
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
require_once('includes/load.php');

?>
<?php
date_default_timezone_set('Asia/Manila');
ob_start();
require_once('includes/load.php');
if($session->isUserLoggedIn(true)) { redirect('home.php', false); }
?>
<!DOCTYPE html>
<html lang="en">
<link rel="icon" type="image/x-icon" href="uploads/users/rizel.png">
<title>Inventory Management System</title>

<?php
include('header.php');
include('ads/db_connect.php');
?>

<style>
    body {
    background: url('uploads/users/riz.png');
    background-size: cover; 
    background-position: center; 
}
    header.masthead {
        background: url(assets/img/ss.png);
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
    }
    .iska {
        background: url(assets/image/fontsize.jpg);
        background-repeat: no-repeat;
        background-size: cover;
        margin-right: 5px;
        padding: 25px 25px;
        border-radius: 50% 50%;
        float: left;
        display: flex;
    }
    .contact-link {
        color: black !important; /* Use !important to override any other styles */
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


<section class="page-section" id="menu">
    <div id="menu-field" class="card-deck">
        <?php
        // Fetch products and their images
        $qry = $conn->query("
        SELECT p.id, p.name, m.file_name AS other_images
        FROM other p
        LEFT JOIN other_images m ON p.other_images = m.id
        WHERE p.other_images NOT LIKE '%Maintenance%'
        ORDER BY RAND()
    ");
    
        
        while($row = $qry->fetch_assoc()):
        ?>
        <div class="col-lg-3" style="padding-left: 20px;">
            <div class="card menu-item" style="border-color: gray; border-bottom-right-radius: 15px; border-bottom-left-radius: 15px; margin-bottom: 25px; margin-right: 5px;">
                <?php if ($row['other_images']): ?>
                    <img src="uploads/products/<?php echo $row['other_images']; ?>" class="card-img-top" width="100" height="300" alt="Mother Image">
                <?php else: ?>
                    <img src="uploads/products/default.jpg" class="card-img-top" width="100" height="300" alt="Default Image">
                <?php endif; ?>
                <div class="card-body">
                    <center><h5 class="card-title"><?php echo $row['name']; ?></h5></center>
                    <div class="text-center">
                        <form action="generateview2" method="get" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo (int)$row['id']; ?>">
                            <input type="hidden" name="access" value="allowed">
                            <button type="submit" class="btn btn-sm btn-outline-secondary view_prod btn-block" data-toggle="tooltip">
                                <span class="glyphicon"></span> View
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
        
    </div>
</section>

<script type="text/javascript" src="css/title.js"></script>
<script src="css/log.js"></script>
<?php include_once('layouts/recapt.php'); ?>

</body>
<?php $conn->close(); ?>
</html>
