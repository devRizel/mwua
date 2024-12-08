<?php
  require_once('includes/load.php');
  page_require_level(2);

  $product = find_by_id('other',(int)$_GET['id']);
  if(!$product){
    $session->msg("d","Missing Computer id.");
    redirect('product7.php');
  }
  
  $delete_id = delete_by_id('other',(int)$product['id']);
  if($delete_id){
      $session->msg("s","Other Device Deleted Successfully.");
      redirect('product7.php?success=true&delete_photo=true'); // Add success parameter
  } else {
      $session->msg("d","Computer deletion failed.");
      redirect('product7.php');
  }
  
?>
