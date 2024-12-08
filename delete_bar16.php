<?php
require_once('includes/load.php');
// Check What level user has permission to view this page
page_require_level(2);

$find_other_images = find_by_id('other_images', (int)$_GET['id']);
$photo = new other_images();

if ($photo->other_images_destroy($find_other_images['id'], $find_other_images['file_name'])) {
    $session->msg("s", "Photo has been deleted.");
    redirect('bar16.php?success=true&delete_photo=true'); // Add success parameter
} else {
    
    $session->msg("d", "Photo deletion failed Or Missing Prm.");
    redirect('bar16.php');
}
?>

