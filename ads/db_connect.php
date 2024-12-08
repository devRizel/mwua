<?php
if (!isset($_GET['access']) || $_GET['access'] !== 'allowed') {
    header("Location: ../index.html");
    exit();
}

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

?>
