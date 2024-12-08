<?php
date_default_timezone_set('Asia/Manila');
require_once('includes/load.php');

if ($session->isUserLoggedIn(true)) {
    $user = current_user();

    $servername = "127.0.0.1";
    $username = "u510162695_inventory";
    $password = "1Inventory_system";
    $dbname = "u510162695_inventory";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "UPDATE users SET session_id = '' WHERE id = " . (int)$user['id'];

    if ($conn->query($sql) === TRUE) {
        if (!$session->logout()) {
            redirect("L-Login.php?access=allowed");
        }
    } else {
        echo "Error updating session: " . $conn->error;
    }

    $conn->close();
} else {
    redirect("L-Login.php?access=allowed");
}
?>
