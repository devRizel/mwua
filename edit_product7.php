<link rel="icon" type="image/x-icon" href="uploads/users/rizel.png">
<?php
date_default_timezone_set('Asia/Manila');
$page_title = 'Edit Computer';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(2);


$product = find_by_id('other', (int)$_GET['id']);
$all_categories = find_all('categories');
$all_room = find_all('room');
$all_photo = find_all('media');

function find_by_serial_number($serial_number, $exclude_id = null) {
  global $db;
  $serial_number = $db->escape($serial_number);
  $query = "SELECT * FROM other WHERE serial = '{$serial_number}'";

  // Exclude the current product by ID if provided
  if ($exclude_id) {
      $exclude_id = (int)$exclude_id;
      $query .= " AND id != {$exclude_id}";
  }

  $query .= " LIMIT 1";
  $result = $db->query($query);
  return $db->fetch_assoc($result);
}


$errors = array();
if (isset($_POST['add_product'])) {
    $field_messages = array(
        'Room-Title' => 'Room Title',
        'Device-Category' => 'Device Category',
        'Device-Photo' => 'Device Photo',
        'donate' => 'Donated By',
        'dreceived' => 'Date Received',
        'serial' => 'Serial',
        'recievedby' => 'Recieved By'
    );

    $req_fields = array('Room-Title', 'Device-Category', 'Device-Photo', 'donate', 'dreceived','serial','recievedby');

    $js_error_msgs = array();

    foreach ($req_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = isset($field_messages[$field]) ? $field_messages[$field] . " can't be blank." : ucfirst(str_replace('-', ' ', $field)) . " is required.";
            // Add error message to the JavaScript array
            $js_error_msgs[$field] = $errors[$field];
        }
    }
    if (empty($errors)) {
      // Pass the current product ID to exclude it from the check
      $existing_serial = find_by_serial_number($_POST['serial'], $product['id']);
      if ($existing_serial) {
          $errors[] = "Serial Number'{$_POST['serial']}' Already Exists.";
          $js_error_msgs['serial'] = $errors[count($errors) - 1];
      }
  }

// Validate Date Received not being a future date
$date_received = isset($_POST['dreceived']) ? (string)$_POST['dreceived'] : '';
$today = new DateTime();
$selected_date = DateTime::createFromFormat('Y-m-d', $date_received);
if ($selected_date > $today) {
    $errors[] = "Date Received cannot be a future date.";
}

  if (empty($errors)) {
    $p_name = remove_junk($db->escape($_POST['Room-Title']));
    $p_cat = (int)$db->escape($_POST['Device-Category']);
    $media_id = is_null($_POST['Device-Photo']) || $_POST['Device-Photo'] === "" ? '0' : (int)$db->escape($_POST['Device-Photo']);
    $p_donate = remove_junk($db->escape($_POST['donate']));
    $p_serial = remove_junk($db->escape($_POST['serial']));
    $p_recievedby = remove_junk($db->escape($_POST['recievedby']));
    $date = make_date();


    $query = "UPDATE other SET ";
    $query .= "name = '{$p_name}', ";
    $query .= "categorie_id = '{$p_cat}', ";
    $query .= "media_id = '{$media_id}', ";
    $query .= "donate = '{$p_donate}', ";
    $query .= "dreceived = '{$date_received}', ";
    $query .= "serial = '{$p_serial}', ";
    $query .= "recievedby = '{$p_recievedby}', ";
    $query .= "date = '{$date}' ";
    $query .= "WHERE id = '{$product['id']}'";
    

    $result = $db->query($query);

    if ($result && $db->affected_rows() === 1) {
        redirect('product7.php?success=true&update_success=true', false);
    } else {
        $session->msg('d', 'Failed to update Other Device.');
        redirect('edit_product7.php?id=' . (int)$product['id'], false);
    }
}
}



include_once('layouts/header.php');
?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>

<div class="row">
  <div class="col-md-offset-2 col-md-8">
    <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="panel panel-default">
      <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Edit Computer</span>
        </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="edit_product7?id=<?php echo (int)$product['id'] ?>">
          <div class="form-group col-md-8 col-md-offset-2">
            <label for="Room-Title">Room Title</label>
            <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="Room-Title">
              <option value="">Select a Room</option>
              <?php foreach ($all_room as $room): ?>
                <option value="<?php echo htmlspecialchars(remove_junk($room['name'])); ?>" <?php if (remove_junk($room['name']) === remove_junk($product['name'])) echo 'selected="selected"'; ?>>
                  <?php echo htmlspecialchars(remove_junk($room['name'])); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <label for="Device-Category">Device Category</label>
                <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="Device-Category">
                  <option value="">Select a Category</option>
                  <?php foreach ($all_categories as $cat): ?>
                    <?php if ($cat['name'] != 'Computer'): ?>
                    <option value="<?php echo (int)$cat['id']; ?>" <?php 
                      if($product['categorie_id'] == $cat['id']) echo "selected"; ?>>
                      <?php echo remove_junk($cat['name']); ?>
                    </option>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-6">
                <label for="Device-Photo">Device Photo</label>
                <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="Device-Photo">
                  <option value="">No image</option>
                  <?php foreach ($all_photo as $photo): ?>
                    <option value="<?php echo (int)$photo['id']; ?>" <?php if($product['media_id'] == $photo['id']) echo "selected"; ?>>
                      <?php echo $photo['file_name']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>

          <div class="form-group">
               <div class="row">
                 <div class="col-md-6">
                     <label for="Device-Photo">Donated By</label>
                     <input id="q" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" type="text" class="form-control" name="donate" value="<?php echo remove_junk($product['donate']);?>">
                 </div>
                 <div class="col-md-6">
                     <label for="Device-Photo">Date Received</label>
                     <input style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" type="text" class="form-control datepicker" name="dreceived" required readonly value="<?php echo remove_junk($product['dreceived']);?>">
                  </div>
               </div>
          </div>

          <div class="form-group">
               <div class="row">
                 <div class="col-md-6">
                     <label for="Device-Photo">Serial Num.</label>
                     <input id="w" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" type="text" class="form-control" name="serial" value="<?php echo remove_junk($product['serial']);?>">
                 </div>
                 <div class="col-md-6">
                     <label for="Device-Photo">Recieved By</label>
                     <input id="e" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" type="text" class="form-control" name="recievedby" value="<?php echo remove_junk($product['recievedby']);?>">
                 </div>
               </div>
          </div>


          <center><div class="form-group">
            <button  style=" border-radius: 50% 10% 50% 10% / 10% 50% 10% 50%; box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" type="submit" name="add_product" class="btn btn-primary">Update Computer</button>
            <a  style=" border-radius: 50% 10% 50% 10% / 10% 50% 10% 50%; box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" href="product7.php" class="btn btn-danger">Cancel</a>
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
<script src="sweetalert.min.js"></script>
<script>
    function detectXSS(inputField, fieldName) {
        const xssPattern = /[<>:\/\$\;\,\?\!]/;
        inputField.addEventListener('input', function() {
            if (xssPattern.test(this.value)) {
                swal("XSS Detected", `Please avoid using script tags in your ${fieldName}.`, "error");
                this.value = "";
            }
        });
    }
    const qInput = document.getElementById('q');
    const wInput = document.getElementById('w');
    const eInput = document.getElementById('e');
    detectXSS(qInput, 'Donated By');
    detectXSS(wInput, 'Serial Num.');
    detectXSS(eInput, 'Recieved By');
</script>