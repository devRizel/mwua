<?php
require_once('includes/load.php');
// Check What level user has permission to view this page
page_require_level(2);

$find_power1 = find_by_id('power1', (int)$_GET['id']);
$photo = new power1();

if ($photo->power1_destroy($find_power1['id'], $find_power1['file_name'])) {
    $session->msg("s", "Photo has been deleted.");
    redirect('bar7.php?success=true&delete_photo=true'); // Add success parameter
} else {
    
    $session->msg("d", "Photo deletion failed Or Missing Prm.");
    redirect('bar7.php');
}
?>

