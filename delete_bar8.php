<?php
require_once('includes/load.php');
// Check What level user has permission to view this page
page_require_level(2);

$find_power2 = find_by_id('power2', (int)$_GET['id']);
$photo = new power2();

if ($photo->power2_destroy($find_power2['id'], $find_power2['file_name'])) {
    $session->msg("s", "Photo has been deleted.");
    redirect('bar8.php?success=true&delete_photo=true'); // Add success parameter
} else {
    
    $session->msg("d", "Photo deletion failed Or Missing Prm.");
    redirect('bar8.php');
}
?>

