<?php
require_once('includes/load.php'); // Assuming this file sets up the database connection
page_require_level(2); // Adjust based on user access level

// Check if 'id' is provided in the URL
if (isset($_GET['id'])) {
    // Initialize database connection if not already included
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

    $message_id = (int)$_GET['id'];
    
    // Delete the message from the 'chat' table
    $delete_sql = "DELETE FROM chat WHERE id = {$message_id}";
    if ($conn->query($delete_sql) === TRUE) {
        $session->msg("s", "Message deleted successfully.");
        redirect('admin.php'); // Redirect back to the page with the modal
    } else {
        $session->msg("d", "Message deletion failed.");
        redirect('admin.php'); // Redirect back to the page with the modal
    }
} else {
    $session->msg("d", "Invalid message ID.");
    redirect('admin.php'); // Redirect back if no ID is provided
}
?>
