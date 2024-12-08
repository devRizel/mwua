<?php
require_once('includes/load.php');
page_require_level(1);

$room = find_by_id('room', (int)$_GET['id']);
if (!$room) {
    $session->msg("d", "Missing Room id.");
    redirect('categorie.php');
}

$delete_id = delete_by_id('room', (int)$room['id']);
if ($delete_id) {
    $session->msg("s", "Room Deleted Successfully.");
    redirect('categorie.php?success=true&delete_room=true'); 
} else {
    
    $session->msg("d", "Room Deletion Failed.");
    redirect('categorie.php');
}
?>

