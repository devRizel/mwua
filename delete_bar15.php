<?php
require_once('includes/load.php');
// Check What level user has permission to view this page
page_require_level(2);

$find_hddssdgb = find_by_id('hddssdgb', (int)$_GET['id']);
$photo = new hddssdgb();

if ($photo->hddssdgb_destroy($find_hddssdgb['id'], $find_hddssdgb['file_name'])) {
    $session->msg("s", "Photo has been deleted.");
    redirect('bar15.php?success=true&delete_photo=true'); // Add success parameter
} else {
    
    $session->msg("d", "Photo deletion failed Or Missing Prm.");
    redirect('bar15.php');
}
?>

