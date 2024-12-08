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
$all_other_images = find_all('other_images');
// Get IDs of images already saved in the database for this product
$saved_images = [
    'other_images' => $product['other_images'],
];


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
        redirect('product7view.php?success=true&update_success=true', false);
    } else {
        $session->msg('d', 'Failed to update Other Device.');
        redirect('product7view.php?id=' . (int)$product['id'], false);
    }
}
}



include_once('layouts/header.php');
?>
<center><h1>Peripheral Devices View</h1></center>
<br><br><br>
<form method="post" action="product7view?id=<?php echo (int)$product['id']; ?>">
    <div class="container col-md-offset-5">
        <div class="row custom-gutter">
            <div class="col-md-2 col-6 mb-3">
                <center><label for="other_images" class="d-block">Other Image</label></center>
                <div class="img-container">
                    <?php
                    // Check if other_images is set and not empty
                    if (!empty($saved_images['other_images']) && $saved_images['other_images'] != '0') {
                        $saved_image_id = $saved_images['other_images'];
                        echo "<!-- Saved Image ID for Other Image: $saved_image_id -->"; // Debugging info
                        foreach ($all_other_images as $photo) {
                            echo "<!-- Photo ID: {$photo['id']} File Name: {$photo['file_name']} -->"; // Debugging info
                            if ($photo['id'] == $saved_image_id) {
                                echo '<img class="img-thumbnail selected" 
                                      src="uploads/products/' . $photo['file_name'] . '" 
                                      alt="' . $photo['file_name'] . '" 
                                      onclick="selectImage(\'' . $photo['id'] . '\', \'other_images\')">';
                            }
                        }
                    } else {
                        echo '<img class="img-thumbnail" src="uploads/products/no_image.png" alt="No Image Available">';
                    }
                    ?>
                </div>
                <input type="hidden" id="other_images" name="other_images" value="<?php echo (int)$saved_images['other_images']; ?>">
            </div>
        </div>
    </div>
</form>
</form>
        <form method="post" action="product7view?id=<?php echo (int)$product['id'] ?>">
          <div class="form-group col-md-8 col-md-offset-2">
            <label for="Room-Title">Room Title</label>
            <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="Room-Title" disabled>
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
                <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="Device-Category" disabled>
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
                <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" class="form-control" name="Device-Photo" disabled>
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
                     <input style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" type="text" class="form-control" name="donate" disabled value="<?php echo remove_junk($product['donate']);?>">
                 </div>
                 <div class="col-md-6">
    <label for="Device-Photo">Date Received</label>
    <input style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4); pointer-events: none;" type="text" class="form-control datepicker" name="dreceived" required readonly value="<?php echo remove_junk($product['dreceived']);?>">
</div>
               </div>
          </div>

          <div class="form-group">
               <div class="row">
                 <div class="col-md-6">
                     <label for="Device-Photo">Serial Num.</label>
                     <input style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" type="text" class="form-control" name="serial" readonly value="<?php echo remove_junk($product['serial']);?>">
                 </div>
                 <div class="col-md-6">
                     <label for="Device-Photo">Recieved By</label>
                     <input style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" type="text" class="form-control" name="recievedby" readonly value="<?php echo remove_junk($product['recievedby']);?>">
                 </div>
               </div>
               
          </div>
          <br><br>     
          <center><div class="form-group">
            <a style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" href="product7.php" class="btn btn-danger">Back</a>
          </div></center>

        </form>

        



<?php include_once('layouts/footer.php'); ?>