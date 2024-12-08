<?php
require_once('includes/load.php');
page_require_level(1);

$categorie = find_by_id('categories', (int)$_GET['id']);
if (!$categorie) {
    $session->msg("d", "Missing Category id.");
    redirect('categorie.php');
}

$delete_id = delete_by_id('categories', (int)$categorie['id']);
if ($delete_id) {
    $session->msg("s", "Category Deleted Successfully.");
    redirect('categorie.php?success=true&delete_cat=true');
} else {
    
    $session->msg("d", "Category deletion failed.");
    redirect('categorie.php');
}
?>

