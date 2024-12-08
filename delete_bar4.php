<?php
require_once('includes/load.php');
// Check What level user has permission to view this page
page_require_level(2);

$find_mouse = find_by_id('mouse', (int)$_GET['id']);
$photo = new mouse();

if ($photo->mouse_destroy($find_mouse['id'], $find_mouse['file_name'])) {
    $session->msg("s", "Photo has been deleted.");
    redirect('bar4.php?success=true&delete_photo=true'); // Add success parameter
} else {
    
    $session->msg("d", "Photo deletion failed Or Missing Prm.");
    redirect('bar4.php');
}
?>

