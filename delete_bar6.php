<?php
require_once('includes/load.php');
// Check What level user has permission to view this page
page_require_level(2);

$find_vgahdmi = find_by_id('vgahdmi', (int)$_GET['id']);
$photo = new vgahdmi();

if ($photo->vgahdmi_destroy($find_vgahdmi['id'], $find_vgahdmi['file_name'])) {
    $session->msg("s", "Photo has been deleted.");
    redirect('bar6.php?success=true&delete_photo=true'); // Add success parameter
} else {
    
    $session->msg("d", "Photo deletion failed Or Missing Prm.");
    redirect('bar6.php');
}
?>

