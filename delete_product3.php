<?php
  require_once('includes/load.php');
  page_require_level(2);

  $product = find_by_id('products',(int)$_GET['id']);
  if(!$product){
    $session->msg("d","Missing Computer id.");
    redirect('product3.php');
  }
  
  $delete_id = delete_by_id('products',(int)$product['id']);
  if($delete_id){
      $session->msg("s","Computer Deleted Successfully.");
      redirect('product3.php?success=true&delete_photo=true'); // Add success parameter
  } else {
      $session->msg("d","Computer deletion failed.");
      redirect('product3.php');
  }
?>

