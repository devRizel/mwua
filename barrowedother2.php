<link rel="icon" type="image/x-icon" href="uploads/users/rizel.png">
<?php
date_default_timezone_set('Asia/Manila');
$page_title = 'Edit Computer';
require_once('includes/load.php');
// Checking what level user has permission to view this page
page_require_level(2);


$product = find_by_id('other', (int)$_GET['id']);
$all_categories = find_all('categories');
$all_room = find_all('room');
$all_photo = find_all('media');



if (!$product) {
    $session->msg("d", "Missing product id.");
    redirect('barrowedother.php');
}

$errors = array();
if (isset($_POST['add_product'])) {
    $field_messages = array(
        'barrow' => 'Barrow By'
    );

    $req_fields = array('barrow');

    $js_error_msgs = array();

    foreach ($req_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = isset($field_messages[$field]) ? $field_messages[$field] . " can't be blank." : ucfirst(str_replace('-', ' ', $field)) . " is required.";
            // Add error message to the JavaScript array
            $js_error_msgs[$field] = $errors[$field];
        }
    }



    if (empty($errors)) {
        // If no errors, proceed with updating the product
        $p_barrow = remove_junk($db->escape($_POST['barrow']));
        $date = make_date();
    
        $query = "UPDATE other SET ";
        $query .= "barrow = '{$p_barrow}' "; // Removed the extra comma here
        $query .= "WHERE id = '{$product['id']}'"; 
    
        $result = $db->query($query);
    
        if ($result && $db->affected_rows() === 1) {
            redirect('barrowedother.php?success=true&update_success=true', false);
        } else {
            $session->msg('d', 'Failed to update Computer.');
            redirect('barrowedother2.php?id=' . (int)$product['id'], false);
        }
    }
    
}


include_once('layouts/header.php');
?>
<div class="row">
  <div class="col-md-offset-2 col-md-8">
    <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="panel panel-default">
      <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Borrowed Peripheral Devices</span>
        </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="barrowedother2?id=<?php echo (int)$product['id'] ?>">
        <div class="form-group col-md-8 col-md-offset-2">
            <center><label>Barrow By</label></center>
            <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="barrow">
              <option>Return</option>
            </select>
          </div>

          <center><div class="form-group">
            <button style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" type="submit" name="add_product" class="btn btn-primary">Update Computer</button>
            <a style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" href="barrowedother.php" class="btn btn-danger">Cancel</a>
          </div></center>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>
<script>
$(document).ready(function() {
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',  // Format date as needed
        autoclose: true,
        endDate: new Date(),  // Disable dates after today
        todayHighlight: true,
        keyboardNavigation: false,
        forceParse: false,
        startDate: '-Infinity'
    });

    // Disable manual input
    $('.datepicker').keydown(function(e){
        e.preventDefault();
        return false;
    });
});
</script>

<script src="css/sweetalert.js"></script>
<?php if (!empty($js_error_msgs)): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Retrieve the first error message from the array
        var errorMessages = <?php echo json_encode(array_values($js_error_msgs)[0]); ?>;
        swal({
            title: "",
            text: errorMessages,
            icon: "warning",
            dangerMode: true
        });
    });
</script>
<?php endif; ?>
<script src="css/sweetalert.js"></script>
<?php if (!empty($errors)): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            swal({
                title: "",
                text: "<?php echo $errors[0]; ?>",
                icon: "warning",
                dangerMode: true
            });
        });
    </script>
<?php endif; ?>
