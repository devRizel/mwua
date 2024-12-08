<?php
date_default_timezone_set('Asia/Manila');
$page_title = 'Edit vgahdmi';
require_once('includes/load.php');
page_require_level(3);

$vgahdmi = find_by_id('vgahdmi', (int)$_GET['id']);
if (!$vgahdmi) {
    $session->msg("d", "Missing category id.");
    redirect('bar6.php');
}

function find_vgahdmi_by_id($id) {
  global $db;
  $sql = "SELECT * FROM vgahdmi WHERE id = '{$id}' LIMIT 1";
  $result = $db->query($sql);

  if($result && $db->num_rows($result) > 0) {
      return $db->fetch_assoc($result);  
  } else {
      return null;
  }
}

if(isset($_GET['id'])){
    $vgahdmi_id = (int)$_GET['id'];
    $vgahdmi_file = find_vgahdmi_by_id($vgahdmi_id);
    if(!$vgahdmi_file){
        $session->msg('d', 'vgahdmi file not found.');
        redirect('bar6.php');
    }
}

if (isset($_FILES['file_name']) && $_FILES['file_name']['error'] == 0) {
  $file_name = $_FILES['file_name']['name'];
  $tmp_name = $_FILES['file_name']['tmp_name'];
  $upload_dir = 'uploads/products/'; // Define your upload directory

// Ensure the exclude_id is set correctly before using it in the query
$exclude_id = isset($vgahdmi_id) ? $vgahdmi_id : null;

$check_duplicate = "SELECT * FROM vgahdmi WHERE file_name = '{$file_name}'";

if ($exclude_id) {
    $exclude_id = (int)$exclude_id;  // Ensure the exclude_id is an integer
    $check_duplicate .= " AND id != {$exclude_id}";
}

$check_duplicate .= " LIMIT 1";

// Perform the query to check for duplicates
$result = $db->query($check_duplicate);
if ($result && $db->num_rows($result) > 0) {
    // Duplicate found
    $duplicate_error = "Please avoid using Duplicate Images!";
    redirect('bar6.php?error=true&message=' . urlencode($duplicate_error), false);
}


  // Set the path directly to the original file name
  $file_path = $upload_dir . $file_name;

  // Move the uploaded file to the server
  if (move_uploaded_file($tmp_name, $file_path)) {
      // Update the media record in the database with the original file name
      $sql = "UPDATE vgahdmi SET file_name='{$file_name}' WHERE id='{$vgahdmi['id']}'";
      $result = $db->query($sql);

      // Check if the query was successful
      if ($result) {
          redirect('bar6.php?success=true&Photos=true', false);
      } else {
          $session->msg('d', 'Failed to update vgahdmi.');
      }
  } else {
      $session->msg('d', 'Failed to upload file.');
  }
} else {
  $session->msg('d', 'No file selected or upload error.');
}

?>

<link rel="icon" type="image/x-icon" href="uploads/users/rizel.png">
<?php include_once('layouts/header.php'); ?>

<div class="row">
  <div class="col-md-offset-2 col-md-8">
      <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="panel panel-default">
        <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="panel-heading">
          <div class="panel-heading clearfix">
            <span class="glyphicon glyphicon-camera"></span>
           <span class="glyphicon "></span>
           <span>Editing <strong><?php echo remove_junk(ucfirst($vgahdmi['file_name']));?></strong></span>
          </div>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <img class="img-thumbnail" src="uploads/products/<?php echo $vgahdmi_file['file_name'];?>" alt="">
            </div>
            <div class="col-md-8">
              <form class="form" action="edit_bar6?id=<?php echo $vgahdmi['id']; ?>" method="POST" enctype="multipart/form-data">
              <div class="form-group col-md-offset-5">
                <input  style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" type="file" name="file_name" id="file_name" class="btn btn-file"/>
              </div>
              <div class="form-group col-md-offset-6">
              <center>
                <button style="border-radius: 50% 10% 50% 10% / 10% 50% 10% 50%; box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" type="submit" name="edit_bar3" class="btn btn-primary">Update Images</button>
                <a style="border-radius: 50% 10% 50% 10% / 10% 50% 10% 50%; box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" href="bar6.php" class="btn btn-danger">Cancel</a>
              </center>
             </form>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>
