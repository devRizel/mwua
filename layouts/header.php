
<?php
session_start();
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1); 
ini_set('session.use_strict_mode', 1); 


// In your header or a central initialization file
if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
     header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
     exit();
 }

function isValidUrl($url) {
     return preg_match('/^https?:\/\/(www\.)?itinventorymanagement\.com/', $url);
 }
 
 // Example usage of the function
 $link = "https://itinventorymanagement.com";
 if (isValidUrl($link)) {
     
 } else {
     echo "Invalid URL.";
 }

if (basename($_SERVER['PHP_SELF']) == '../layouts/header.php') {
     header("HTTP/1.1 403 Forbidden");
     exit("Access denied.");
 }

 // Add CSP header
 header("Content-Security-Policy: default-src 'self'; script-src 'self' https://itinventorymanagement.com;");
 header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
 header("X-Content-Type-Options: nosniff");
 header("X-Frame-Options: DENY");
 header("X-XSS-Protection: 1; mode=block");
 header("Referrer-Policy: no-referrer");
 header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
 header('Pragma: no-cache');
 header('Expires: 0');
 header('Content-Type: text/html; charset=utf-8');
 header("X-Frame-Options: SAMEORIGIN");
 header("Referrer-Policy: strict-origin-when-cross-origin");
 header("Permissions-Policy: geolocation=()");
 

foreach ($_GET as $key => $value) {
    $_GET[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
foreach ($_POST as $key => $value) {
    $_POST[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
foreach ($_COOKIE as $key => $value) {
    $_COOKIE[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

?>
<?php
// Set PHP timezone to Asia/Manila
date_default_timezone_set('Asia/Manila');

// Assuming $user and $session are defined elsewhere in your code
$user = current_user();

    // Database configuration
    $servername = "127.0.0.1";
    $username = "u510162695_inventory";
    $password = "1Inventory_system";
    $dbname = "u510162695_inventory";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to select data from the table, ordered by most recent first
$sql = "SELECT id, name, email, message, created_at FROM chat ORDER BY created_at DESC";
$result = $conn->query($sql);

// SQL query to count messages where 'name' is not empty or NULL
$count_sql = "SELECT COUNT(*) AS total FROM chat WHERE name IS NOT NULL AND name != ''";
$count_result = $conn->query($count_sql);
$count_row = $count_result->fetch_assoc();
$message_count = $count_row['total'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php if (!empty($page_title))
           echo remove_junk($page_title);
            elseif(!empty($user))
           echo ucfirst($user['name']);
            else echo "Inventory Management System";?>
    </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
    <link rel="stylesheet" href="libs/css/main.css" />
    <style>
    .dropdown-content {
        display: none;
        padding: 8px;
        border: 1px solid #ddd;
        margin-top: 8px;
        background-color: #f9f9f9;
    }
    .name {
        cursor: pointer;
        color: black;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-left: 15px;
        padding-right: 15px;
    }
    .name:hover {
        color: gray;
    }
    .timestamp {
        color: #888;
        font-size: 0.85em;
    }
    .modal-body {
        max-height: 400px;
        overflow-y: auto;
    }
    .dropdown-content {
        display: none;
        padding: 8px;
        padding-left: 20px;
        padding-right: 20px;
        border: 1px solid #ddd;
        margin-top: 8px;
        background-color: #f9f9f9;
        border-color: var(--accent-color);
    }
    .modal-content {
        border-radius: 10% 10% 10% 10% / 10% 10% 0% 10%;
    }
    .notification-container {
        position: relative;
        display: inline-block;
    }
    .notification-container img {
        width: 50px;
        height: auto;
        margin-bottom: 0;
    }
    .badge {
        position: absolute;
        top: 0px;
        left: -10px;
        background-color: red;
        color: white;
        border-radius: 50%;
        padding: 2px 6px;
        font-size: 12px;
        transform: translate(50%, 50%); /* Adjusts position slightly */
    }
    .delete-btn-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.delete-btn {
    margin-left: auto;
}
.rizel{
    background: rgb(11,11,11);
    background: linear-gradient(90deg, rgba(11,11,11,1) 0%, rgba(39,36,36,1) 43%, rgba(56,52,52,1) 88%);
  }   
    </style>
    <script>
    function toggleDropdown(id) {
        var content = document.getElementById("content-" + id);
        if (content.style.display === "none" || content.style.display === "") {
            content.style.display = "block";
        } else {
            content.style.display = "none";
        }
    }
    </script>
</head>
<body>
<?php if ($session->isUserLoggedIn(true)): ?>
    <header id="header">
    <div class="logo pull-left rizel">
        <img src="uploads/users/rizel.png" alt="IT Department Logo" style="width: 50px; height: auto; margin-bottom: 0px;">
        IT Department
    </div>
        <div class="header-content">
            <div class="header-date pull-left">
                <strong><?php echo date("F j, Y, g:i a");?></strong>
            </div>
            <div class="pull-right clearfix" >
                <ul class="info-menu list-inline list-unstyled">
                    <li class="notification-container">
                    
                        <img src="uploads/users/icon.png" alt="IT Department Logo"
                             style="width: 50px; height: auto; margin-bottom: 0px;" data-toggle="modal" data-target="#myModal">
                        <?php if ($message_count > 0): ?>
                            <span class="badge"><?php echo $message_count; ?></span>
                        <?php endif; ?>
                 
                    </li>
                    <li class="profile">
                        <a href="#" data-toggle="dropdown" class="toggle" aria-expanded="false">
                            <img src="uploads/users/<?php echo $user['image'];?>" alt="user-image" class="img-circle img-inline">
                            <span><?php echo remove_junk(ucfirst($user['name'])); ?> <i class="caret"></i></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="profile.php?id=<?php echo (int)$user['id'];?>">
                                    <i class="glyphicon glyphicon-user"></i>
                                    Profile
                                </a>
                            </li>
                            <li>
                                <a href="edit_account.php" title="edit account">
                                    <i class="glyphicon glyphicon-cog"></i>
                                    Settings
                                </a>
                            </li>
                            <li class="last">
                              <a href="logout.php" class="logout-btn">
                                <i class="glyphicon glyphicon-off"></i>
                                    Logout
                              </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <div class="sidebar">
        <?php if($user['user_level'] === '1'): ?>
            <!-- admin menu -->
            <?php include_once('admin_menu.php');?>

        <?php elseif($user['user_level'] === '2'): ?>
            <!-- Special user -->
            <?php include_once('special_menu.php');?>

        <?php elseif($user['user_level'] === '3'): ?>
            <!-- User menu -->
            <?php include_once('user_menu.php');?>

        <?php endif;?>
    </div>
<?php endif;?>

<div class="page">
  <div class="container-fluid">
  <!-- <div class="page"> -->
    <div class="container-fluid">
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <center><h4 class="modal-title"><strong>System Message</strong></h4></center>
                    </div>
                    <div class="modal-body">
    <?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if (empty($row["name"])) {
            // Skip entries where the 'name' is empty
            continue;
        }
            
            $created_at = date("F j, Y", strtotime($row["created_at"]));
            echo "<div>";
            echo "<p class='name' onclick='toggleDropdown(" . $row["id"] . ")'>";
            echo "<span>" . strtoupper($row["name"]) . "</span>";
            echo "<span class='timestamp'>" . $created_at . "</span>";
            echo "</p>";
            echo "<div id='content-" . $row["id"] . "' class='dropdown-content'>";
            echo "<div class='delete-btn-container'>";
            echo "<p><strong>Email:</strong> " . $row["email"] . "</p>";
            // SweetAlert delete button
            echo "<a href='#' class='btn btn-danger btn-xs delete-btn' title='Delete' onclick='confirmDelete(" . $row["id"] . ")'>";
            echo "<span class='glyphicon glyphicon-trash'></span> Delete</a>";
            echo "</div>"; // Close the delete-btn-container div
            echo "<p><strong>Message:</strong> " . $row["message"] . "</p>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<p>No results found.</p>";
    }
    ?>
</div>

                </div>

            </div>
        </div>
    </div>
  </div>
  <script>
function confirmDelete(id) {
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this message!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            // If confirmed, redirect to the delete_message.php page
            window.location.href = "delete_message.php?id=" + id;
        }
    });
}
</script>
<script src="css/sweetalert.js"></script>
<script>
document.querySelectorAll('.logout-btn').forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault(); 
        const href = this.getAttribute('href');
        swal({
            title: "Opps!",
            text: "Are you sure you want to logout?",
            icon: "warning",
            buttons: ["Cancel", "Logout"],
            dangerMode: true,
        })
        .then((willLogout) => {
            if (willLogout) {
                window.location.href = href;
            }
        });
    });
});

</script>