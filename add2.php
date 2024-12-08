<link rel="icon" type="image/x-icon" href="uploads/users/rizel.png">
<?php
// Start of PHP code

// PHP date_default_timezone_set Function & Examples
date_default_timezone_set('Asia/Manila');
$page_title = 'Add Product';
require_once('includes/load.php');



// Checking user permission to view page
page_require_level(2);

// Fetch categories, rooms, & photos
$all_categories = find_all('categories');
$all_room = find_all('room');
$all_photo = find_all('media');
$all_other_images = find_all('other_images');

$form_data = array(
  'Room-Title' => isset($_POST['Room-Title']) ? $_POST['Room-Title'] : '',
  'Device-Category' => isset($_POST['Device-Category']) ? $_POST['Device-Category'] : '',
  'Device-Photo' => isset($_POST['Device-Photo']) ? $_POST['Device-Photo'] : '',
  'other_images' => isset($_POST['other_images']) ? $_POST['other_images'] : '',
  'donate' => isset($_POST['donate']) ? $_POST['donate'] : '',
  'dreceived' => isset($_POST['dreceived']) ? $_POST['dreceived'] : '',
  'recievedby' => isset($_POST['recievedby']) ? $_POST['recievedby'] : '',
  'serial' => isset($_POST['serial']) ? $_POST['serial'] : ''
);
function motherboard_exists($motherboard_model) {
  global $db;
  $motherboard_model = $db->escape($motherboard_model);
  $query = "SELECT id FROM other WHERE serial = '{$motherboard_model}' LIMIT 1";
  $result = $db->query($query);
  return $db->num_rows($result) > 0;
}
// Handling form submission
if (isset($_POST['add_product'])) {
  // Required fields
  $req_fields = array(
    'serial' => 'Serial',
    'recievedby' => 'Recieved By',
      'dreceived' => '',
      'donate' => 'Donated By',
      'other_images' => 'Other Device images',
      'Device-Photo' => 'Device Photo',
      'Device-Category' => 'Device Category',
      'Room-Title' => 'Room Title'
      
  );

  $errors = array();
  foreach ($req_fields as $field => $placeholder) {
      if (isset($_POST[$field]) && $_POST[$field] === '') {
          $errors[$field] = "{$placeholder} can't be blank.";
      }
    }
    // Check if motherboard model already exists
    if (motherboard_exists($_POST['serial'])) {
        $errors['serial'] = "Serial Num. '{$_POST['serial']}' already exists.";
    }  
        // Validate date received
    if (empty($_POST['dreceived'])) {
         $errors['dreceived'] = "Date Received can't be blank.";
    } else {
         $date_received = $_POST['dreceived'];
         $today = new DateTime();  // Current date and time
         $selected_date = new DateTime($date_received);  // Date received from the form input

           if ($selected_date > $today) {
             $errors['dreceived'] = "Date Received cannot be a future date.";
      }
    }

  if (empty($errors)) {

      $p_name = remove_junk($db->escape($_POST['Room-Title']));
      $p_cat = (int)$db->escape($_POST['Device-Category']);
      $p_donate = remove_junk($db->escape($_POST['donate']));
      $p_recievedby = remove_junk($db->escape($_POST['recievedby']));
      $p_serial = remove_junk($db->escape($_POST['serial']));
     

      $media_id = is_null($_POST['Device-Photo']) || $_POST['Device-Photo'] === "" ? '0' : (int)$db->escape($_POST['Device-Photo']);
      $other_images = is_null($_POST['other_images']) || $_POST['other_images'] === "" ? '0' : (int)$db->escape($_POST['other_images']);
      $date = date('Y-m-d H:i:s');  // Current date and time

      // Include 'dreceived' in the INSERT query
     
      $query = "INSERT INTO other (name, categorie_id,recievedby,serial, donate, media_id, date, dreceived,other_images) VALUES ";
      $query .= "('{$p_name}', '{$p_cat}', '{$p_donate}','{$p_serial}', '{$p_recievedby}','{$media_id}', '{$date}', '{$date_received}', '{$other_images}')";

      if ($db->query($query)) {
        // Computer added successfully
        header("Location: add2.php?success=true");
        exit();
    } else {
        // Failed to add computer
        $session->msg('d', 'Failed to add computer!');
        header("Location: add2.php");
        exit();
    }
} else {
    // Convert errors array to JSON for JavaScript
    $js_error_msgs = json_encode($errors);
}
}
// Get already used image IDs
$saved_image_ids = [];
$query = "SELECT DISTINCT other_images FROM other";
$result = $db->query($query);
while ($row = $result->fetch_assoc()) {
    foreach ($row as $image_id) {
        if ($image_id != 0) {
            $saved_image_ids[] = $image_id;
        }
    }
}

// Function to filter options
function filter_options($options, $saved_image_ids) {
    return array_filter($options, function($option) use ($saved_image_ids) {
        return !in_array($option['id'], $saved_image_ids);
    });
}

$all_other_images = filter_options($all_other_images, $saved_image_ids);


?>


<?php include_once('layouts/header.php'); ?>

<div class="row">
  <div class="col-md-offset-2 col-md-8 ">
    <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="panel panel-default">
      <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span style="text-shadow: 2px 2px 2px rgba(0, 0, 0, 0.2);">Add Other Devices</span>
        </strong>
      </div>
      <div class="panel-body">
        <div class="col-md-12">
          <form method="post" action="add2" class="clearfix">
            <div class="form-group col-md-8 col-md-offset-2">
            <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="Room-Title">
            <option value="">Select Room Title</option>
            <?php foreach ($all_room as $room): ?>
                <option value="<?php echo remove_junk($room['name']); ?>" <?php echo ($form_data['Room-Title'] === remove_junk($room['name'])) ? 'selected' : ''; ?>>
                    <?php echo remove_junk($room['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
            </div>

            <div class="form-group">
              <div class="row">
                <div class="col-md-6">
                  <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="Device-Category">
                    <option value="">Select Device Category</option>
                    <?php foreach ($all_categories as $cat): ?>
                      <?php if ($cat['name'] != 'Computer'): ?>
                        <option value="<?php echo (int)$cat['id']; ?>" <?php echo ($form_data['Device-Category'] == (int)$cat['id']) ? 'selected' : ''; ?>>
                          <?php echo htmlspecialchars($cat['name']) ?></option>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-md-6">
                  <!-- Assuming this is for Device Photo -->
                  <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="Device-Photo">
                    <option value="">Select Device Photo</option>
                    <?php foreach ($all_photo as $photo): ?>
                        <option value="<?php echo (int)$photo['id']; ?>" <?php echo ($form_data['Device-Photo'] == (int)$photo['id']) ? 'selected' : ''; ?>>
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
                    <input id="q" type="text" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="donate" placeholder="Donated By" value="<?php echo htmlspecialchars($form_data['donate']); ?>">
                 </div>
                 <div class="col-md-6">
                    <input type="text" class="form-control datepicker" name="dreceived" placeholder="Date Received" required readonly value="<?php echo htmlspecialchars($form_data['dreceived']); ?>">
                 </div>
               </div>
            </div>

            <div class="form-group">
               <div class="row">
                  <div class="col-md-6">
                    <input id="w" type="text" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="recievedby" placeholder="Recieved By" value="<?php echo htmlspecialchars($form_data['recievedby']); ?>">
                  </div>
                  <div class="col-md-6">
                    <input id="e" type="text" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="serial" placeholder="Serial Number" value="<?php echo htmlspecialchars($form_data['serial']); ?>">
                  </div>
                </div>
            </div>

            <div class="form-group">
                  <div class="col-md-8 col-md-offset-2">
                  <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="other_images">
                    <option value="">Select Other Device Barcode Photo</option>
                    <?php foreach ($all_other_images as $photo): ?>
                    <option value="<?php echo (int)$photo['id']; ?>" <?php echo ($form_data['other_images'] == (int)$photo['id']) ? 'selected' : ''; ?>>
                        <?php echo $photo['file_name']; ?>
                    </option>
                    <?php endforeach; ?>
                  </select>
                 </div>
                </div>
             </div>
             </div>

            <center><div class="form-group ">
              <button style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" type="submit" name="add_product"  
              class="btn btn-primary">Add Other Devices</button></center>
          </form>
        </div>
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
<script>
const urlParams = new URLSearchParams(window.location.search);
const successParam = urlParams.get('success');
if (successParam === 'true') {
    swal("", "Other Device added successfully", "success")
        .then((value) => {
            // Redirect to clear query parameter
            window.location.href = 'add2.php';
        });
}
</script>

<script src="sweetalert.min.js"></script>
<?php if (isset($js_error_msgs)): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var errorMessages = <?php echo $js_error_msgs; ?>;
        Object.keys(errorMessages).forEach(function(key) {
            swal({
                title: "",
                text: errorMessages[key],
                icon: "warning",
                dangerMode: true
            });
        });
    });
</script>
<?php endif; ?>
<script src="sweetalert.min.js"></script>
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
    const qInput = document.getElementById('q');
    const wInput = document.getElementById('w');
    const eInput = document.getElementById('e');
    detectXSS(qInput, 'Donated By');
    detectXSS(wInput, 'Serial Num.');
    detectXSS(eInput, 'Recieved By');
</script>