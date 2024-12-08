<link rel="icon" type="image/x-icon" href="uploads/users/rizel.png">
<?php include 'theme/header.php'; ?>
<?php
date_default_timezone_set('Asia/Manila');
ob_start();
require_once('includes/load.php');
if($session->isUserLoggedIn(true)) { redirect('home.php', false); }
?>
<?php

$servername = "127.0.0.1";
$username = "u510162695_inventory";
$password = "1Inventory_system";
$dbname = "u510162695_inventory";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['access'], $_GET['timestamp'])) {
    var_dump($_GET['access']);
    var_dump($_GET['timestamp']); 

    $user_ip = filter_var($_GET['access'], FILTER_VALIDATE_IP);
    $timestamp = urldecode($_GET['timestamp']);
    $timestamp = filter_var($timestamp, FILTER_SANITIZE_STRING);

    $date_only = substr($timestamp, 0, 10);  
    var_dump($date_only); 

    if ($user_ip && $date_only) {
        echo "Valid IP: " . $user_ip;
        echo "Valid Date: " . $date_only;

        if ($stmt = $conn->prepare("INSERT INTO log (access, log_at) VALUES (?, ?)")) {
            echo "Prepared statement is working.";

            if ($stmt->bind_param("ss", $user_ip, $date_only)) {
                echo "Parameters bound successfully.";
            } else {
                echo "Failed to bind parameters.";
            }

            if ($stmt->execute()) {
                $message = "<p>IP Address and Date successfully recorded.</p>";
            } else {
                $message = "<p>Failed to record IP Address and Date. Error: " . $stmt->error . "</p>";
            }

            $stmt->close();
        } else {
            $message = "<p>Failed to prepare statement.</p>";
        }
    } else {
        $message = "<p>Invalid IP Address or Date.</p>";
    }
}

include 'theme/head.php';
include 'theme/header.php';
?>
<link rel="icon" type="image/x-icon" href="uploads/users/rizel.png">

<div class="container">
    <?php if (isset($message)) echo htmlspecialchars($message); ?>
</div>
