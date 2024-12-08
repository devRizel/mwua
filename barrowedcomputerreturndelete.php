<?php
  require_once('includes/load.php');
  page_require_level(2);

  // Find the product by ID
  $product = find_by_id('products', (int)$_GET['id']);
  if (!$product) {
    $session->msg("d", "Missing Device ID.");
    redirect('barrowedcomputerreturn.php');
  }

  
  $sql = "UPDATE products
  SET barrow = '', 
      datebarrowed = NULL, 
      datereturn = NULL 
  WHERE id = " . (int)$product['id'];


  if ($db->query($sql)) {
      $session->msg("s", "Device status and dates updated successfully.");
      redirect('barrowedcomputerreturn.php?success=true&delete_photo=true'); // Add success parameter
  } else {
      $session->msg("d", "Failed to clear device status or update dates.");
      redirect('barrowedcomputerreturn.php');
  }
?>
