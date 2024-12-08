<?php
require_once('includes/load.php');
// Check What level user has permission to view this page
page_require_level(2);

$find_video = find_by_id('video', (int)$_GET['id']);
$photo = new video();

if ($photo->video_destroy($find_video['id'], $find_video['file_name'])) {
    $session->msg("s", "Photo has been deleted.");
    redirect('bar14.php?success=true&delete_photo=true'); // Add success parameter
} else {
    
    $session->msg("d", "Photo deletion failed Or Missing Prm.");
    redirect('bar14.php');
}
?>

