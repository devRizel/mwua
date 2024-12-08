<link rel="icon" type="image/x-icon" href="uploads/users/rizel.png">
<?php
date_default_timezone_set('Asia/Manila');
$page_title = 'Edit Computer';
require_once('includes/load.php');
page_require_level(2);

$product = find_by_id('other', (int)$_GET['id']);
$all_other_images = find_all('other_images');

if (!$product) {
    $session->msg("d", "Missing product id.");
    redirect('otherdevices.php');
}


$errors = array();
$js_error_msgs = array();

if (isset($_POST['add_product'])) {
    $field_messages = array(
        'other_images' => 'Other Device Images'
    );

    $req_fields = array('other_images');

    foreach ($req_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = isset($field_messages[$field]) ? $field_messages[$field] . " can't be blank." : ucfirst(str_replace('-', ' ', $field)) . " is required.";
            $js_error_msgs[$field] = $errors[$field];
        }
    }
    
    $special_values = ['Maintenance' => 'Maintenance'];

    function handle_special_value($field_name) {
        global $special_values, $db;
        $value = isset($_POST[$field_name]) ? $_POST[$field_name] : '';
        return isset($special_values[$value]) ? $special_values[$value] : (is_null($value) || $value === "" ? '0' : (int)$db->escape($value));
    }

    $p_computer_images = handle_special_value('other_images');
    $date = make_date();

    $query = "UPDATE other SET ";
    $query .= "other_images = '{$p_computer_images}', ";
    $query .= "date = '{$date}' ";
    $query .= "WHERE id = '{$product['id']}'"; 

    if (empty($errors)) {
        $result = $db->query($query);

        if ($result && $db->affected_rows() === 1) {
            redirect('otherdevices.php?success=true&update_success=true', false);
        } else {
            $session->msg('d', 'Failed to update Computer.');
            redirect('otherdevicesmain.php?id=' . (int)$product['id'], false);
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
          <span>Status Maintenance Other Device</span>
        </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="otherdevicesmain?id=<?php echo (int)$product['id'] ?>">
          <div class="form-group col-md-8 col-md-offset-2">
            <center><label for="Room-Title">Other Device Barcode Photo</label></center>
            <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="other_images">
                  <option value="Maintenance" <?php if($product['other_images'] === 'Maintenance') echo "selected"; ?>>Maintenance</option>
                  <?php foreach ($all_other_images as $photo): ?>
                    <option value="<?php echo (int)$photo['id']; ?>" <?php if($product['other_images'] == $photo['id']) echo "selected"; ?>>
                      <?php echo $photo['file_name']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
          </div>
          

          <center><div class="form-group">
            <button style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" type="submit" name="add_product" class="btn btn-primary">Update Computer</button>
            <a style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" href="otherdevices.php" class="btn btn-danger">Cancel</a>
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

<script src="sweetalert.min.js"></script>
<?php if (!empty($js_error_msgs)): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
<?php if (!empty($errors)): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            swal({
                title: "",
                text: "<?php echo htmlspecialchars(array_values($errors)[0]); ?>",
                icon: "warning",
                dangerMode: true
            });
        });
    </script>
<?php endif; ?>
