<?php
require_once('includes/load.php');
// Check What level user has permission to view this page
page_require_level(2);

$find_mother = find_by_id('mother', (int)$_GET['id']);
$photo = new mother();

if ($photo->mother_destroy($find_mother['id'], $find_mother['file_name'])) {
    $session->msg("s", "Photo has been deleted.");
    redirect('bar11.php?success=true&delete_photo=true'); // Add success parameter
} else {
    
    $session->msg("d", "Photo deletion failed Or Missing Prm.");
    redirect('bar11.php');
}
?>

