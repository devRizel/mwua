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

// Filter categories to include only "Computer"
$filtered_cat = array_filter($all_categories, function($cat) {
  return $cat['name'] == 'Computer';
});

$form_data = array(
  'Room-Title' => isset($_POST['Room-Title']) ? $_POST['Room-Title'] : '',
  'Device-Category' => isset($_POST['Device-Category']) ? $_POST['Device-Category'] : '',
  'Device-Photo' => isset($_POST['Device-Photo']) ? $_POST['Device-Photo'] : '',
  'donate' => isset($_POST['donate']) ? $_POST['donate'] : '',
  'dreceived' => isset($_POST['dreceived']) ? $_POST['dreceived'] : '',
  'recievedby' => isset($_POST['recievedby']) ? $_POST['recievedby'] : '',
  'monitor' => isset($_POST['monitor']) ? $_POST['monitor'] : '',
  'keyboard' => isset($_POST['keyboard']) ? $_POST['keyboard'] : '',
  'mouse' => isset($_POST['mouse']) ? $_POST['mouse'] : '',
  'v1' => isset($_POST['v1']) ? $_POST['v1'] : '',
  'p1' => isset($_POST['p1']) ? $_POST['p1'] : '',
  'p2' => isset($_POST['p2']) ? $_POST['p2'] : '',
  'power1' => isset($_POST['power1']) ? $_POST['power1'] : '',
  'system' => isset($_POST['system']) ? $_POST['system'] : '',
  'mother' => isset($_POST['mother']) ? $_POST['mother'] : '',
  'cpu' => isset($_POST['cpu']) ? $_POST['cpu'] : '',
  'ram' => isset($_POST['ram']) ? $_POST['ram'] : '',
  'power2' => isset($_POST['power2']) ? $_POST['power2'] : '',
  'video' => isset($_POST['video']) ? $_POST['video'] : '',
  'h' => isset($_POST['h']) ? $_POST['h'] : ''
);

function motherboard_exists($motherboard_model) {
    global $db;
    $motherboard_model = $db->escape($motherboard_model);
    $query = "SELECT id FROM products WHERE mother = '{$motherboard_model}' LIMIT 1";
    $result = $db->query($query);
    return $db->num_rows($result) > 0;
}

// Handling form submission
if (isset($_POST['add_product'])) {
  $errors = array();
  // Required fields
  $req_fields = array(
      'h' => 'HDD|SSD|GB',
      'video' => 'Video Card|GPU',
      'power2' => 'Power Supply 2',
      'ram' => 'RAM Quantity|Model',
      'cpu' => 'CPU|Processor',
      'mother' => 'Motherboard Model',
      'system' => 'System Unit Model',
      'power1' => 'Power Supply|AVR',
      'p2' => 'Power Cord 2',
      'p1' => 'Power Cord 1',
      'v1' => 'VGA|HDMI',
      'mouse' => 'Mouse',
      'keyboard' => 'Keyboard',
      'monitor' => 'Monitor',
      'recievedby' => 'Recieved By',
      'dreceived' => 'Date Received',
      'donate' => 'Donated By',
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
    if (motherboard_exists($_POST['mother'])) {
        $errors['mother'] = "Motherboard Serial Num. '{$_POST['mother']}' already exists.";
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
      $p_monitor = remove_junk($db->escape($_POST['monitor']));
      $p_keyboard = remove_junk($db->escape($_POST['keyboard']));
      $p_mouse = remove_junk($db->escape($_POST['mouse']));
      $p_v1 = remove_junk($db->escape($_POST['v1']));
      $p_p1 = remove_junk($db->escape($_POST['p1']));
      $p_p2 = remove_junk($db->escape($_POST['p2']));
      $p_power1 = remove_junk($db->escape($_POST['power1']));
      $p_system = remove_junk($db->escape($_POST['system']));
      $p_mother = remove_junk($db->escape($_POST['mother']));
      $p_cpu = remove_junk($db->escape($_POST['cpu']));
      $p_ram = remove_junk($db->escape($_POST['ram']));
      $p_power2 = remove_junk($db->escape($_POST['power2']));
      $p_video = remove_junk($db->escape($_POST['video']));
      $p_h = remove_junk($db->escape($_POST['h']));

      $media_id = is_null($_POST['Device-Photo']) || $_POST['Device-Photo'] === "" ? '0' : (int)$db->escape($_POST['Device-Photo']);
      $date = date('Y-m-d H:i:s');  // Current date and time

// Include 'dreceived' in the INSERT query
$query = "INSERT INTO products (name, categorie_id, donate,recievedby, monitor, keyboard, mouse, v1, p1, p2, power1, system, mother, cpu, ram, power2, video, h, media_id, date, dreceived) VALUES ";
$query .= "('{$p_name}', '{$p_cat}', '{$p_recievedby}','{$p_donate}' ,'{$p_monitor}', '{$p_keyboard}', '{$p_mouse}', '{$p_v1}', '{$p_p1}', '{$p_p2}', '{$p_power1}', '{$p_system}', '{$p_mother}', '{$p_cpu}', '{$p_ram}', '{$p_power2}', '{$p_video}', '{$p_h}', '{$media_id}', '{$date}', '{$date_received}')";


      if ($db->query($query)) {
          // Computer added successfully
          header("Location: add_product1.php?success=true");
          exit();
      } else {
          // Failed to add computer
          $session->msg('d', 'Failed to add computer!');
          header("Location: add_product1.php");
          exit();
      }
  } else {
      // Convert errors array to JSON for JavaScript
      $js_error_msgs = json_encode($errors);
  }
}
?>
<link rel="icon" type="image/x-icon" href="uploads/users/rizel.png">


<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-offset-2 col-md-8 ">
    <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="panel panel-default">
      <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span style="text-shadow: 2px 2px 2px rgba(0, 0, 0, 0.2);">Add New Computer</span>
        </strong>
      </div>
      <div class="panel-body">
        <div class="col-md-12">
        <form method="post" action="add_product1" class="clearfix">
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
                     <?php foreach ($filtered_cat as $cat): ?>
                     <option value="<?php echo (int)$cat['id'] ?>" <?php echo ($cat['name'] == 'Computer') ? 'selected' : ''; ?>>
                     <?php echo htmlspecialchars($cat['name']) ?></option>
                     <?php endforeach; ?>
                  </select>
            </div>
            <div class="col-md-6">
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
                <input type="text" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="donate" placeholder="Donated By" value="<?php echo htmlspecialchars($form_data['donate']); ?>">
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control datepicker" name="dreceived" placeholder="Date Received" required readonly value="<?php echo htmlspecialchars($form_data['dreceived']); ?>">
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <input type="text" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="recievedby" placeholder="Recieved By" value="<?php echo htmlspecialchars($form_data['recievedby']); ?>">
            </div>
            <div class="col-md-6">
                <input type="text" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="keyboard" placeholder="Keyboard" value="<?php echo htmlspecialchars($form_data['keyboard']); ?>">
            </div>
        </div>
    </div>
            <div class="form-group">
               <div class="row">
                 <div class="col-md-6">
                    <input type="text" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="mouse" placeholder="Mouse" value="<?php echo htmlspecialchars($form_data['mouse']); ?>">
                 </div>
                 <div class="col-md-6">
                     <input type="text" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="v1" placeholder="VGA|HDMI" value="<?php echo htmlspecialchars($form_data['v1']); ?>">
                  </div>
               </div>
            </div>

            <div class="form-group">
               <div class="row">
                 <div class="col-md-6">
                    <input type="text" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="p1" placeholder="Power Chord 1" value="<?php echo htmlspecialchars($form_data['p1']); ?>">
                 </div>
                 <div class="col-md-6">
                     <input type="text" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="p2" placeholder="Power Chord 2" value="<?php echo htmlspecialchars($form_data['p2']); ?>">
                  </div>
               </div>
            </div>

            <div class="form-group">
               <div class="row">
                 <div class="col-md-6">
                    <input type="text" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="power1" placeholder="Power Supply|AVR" value="<?php echo htmlspecialchars($form_data['power1']); ?>">
                 </div>
                 <div class="col-md-6">
                     <input type="text" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="system" placeholder="System Unit Model" value="<?php echo htmlspecialchars($form_data['system']); ?>">
                  </div>
               </div>
            </div>

            <div class="form-group">
               <div class="row">
                 <div class="col-md-6">
                    <input type="text" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="mother" placeholder="Motherboard|Serial Num" value="<?php echo htmlspecialchars($form_data['mother']); ?>">
                 </div>
                 <div class="col-md-6">
                     <input type="text" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="cpu" placeholder="CPU|Processesor" value="<?php echo htmlspecialchars($form_data['cpu']); ?>">
                  </div>
               </div>
            </div>

            <div class="form-group">
               <div class="row">
                 <div class="col-md-6">
                    <input type="text" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="ram" placeholder="RAM Quannty|Model" value="<?php echo htmlspecialchars($form_data['ram']); ?>">
                 </div>
                 <div class="col-md-6">
                     <input type="text" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="power2" placeholder="Power Supply 2" value="<?php echo htmlspecialchars($form_data['power2']); ?>">
                  </div>
               </div>
            </div>

            <div class="form-group">
               <div class="row">
                 <div class="col-md-6">
                    <input type="text" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="video" placeholder="Video Card|GPU" value="<?php echo htmlspecialchars($form_data['video']); ?>">
                 </div>
                 <div class="col-md-6">
                     <input type="text" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="h" placeholder="HDD|SSD|GB" value="<?php echo htmlspecialchars($form_data['h']); ?>">
                  </div>
               </div>
            </div>

            <div class="form-group">
               <div class="row">
                  <div class="col-md-6">
                    <input type="text" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="monitor" placeholder="Monitor" value="<?php echo htmlspecialchars($form_data['monitor']); ?>">
                  </div>
                </div>
            </div>

            <div class="form-group">
               <div class="row">
                  <div class="col-md-6">
                    <input type="text" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="monitor" placeholder="Monitor" value="<?php echo htmlspecialchars($form_data['monitor']); ?>">
                  </div>
                </div>
            </div>

            <div class="form-group">
               <div class="row">
                  <div class="col-md-6">
                    <input type="text" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="monitor" placeholder="Monitor" value="<?php echo htmlspecialchars($form_data['monitor']); ?>">
                  </div>
                </div>
            </div>

            <center><div class="form-group ">
              <button style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" type="submit" name="add_product"  class="btn btn-primary">Add Computer</button>
              <a style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" href="product.php" class="btn btn-danger" class="">Cancel</a>
            </div></center>
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
    swal("", "Computer added successfully", "success")
        .then((value) => {
            // Redirect to clear query parameter
            window.location.href = 'add_product1.php';
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
