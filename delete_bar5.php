<?php
require_once('includes/load.php');
// Check What level user has permission to view this page
page_require_level(2);

$find_system = find_by_id('system', (int)$_GET['id']);
$photo = new system();

if ($photo->system_destroy($find_system['id'], $find_system['file_name'])) {
    $session->msg("s", "Photo has been deleted.");
    redirect('bar5.php?success=true&delete_photo=true'); // Add success parameter
} else {
    
    $session->msg("d", "Photo deletion failed Or Missing Prm.");
    redirect('bar5.php');
}
?>

