<?php
require_once('includes/load.php');
// Check What level user has permission to view this page
page_require_level(2);

$find_keyboard = find_by_id('keyboard', (int)$_GET['id']);
$photo = new keyboard();

if ($photo->keyboard_destroy($find_keyboard['id'], $find_keyboard['file_name'])) {
    $session->msg("s", "Photo has been deleted.");
    redirect('bar3.php?success=true&delete_photo=true'); // Add success parameter
} else {
    
    $session->msg("d", "Photo deletion failed Or Missing Prm.");
    redirect('bar3.php');
}
?>

