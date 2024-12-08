<?php
  require_once('includes/load.php');
  page_require_level(2);

  // Find the product by ID
  $product = find_by_id('other', (int)$_GET['id']);
  if (!$product) {
    $session->msg("d", "Missing Device ID.");
    redirect('barrowedotherreturn.php');
  }

  
  $sql = "UPDATE other 
  SET barrow = '', 
      datebarrowed = NULL, 
      datereturn = NULL 
  WHERE id = " . (int)$product['id'];



  if ($db->query($sql)) {
      $session->msg("s", "Device status and dates updated successfully.");
      redirect('barrowedotherreturn.php?success=true&delete_photo=true'); // Add success parameter
  } else {
      $session->msg("d", "Failed to clear device status or update dates.");
      redirect('barrowedotherreturn.php');
  }
?>
