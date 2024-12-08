<?php
require_once('includes/load.php');
// Check What level user has permission to view this page
page_require_level(2);

$find_cpu = find_by_id('cpu', (int)$_GET['id']);
$photo = new cpu();

if ($photo->cpu_destroy($find_cpu['id'], $find_cpu['file_name'])) {
    $session->msg("s", "Photo has been deleted.");
    redirect('bar12.php?success=true&delete_photo=true'); // Add success parameter
} else {
    
    $session->msg("d", "Photo deletion failed Or Missing Prm.");
    redirect('bar12.php');
}
?>

