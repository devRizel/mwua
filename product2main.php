<link rel="icon" type="image/x-icon" href="uploads/users/rizel.png">
<?php
date_default_timezone_set('Asia/Manila');
$page_title = 'Edit Computer';
require_once('includes/load.php');
page_require_level(2);



$product = find_by_id('products', (int)$_GET['id']);
$all_computer = find_all('computer');
$all_monitor = find_all('monitor');
$all_keyboard = find_all('keyboard');
$all_mouse = find_all('mouse');
$all_system = find_all('system');
$all_vgahdmi = find_all('vgahdmi');
$all_power1 = find_all('power1');
$all_power2 = find_all('power2');
$all_chord1 = find_all('chord1');
$all_chord2 = find_all('chord2');
$all_mother = find_all('mother');
$all_cpu = find_all('cpu');
$all_ram = find_all('ram');
$all_video = find_all('video');
$all_hddssdgb = find_all('hddssdgb');

if (!$product) {
    $session->msg("d", "Missing product id.");
    redirect('product2.php');
}

$errors = array();
if (isset($_POST['add_product'])) {
    $field_messages = array(
        'computer_images' => 'Computer Images',
        'monitor_images' => 'Monitor Images',
        'keyboard_images' => 'Keyboard Images',
        'mouse_images' => 'Mouse Images',
        'system_images' => 'System Unit Model Images',
        'vgahdmi_images' => 'VGA|HDMI Images',
        'power1_images' => 'Power Supply1 Images',
        'power2_images' => 'Power Supply2 Images',
        'chord1_images' => 'Power Chord 1 Images',
        'chord2_images' => 'Power Chord 2 Images',
        'mother_images' => 'Motherboard Model Images',
        'cpu_images' => 'CPU|Processor Images',
        'ram_images' => 'RAM Quantity|Model Images',
        'video_images' => 'Video Card|GPU Images',
        'hddssdgb_images' => 'HDD|SSD|GB Images'
    );

    $req_fields = array('computer_images', 'monitor_images', 'keyboard_images', 
    'mouse_images', 'system_images', 'vgahdmi_images', 'power1_images', 'power2_images', 
    'chord1_images', 'chord2_images', 'mother_images', 'cpu_images', 'ram_images', 'video_images', 
    'hddssdgb_images');

    $js_error_msgs = array();

    foreach ($req_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = isset($field_messages[$field]) ? $field_messages[$field] . " can't be blank." : ucfirst(str_replace('-', ' ', $field)) . " is required.";
            // Add error message to the JavaScript array
            $js_error_msgs[$field] = $errors[$field];
        }
    }
    
    $special_values = ['Maintenance' => 'Maintenance'];

    // Function to handle special values
    function handle_special_value($field_name) {
        global $special_values, $db;
        $value = isset($_POST[$field_name]) ? $_POST[$field_name] : '';
        return isset($special_values[$value]) ? $special_values[$value] : (is_null($value) || $value === "" ? '0' : (int)$db->escape($value));
    }

    $p_computer_images = handle_special_value('computer_images');
    $p_monitor_images = handle_special_value('monitor_images');
    $p_keyboard_images = handle_special_value('keyboard_images');
    $p_mouse_images = handle_special_value('mouse_images');
    $p_system_images = handle_special_value('system_images');
    $p_vgahdmi_images = handle_special_value('vgahdmi_images');
    $p_power1_images = handle_special_value('power1_images');
    $p_power2_images = handle_special_value('power2_images');
    $p_chord1_images = handle_special_value('chord1_images');
    $p_chord2_images = handle_special_value('chord2_images');
    $p_mother_images = handle_special_value('mother_images');
    $p_cpu_images = handle_special_value('cpu_images');
    $p_ram_images = handle_special_value('ram_images');
    $p_video_images = handle_special_value('video_images');
    $p_hddssdgb_images = handle_special_value('hddssdgb_images');
    $date = make_date();

    $query = "UPDATE products SET ";
    $query .= "computer_images = '{$p_computer_images}', ";
    $query .= "monitor_images = '{$p_monitor_images}', ";
    $query .= "keyboard_images = '{$p_keyboard_images}', ";
    $query .= "mouse_images = '{$p_mouse_images}', ";
    $query .= "system_images = '{$p_system_images}', ";
    $query .= "vgahdmi_images = '{$p_vgahdmi_images}', ";
    $query .= "power1_images = '{$p_power1_images}', ";
    $query .= "power2_images = '{$p_power2_images}', ";
    $query .= "chord1_images = '{$p_chord1_images}', ";
    $query .= "chord2_images = '{$p_chord2_images}', ";
    $query .= "mother_images = '{$p_mother_images}', ";
    $query .= "cpu_images = '{$p_cpu_images}', ";
    $query .= "ram_images = '{$p_ram_images}', ";
    $query .= "video_images = '{$p_video_images}', ";
    $query .= "hddssdgb_images = '{$p_hddssdgb_images}', ";
    $query .= "date = '{$date}' ";
    $query .= "WHERE id = '{$product['id']}'"; 

    if (empty($errors)) {
        $result = $db->query($query);

        if ($result && $db->affected_rows() === 1) {
            redirect('product2.php?success=true&update_success=true', false);
        } else {
            $session->msg('d', 'Failed to update Computer.');
            redirect('product2main.php?id=' . (int)$product['id'], false);
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
          <span>Status Maintenance Computer</span>
        </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="product2main?id=<?php echo (int)$product['id'] ?>">
          <div class="form-group col-md-8 col-md-offset-2">
            <center><label for="Room-Title">Computer Barcode Photo</label></center>
            <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="computer_images">
                  <option>Maintenance</option>
                  <?php foreach ($all_computer as $photo): ?>
                    <option value="<?php echo (int)$photo['id']; ?>" <?php if($product['computer_images'] == $photo['id']) echo "selected"; ?>>
                      <?php echo $photo['file_name']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-md-4">
                <label for="Device-Category">Monitor Barcode Photo</label>
                <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="monitor_images">
                <option>Maintenance</option>
                  <?php foreach ($all_monitor as $photo): ?>
                    <option value="<?php echo (int)$photo['id']; ?>" <?php if($product['monitor_images'] == $photo['id']) echo "selected"; ?>>
                      <?php echo $photo['file_name']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-4">
                <label for="Device-Photo">Keyboard Barcode Photo</label>
                <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="keyboard_images">
                <option>Maintenance</option>
                  <?php foreach ($all_keyboard as $photo): ?>
                    <option value="<?php echo (int)$photo['id']; ?>" <?php if($product['keyboard_images'] == $photo['id']) echo "selected"; ?>>
                      <?php echo $photo['file_name']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-4">
                <label for="Device-Photo">Mouse Barcode Photo</label>
                <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="mouse_images">
                <option>Maintenance</option>
                  <?php foreach ($all_mouse as $photo): ?>
                    <option value="<?php echo (int)$photo['id']; ?>" <?php if($product['mouse_images'] == $photo['id']) echo "selected"; ?>>
                      <?php echo $photo['file_name']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-md-4">
                <label for="Device-Category">System Unit Barcode Photo</label>
                <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="system_images">
                <option>Maintenance</option>
                  <?php foreach ($all_system as $photo): ?>
                    <option value="<?php echo (int)$photo['id']; ?>" <?php if($product['system_images'] == $photo['id']) echo "selected"; ?>>
                      <?php echo $photo['file_name']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-4">
                <label for="Device-Photo">VGA|HDMI Barcode Photo</label>
                <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="vgahdmi_images">
                <option>Maintenance</option>
                  <?php foreach ($all_vgahdmi as $photo): ?>
                    <option value="<?php echo (int)$photo['id']; ?>" <?php if($product['vgahdmi_images'] == $photo['id']) echo "selected"; ?>>
                      <?php echo $photo['file_name']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-4">
                <label for="Device-Photo">Power Supply1 Barcode Photo</label>
                <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="power1_images">
                <option>Maintenance</option>
                  <?php foreach ($all_power1 as $photo): ?>
                    <option value="<?php echo (int)$photo['id']; ?>" <?php if($product['power1_images'] == $photo['id']) echo "selected"; ?>>
                      <?php echo $photo['file_name']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-md-4">
                <label for="Device-Category">Power Supply2 Barcode Photo</label>
                <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="power2_images">
                <option>Maintenance</option>
                  <?php foreach ($all_power2 as $photo): ?>
                    <option value="<?php echo (int)$photo['id']; ?>" <?php if($product['power2_images'] == $photo['id']) echo "selected"; ?>>
                      <?php echo $photo['file_name']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-4">
                <label for="Device-Photo">POWER CHORD1 Barcode Photo</label>
                <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="chord1_images">
                <option>Maintenance</option>
                  <?php foreach ($all_chord1 as $photo): ?>
                    <option value="<?php echo (int)$photo['id']; ?>" <?php if($product['chord1_images'] == $photo['id']) echo "selected"; ?>>
                      <?php echo $photo['file_name']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-4">
                <label for="Device-Photo">POWER CHORD2 Barcode Photo</label>
                <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="chord2_images">
                <option>Maintenance</option>
                  <?php foreach ($all_chord2 as $photo): ?>
                    <option value="<?php echo (int)$photo['id']; ?>" <?php if($product['chord2_images'] == $photo['id']) echo "selected"; ?>>
                      <?php echo $photo['file_name']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-md-4">
                <label for="Device-Category">Motherboard Barcode Photo</label>
                <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="mother_images">
                <option>Maintenance</option>
                  <?php foreach ($all_mother as $photo): ?>
                    <option value="<?php echo (int)$photo['id']; ?>" <?php if($product['mother_images'] == $photo['id']) echo "selected"; ?>>
                      <?php echo $photo['file_name']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-4">
                <label for="Device-Photo">CPU Barcode Photo</label>
                <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="cpu_images">
                <option>Maintenance</option>
                  <?php foreach ($all_cpu as $photo): ?>
                    <option value="<?php echo (int)$photo['id']; ?>" <?php if($product['cpu_images'] == $photo['id']) echo "selected"; ?>>
                      <?php echo $photo['file_name']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-4">
                <label for="Device-Photo">RAM Barcode Photo</label>
                <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="ram_images">
                <option>Maintenance</option>
                  <?php foreach ($all_ram as $photo): ?>
                    <option value="<?php echo (int)$photo['id']; ?>" <?php if($product['ram_images'] == $photo['id']) echo "selected"; ?>>
                      <?php echo $photo['file_name']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-md-4 col-md-offset-2">
                <label for="Device-Category">Video Card Barcode Photo</label>
                <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="video_images">
                <option>Maintenance</option>
                  <?php foreach ($all_video as $photo): ?>
                    <option value="<?php echo (int)$photo['id']; ?>" <?php if($product['video_images'] == $photo['id']) echo "selected"; ?>>
                      <?php echo $photo['file_name']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div> 
              <div class="col-md-4">
                <label for="Device-Photo">HDD|SSD|GB Barcode Photo</label>
                <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="hddssdgb_images">
                <option>Maintenance</option>
                  <?php foreach ($all_hddssdgb as $photo): ?>
                    <option value="<?php echo (int)$photo['id']; ?>" <?php if($product['hddssdgb_images'] == $photo['id']) echo "selected"; ?>>
                      <?php echo $photo['file_name']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>

          <center><div class="form-group">
            <button style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" type="submit" name="add_product" class="btn btn-primary">Update Computer</button>
            <a style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" href="product2.php" class="btn btn-danger">Cancel</a>
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
