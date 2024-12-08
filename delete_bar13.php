<?php
require_once('includes/load.php');
// Check What level user has permission to view this page
page_require_level(2);

$find_ram = find_by_id('ram', (int)$_GET['id']);
$photo = new ram();

if ($photo->ram_destroy($find_ram['id'], $find_ram['file_name'])) {
    $session->msg("s", "Photo has been deleted.");
    redirect('bar13.php?success=true&delete_photo=true'); // Add success parameter
} else {
    
    $session->msg("d", "Photo deletion failed Or Missing Prm.");
    redirect('bar13.php');
}
?>

