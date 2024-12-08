<?php
require_once('includes/load.php');
// Check What level user has permission to view this page
page_require_level(2);

$find_computer = find_by_id('computer', (int)$_GET['id']);
$photo = new computer();

if ($photo->computer_destroy($find_computer['id'], $find_computer['file_name'])) {
    $session->msg("s", "Photo has been deleted.");
    redirect('bar1.php?success=true&delete_photo=true'); // Add success parameter
} else {
    
    $session->msg("d", "Photo deletion failed Or Missing Prm.");
    redirect('bar1.php');
}
?>

