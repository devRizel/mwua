<?php
date_default_timezone_set('Asia/Manila');
$page_title = 'Edit categorie';
require_once('includes/load.php');
// Check in What level user has permission to view this page
page_require_level(1);

// Retrieve the category data before checking the POST request
$categorie = find_by_id('categories', (int)$_GET['id']);
if (!$categorie) {
    $session->msg("d", "Missing category id.");
    redirect('categorie.php');
}

if (isset($_POST['edit_cat'])) {
  $req_field = array('categorie-name');
  validate_fields($req_field);
  $cat_name = remove_junk($db->escape($_POST['categorie-name']));

  if (empty($errors)) {
      // Check if the category name already exists (duplicate check)
      $check_duplicate = $db->query("SELECT * FROM categories WHERE name = '{$cat_name}' AND id != '{$categorie['id']}'");

      if ($check_duplicate->num_rows > 0) {
          // Duplicate found, set an error message
          $duplicate_error = "Please avoid using Duplicate Categories!";
          redirect('categorie.php?error=true&message=' . urlencode($duplicate_error), false);  // Pass error through URL
      } else {
          // No duplicate, proceed with the update
          $sql = "UPDATE categories SET name='{$cat_name}' WHERE id='{$categorie['id']}'";
          $result = $db->query($sql);

          // Always redirect with update_success=true, regardless of update success
          redirect('categorie.php?success=true&update_success=true', false);
      }
  } else {
      // Set validation errors in session and stay on the same form
      $_SESSION['error_message'] = $errors;
      redirect('edit_categorie.php?id=' . (int)$categorie['id'], false);
  }
}
?>

<?php include_once('layouts/header.php'); ?>

<!-- Check for error message for duplicate category -->
<?php if (isset($duplicate_error)): ?>
    <script>
        swal("Error", "<?php echo $duplicate_error; ?>", "error");
    </script>
<?php endif; ?>

<div class="row">
   <div class="col-md-5">
     <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="panel panel-default">
       <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="panel-heading">
         <strong>
           <span class="glyphicon glyphicon-th"></span>
           <span>Editing <?php echo remove_junk(ucfirst($categorie['name']));?></span>
        </strong>
       </div>
       <div class="panel-body">
         <form method="post" action="edit_categorie?id=<?php echo (int)$categorie['id'];?>">
           <div class="form-group">
               <input id="cat" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" type="text" class="form-control" name="categorie-name" value="<?php echo remove_junk(ucfirst($categorie['name']));?>">
           </div>
           <center><button  style="border-radius: 50% 10% 50% 10% / 10% 50% 10% 50%; box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" type="submit" name="edit_cat" class="btn btn-primary">Update category</button>
           <a  style="border-radius: 50% 10% 50% 10% / 10% 50% 10% 50%; box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" href="categorie.php" class="btn btn-danger">Cancel</a></center>
       </form>
       </div>
     </div>
   </div>
</div>

<?php include_once('layouts/footer.php'); ?>
<script src="css/sweetalert.js"></script>
<script>
    function detectXSS(inputField, fieldName) {
        const xssPattern =  /[<>:\/\$\;\,\?\!]/;
        inputField.addEventListener('input', function() {
            if (xssPattern.test(this.value)) {
                swal("XSS Detected", `Please avoid using script tags in your ${fieldName}.`, "error");
                this.value = "";
            }
        });
    }
    const catInput = document.getElementById('cat');
    detectXSS(catInput, 'Category Name');
</script>
