<?php
require_once('includes/load.php');
// Check What level user has permission to view this page
page_require_level(2);

$find_monitor = find_by_id('monitor', (int)$_GET['id']);
$photo = new monitor();

if ($photo->monitor_destroy($find_monitor['id'], $find_monitor['file_name'])) {
    $session->msg("s", "Photo has been deleted.");
    redirect('bar2.php?success=true&delete_photo=true'); // Add success parameter
} else {
    
    $session->msg("d", "Photo deletion failed Or Missing Prm.");
    redirect('bar2.php');
}
?>

