<link rel="icon" type="image/x-icon" href="uploads/users/rizel.png">
<?php
// Start of PHP code

date_default_timezone_set('Asia/Manila');
$page_title = 'Add Product';
require_once('includes/load.php');




// Checking user permission to view page
page_require_level(2);

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
$all_categories = find_all('categories');

// Filter categories to include only "Computer"
$filtered_cat = array_filter($all_categories, function($cat) {
    return $cat['name'] == 'Computer';
});

$form_data = array(
    'computer_images' => isset($_POST['computer_images']) ? $_POST['computer_images'] : '',
    'monitor_images' => isset($_POST['monitor_images']) ? $_POST['monitor_images'] : '',
    'keyboard_images' => isset($_POST['keyboard_images']) ? $_POST['keyboard_images'] : '',
    'mouse_images' => isset($_POST['mouse_images']) ? $_POST['mouse_images'] : '',
    'system_images' => isset($_POST['system_images']) ? $_POST['system_images'] : '',
    'vgahdmi_images' => isset($_POST['vgahdmi_images']) ? $_POST['vgahdmi_images'] : '',
    'power1_images' => isset($_POST['power1_images']) ? $_POST['power1_images'] : '',
    'power2_images' => isset($_POST['power2_images']) ? $_POST['power2_images'] : '',
    'chord1_images' => isset($_POST['chord1_images']) ? $_POST['chord1_images'] : '',
    'chord2_images' => isset($_POST['chord2_images']) ? $_POST['chord2_images'] : '',
    'mother_images' => isset($_POST['mother_images']) ? $_POST['mother_images'] : '',
    'cpu_images' => isset($_POST['cpu_images']) ? $_POST['cpu_images'] : '',
    'ram_images' => isset($_POST['ram_images']) ? $_POST['ram_images'] : '',
    'video_images' => isset($_POST['video_images']) ? $_POST['video_images'] : '',
    'hddssdgb_images' => isset($_POST['hddssdgb_images']) ? $_POST['hddssdgb_images'] : '',
    'categorie_id' => isset($_POST['categorie_id']) ? $_POST['categorie_id'] : ''
);

if (isset($_POST['add_product'])) {
    $errors = array();
    $req_fields = array(
        'hddssdgb_images' => 'HDD|SSD|GB Barcode Photo',
        'video_images' => 'Video Card Barcode Photo',
        'ram_images' => 'RAM Barcode Photo',
        'cpu_images' => 'CPU Barcode Photo',
        'mother_images' => 'Motherboard Barcode Photo',
        'chord2_images' => 'POWER CHORD2 Barcode Photo',
        'chord1_images' => 'POWER CHORD1 Barcode Photo',
        'power2_images' => 'Power Supply2 Barcode Photo',
        'power1_images' => 'Power Supply1 Barcode Photo',
        'vgahdmi_images' => 'VGA|HDMI Barcode Photo',
        'system_images' => 'System Unit Barcode Photo',
        'mouse_images' => 'Mouse Barcode Photo',
        'keyboard_images' => 'Keyboard Barcode Photo',
        'monitor_images' => 'Monitor Barcode Photo',
        'computer_images' => 'Computer Barcode Photo',
        'categorie_id' => 'Category'
    );

    foreach ($req_fields as $field => $placeholder) {
        if (isset($_POST[$field]) && $_POST[$field] === '') {
            $errors[$field] = "{$placeholder} can't be blank.";
        }
    }

    if (empty($errors)) {
        $computer_images = is_null($_POST['computer_images']) || $_POST['computer_images'] === "" ? '0' : (int)$db->escape($_POST['computer_images']);
        $monitor_images = is_null($_POST['monitor_images']) || $_POST['monitor_images'] === "" ? '0' : (int)$db->escape($_POST['monitor_images']);
        $keyboard_images = is_null($_POST['keyboard_images']) || $_POST['keyboard_images'] === "" ? '0' : (int)$db->escape($_POST['keyboard_images']);
        $mouse_images = is_null($_POST['mouse_images']) || $_POST['mouse_images'] === "" ? '0' : (int)$db->escape($_POST['mouse_images']);
        $system_images = is_null($_POST['system_images']) || $_POST['system_images'] === "" ? '0' : (int)$db->escape($_POST['system_images']);
        $vgahdmi_images = is_null($_POST['vgahdmi_images']) || $_POST['vgahdmi_images'] === "" ? '0' : (int)$db->escape($_POST['vgahdmi_images']);
        $power1_images = is_null($_POST['power1_images']) || $_POST['power1_images'] === "" ? '0' : (int)$db->escape($_POST['power1_images']);
        $power2_images = is_null($_POST['power2_images']) || $_POST['power2_images'] === "" ? '0' : (int)$db->escape($_POST['power2_images']);
        $chord1_images = is_null($_POST['chord1_images']) || $_POST['chord1_images'] === "" ? '0' : (int)$db->escape($_POST['chord1_images']);
        $chord2_images = is_null($_POST['chord2_images']) || $_POST['chord2_images'] === "" ? '0' : (int)$db->escape($_POST['chord2_images']);
        $mother_images = is_null($_POST['mother_images']) || $_POST['mother_images'] === "" ? '0' : (int)$db->escape($_POST['mother_images']);
        $cpu_images = is_null($_POST['cpu_images']) || $_POST['cpu_images'] === "" ? '0' : (int)$db->escape($_POST['cpu_images']);
        $ram_images = is_null($_POST['ram_images']) || $_POST['ram_images'] === "" ? '0' : (int)$db->escape($_POST['ram_images']);
        $video_images = is_null($_POST['video_images']) || $_POST['video_images'] === "" ? '0' : (int)$db->escape($_POST['video_images']);
        $hddssdgb_images = is_null($_POST['hddssdgb_images']) || $_POST['hddssdgb_images'] === "" ? '0' : (int)$db->escape($_POST['hddssdgb_images']);
        $categorie_id = (int)$db->escape($_POST['categorie_id']); // Escape and cast category ID

        // Check if category ID exists
        $category_check_query = "SELECT id FROM categories WHERE id = '{$categorie_id}'";
        $result = $db->query($category_check_query);

        if ($result->num_rows == 0) {
            $session->msg('d', 'Invalid category ID!');
            header("Location: add1.php");
            exit();
        }

        // Updated INSERT query
        $query = "INSERT INTO products (computer_images, monitor_images, keyboard_images, mouse_images, system_images, vgahdmi_images, power1_images, power2_images, chord1_images, chord2_images, mother_images, cpu_images, ram_images, video_images, hddssdgb_images, categorie_id) VALUES ";
        $query .= "('{$computer_images}', '{$monitor_images}', '{$keyboard_images}', '{$mouse_images}', '{$system_images}', '{$vgahdmi_images}', '{$power1_images}', '{$power2_images}', '{$chord1_images}', '{$chord2_images}', '{$mother_images}', '{$cpu_images}', '{$ram_images}', '{$video_images}', '{$hddssdgb_images}', '{$categorie_id}')";

        if ($db->query($query)) {
            // Product added successfully
            header("Location: add1.php?success=true");
            exit();
        } else {
            // Failed to add product
            $session->msg('d', 'Failed to add product!');
            header("Location: add1.php");
            exit();
        }
    } else {
        // Convert errors array to JSON for JavaScript
        $js_error_msgs = json_encode($errors);
    }
}

// Get already used image IDs
$saved_image_ids = [];
$query = "SELECT DISTINCT computer_images, monitor_images, keyboard_images, mouse_images, system_images, vgahdmi_images, power1_images, power2_images, chord1_images, chord2_images, mother_images, cpu_images, ram_images, video_images, hddssdgb_images FROM products";
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

$all_computer = filter_options($all_computer, $saved_image_ids);
$all_monitor = filter_options($all_monitor, $saved_image_ids);
$all_keyboard = filter_options($all_keyboard, $saved_image_ids);
$all_mouse = filter_options($all_mouse, $saved_image_ids);
$all_system = filter_options($all_system, $saved_image_ids);
$all_vgahdmi = filter_options($all_vgahdmi, $saved_image_ids);
$all_power1 = filter_options($all_power1, $saved_image_ids);
$all_power2 = filter_options($all_power2, $saved_image_ids);
$all_chord1 = filter_options($all_chord1, $saved_image_ids);
$all_chord2 = filter_options($all_chord2, $saved_image_ids);
$all_mother = filter_options($all_mother, $saved_image_ids);
$all_cpu = filter_options($all_cpu, $saved_image_ids);
$all_ram = filter_options($all_ram, $saved_image_ids);
$all_video = filter_options($all_video, $saved_image_ids);
$all_hddssdgb = filter_options($all_hddssdgb, $saved_image_ids);

?>

<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-offset-2 col-md-8">
    <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span style="text-shadow: 2px 2px 2px rgba(0, 0, 0, 0.2);">Add New Computer Barcode</span>
        </strong>
      </div>
      <div class="panel-body">
        <div class="col-md-12">
        <form method="post" action="add1" class="clearfix">
        <div class="form-group col-md-offset-2">
                <div class="row">
                 <div class="col-md-8">
                 <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="categorie_id" required>
    <option value="">Select Category</option>
    <?php foreach ($filtered_cat as $category): ?>
    <option value="<?php echo (int)$category['id']; ?>" 
        <?php echo ($form_data['categorie_id'] == (int)$category['id'] || $category['name'] == 'Computer') ? 'selected' : ''; ?>>
        <?php echo $category['name']; ?>
    </option>
    <?php endforeach; ?>
</select>


                  </div>
                </div>
             </div>


        <div class="form-group">
               <div class="row">
                 <div class="col-md-6">
                 <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="computer_images">
    <option value="">Select Computer Barcode Photo</option>
    <?php foreach ($all_computer as $photo): ?>
    <option value="<?php echo (int)$photo['id']; ?>" <?php echo ($form_data['computer_images'] == (int)$photo['id']) ? 'selected' : ''; ?>>
        <?php echo $photo['file_name']; ?>
    </option>
    <?php endforeach; ?>
</select>
                  </div>
                  <div class="col-md-6">
                  <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="monitor_images">
    <option value="">Select Monitor Barcode Photo</option>
    <?php foreach ($all_monitor as $photo): ?>
    <option value="<?php echo (int)$photo['id']; ?>" <?php echo ($form_data['monitor_images'] == (int)$photo['id']) ? 'selected' : ''; ?>>
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
                 <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="keyboard_images">
    <option value="">Select Keyboard Barcode Photo</option>
    <?php foreach ($all_keyboard as $photo): ?>
    <option value="<?php echo (int)$photo['id']; ?>" <?php echo ($form_data['keyboard_images'] == (int)$photo['id']) ? 'selected' : ''; ?>>
        <?php echo $photo['file_name']; ?>
    </option>
    <?php endforeach; ?>
</select>
                  </div>
                  <div class="col-md-6">
                  <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="mouse_images">
    <option value="">Select Mouse Barcode Photo</option>
    <?php foreach ($all_mouse as $photo): ?>
    <option value="<?php echo (int)$photo['id']; ?>" <?php echo ($form_data['mouse_images'] == (int)$photo['id']) ? 'selected' : ''; ?>>
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
                 <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="system_images">
    <option value="">Select System Unit Barcode Photo</option>
    <?php foreach ($all_system as $photo): ?>
    <option value="<?php echo (int)$photo['id']; ?>" <?php echo ($form_data['system_images'] == (int)$photo['id']) ? 'selected' : ''; ?>>
        <?php echo $photo['file_name']; ?>
    </option>
    <?php endforeach; ?>
</select>
                  </div>
                  <div class="col-md-6">
                  <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="vgahdmi_images">
    <option value="">Select VGA|HDMI Barcode Photo</option>
    <?php foreach ($all_vgahdmi as $photo): ?>
    <option value="<?php echo (int)$photo['id']; ?>" <?php echo ($form_data['vgahdmi_images'] == (int)$photo['id']) ? 'selected' : ''; ?>>
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
                 <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="power1_images">
    <option value="">Select Power Supply1 Barcode Photo</option>
    <?php foreach ($all_power1 as $photo): ?>
    <option value="<?php echo (int)$photo['id']; ?>" <?php echo ($form_data['power1_images'] == (int)$photo['id']) ? 'selected' : ''; ?>>
        <?php echo $photo['file_name']; ?>
    </option>
    <?php endforeach; ?>
</select>
                  </div>
                  <div class="col-md-6">
                  <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="power2_images">
    <option value="">Select Power Supply2 Barcode Photo</option>
    <?php foreach ($all_power2 as $photo): ?>
    <option value="<?php echo (int)$photo['id']; ?>" <?php echo ($form_data['power2_images'] == (int)$photo['id']) ? 'selected' : ''; ?>>
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
                 <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="chord1_images">
    <option value="">Select POWER CHORD1 Barcode Photo</option>
    <?php foreach ($all_chord1 as $photo): ?>
    <option value="<?php echo (int)$photo['id']; ?>" <?php echo ($form_data['chord1_images'] == (int)$photo['id']) ? 'selected' : ''; ?>>
        <?php echo $photo['file_name']; ?>
    </option>
    <?php endforeach; ?>
</select>
                  </div>
                  <div class="col-md-6">
                  <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="chord2_images">
    <option value="">Select POWER CHORD2 Barcode Photo</option>
    <?php foreach ($all_chord2 as $photo): ?>
    <option value="<?php echo (int)$photo['id']; ?>" <?php echo ($form_data['chord2_images'] == (int)$photo['id']) ? 'selected' : ''; ?>>
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
                 <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="mother_images">
    <option value="">Select Motherboard Barcode Photo</option>
    <?php foreach ($all_mother as $photo): ?>
    <option value="<?php echo (int)$photo['id']; ?>" <?php echo ($form_data['mother_images'] == (int)$photo['id']) ? 'selected' : ''; ?>>
        <?php echo $photo['file_name']; ?>
    </option>
    <?php endforeach; ?>
</select>
                  </div>
                  <div class="col-md-6">
                  <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="cpu_images">
    <option value="">Select CPU Barcode Photo</option>
    <?php foreach ($all_cpu as $photo): ?>
    <option value="<?php echo (int)$photo['id']; ?>" <?php echo ($form_data['cpu_images'] == (int)$photo['id']) ? 'selected' : ''; ?>>
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
                 <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="ram_images">
    <option value="">Select RAM Barcode Photo</option>
    <?php foreach ($all_ram as $photo): ?>
    <option value="<?php echo (int)$photo['id']; ?>" <?php echo ($form_data['ram_images'] == (int)$photo['id']) ? 'selected' : ''; ?>>
        <?php echo $photo['file_name']; ?>
    </option>
    <?php endforeach; ?>
</select>
                  </div>
                  <div class="col-md-6">
                  <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="video_images">
    <option value="">Select Video Card Barcode Photo</option>
    <?php foreach ($all_video as $photo): ?>
    <option value="<?php echo (int)$photo['id']; ?>" <?php echo ($form_data['video_images'] == (int)$photo['id']) ? 'selected' : ''; ?>>
        <?php echo $photo['file_name']; ?>
    </option>
    <?php endforeach; ?>
</select>
                 </div>
                </div>
             </div>

             <div class="form-group col-md-offset-2">
                <div class="row">
                 <div class="col-md-8">
                 <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="hddssdgb_images">
    <option value="">Select HDD|SSD|GB Barcode Photo</option>
    <?php foreach ($all_hddssdgb as $photo): ?>
    <option value="<?php echo (int)$photo['id']; ?>" <?php echo ($form_data['hddssdgb_images'] == (int)$photo['id']) ? 'selected' : ''; ?>>
        <?php echo $photo['file_name']; ?>
    </option>
    <?php endforeach; ?>
</select>
                  </div>
                </div>
             </div>




            <center><div class="form-group">
              <button style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" type="submit" name="add_product" class="btn btn-primary">Add Computer</button>
            </div></center>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>

<script src="sweetalert.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize datepicker
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        endDate: new Date(),
        todayHighlight: true
    });

    // Disable typing in datepicker field
    $('.datepicker').keydown(function(e) {
        e.preventDefault();
        return false;
    });

    const urlParams = new URLSearchParams(window.location.search);
    const successParam = urlParams.get('success');
    if (successParam === 'true') {
        swal("", "Computer added successfully", "success")
            .then((value) => {
                window.location.href = 'add1.php';
            });
    }

    <?php if (!empty($js_error_msgs)): ?>
        const errors = <?php echo $js_error_msgs; ?>;
        Object.keys(errors).forEach(function(key) {
            // You can display the error messages here
            swal("", errors[key], "error");
        });
    <?php endif; ?>
});
</script>
