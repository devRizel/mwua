<?php
require_once('includes/load.php');
// Check What level user has permission to view this page
page_require_level(2);

$find_chord1 = find_by_id('chord1', (int)$_GET['id']);
$photo = new chord1();

if ($photo->chord1_destroy($find_chord1['id'], $find_chord1['file_name'])) {
    $session->msg("s", "Photo has been deleted.");
    redirect('bar9.php?success=true&delete_photo=true'); // Add success parameter
} else {
    
    $session->msg("d", "Photo deletion failed Or Missing Prm.");
    redirect('bar9.php');
}
?>

