<?php
require_once('includes/load.php');
// Check What level user has permission to view this page
page_require_level(2);

$find_chord2 = find_by_id('chord2', (int)$_GET['id']);
$photo = new chord2();

if ($photo->chord2_destroy($find_chord2['id'], $find_chord2['file_name'])) {
    $session->msg("s", "Photo has been deleted.");
    redirect('bar10.php?success=true&delete_photo=true'); // Add success parameter
} else {
    
    $session->msg("d", "Photo deletion failed Or Missing Prm.");
    redirect('bar10.php');
}
?>

