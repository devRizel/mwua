<link rel="icon" type="image/x-icon" href="uploads/users/rizel.png">
<?php
date_default_timezone_set('Asia/Manila');
$page_title = 'Edit Computer';
require_once('includes/load.php');
// Checking what level user has permission to view this page
page_require_level(2);




$form_data = array(
  'barrow' => isset($_POST['barrow']) ? $_POST['barrow'] : '',
  'datebarrowed' => isset($_POST['datebarrowed']) ? $_POST['datebarrowed'] : '',
  'datereturn' => isset($_POST['datereturn']) ? $_POST['datereturn'] : ''
);
$product = find_by_id('other', (int)$_GET['id']);
if (!$product) {
    $session->msg("d", "Missing product id.");
    redirect('barrowother.php');
}

$errors = array();
$js_error_msgs = array();
if (isset($_POST['add_product'])) {
    $field_messages = array(
        'barrow' => 'Barrow By',
        'datebarrowed' => 'Date Barrowed',
        'datereturn' => 'Date Return'
    );

    $req_fields = array('barrow', 'datebarrowed', 'datereturn');

    foreach ($req_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = isset($field_messages[$field]) ? $field_messages[$field] . " can't be blank." : ucfirst(str_replace('-', ' ', $field)) . " is required.";
            $js_error_msgs[$field] = $errors[$field];
        }
    }
// Validate date received
if (empty($_POST['datebarrowed'])) {
  $errors['dreceived'] = "Date Barrowed can't be blank.";
  $js_error_msgs['datebarrowed'] = $errors['dreceived'];
} else {
  $p_datebarrowed = $_POST['datebarrowed'];
  $today = new DateTime();  // Current date and time
  $selected_date = new DateTime($p_datebarrowed);  

  if ($selected_date > $today) {
      $errors['datebarrowed'] = "Date Barrowed cannot be a future date.";
      $js_error_msgs['datebarrowed'] = $errors['datebarrowed'];
  }
}


    if (empty($errors)) {
      $p_barrow = remove_junk($db->escape($_POST['barrow']));
      $p_datebarrowed = make_date(); 
      $p_datereturn = make_date(); 

      $query = "UPDATE other SET barrow = '{$p_barrow}', datebarrowed = '{$p_datebarrowed}',datereturn = '{$p_datereturn}' WHERE id = '{$product['id']}'";
      $result = $db->query($query);

        if ($result && $db->affected_rows() === 1) {
            redirect('barrowother.php?success=true&update_success=true', false);
        } else {
            $session->msg('d', 'Failed to update Computer.');
            redirect('barrowotherbarrowedit.php?id=' . (int)$product['id'], false);
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
          <span>Peripheral Devices Barrow</span>
        </strong>
      </div>
      <div class="panel-body">
        <form method="post" class="clearfix" action="barrowotherbarrowedit?id=<?php echo (int)$product['id'] ?>" >
          <div class="form-group col-md-12 col-md-offset-2">
            <div class="row">
              <div class="col-md-8">
                <center><label>Barrow By</label></center>
                <input id="a" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);" type="text" class="form-control" name="barrow"  value="<?php echo htmlspecialchars($form_data['barrow']); ?>">
              </div>
            </div>
          </div>

          <div class="form-group col-md-offset-2">
               <div class="row">
               <div class="col-md-5">
                <center><label>Date Barrowed</label></center>
                <input type="text" class="form-control datepicker" name="datebarrowed" placeholder="Date Barrowed" required readonly value="<?php echo htmlspecialchars($form_data['datebarrowed']); ?>">
              </div>
              <div class="col-md-5">
                <center><label>Date Return</label></center>
                <input type="text" class="form-control datepicker" name="datereturn" placeholder="Date Return" required readonly value="<?php echo htmlspecialchars($form_data['datereturn']); ?>">
              </div>
               </div>
          </div>

          <center><div class="form-group">
            <button style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" type="submit" name="add_product" class="btn btn-primary">Update Computer</button>
            <a style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" href="barrowother.php" class="btn btn-danger">Cancel</a>
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
        var errorMessages = Object.values(<?php echo json_encode($js_error_msgs); ?>).join('\n');
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
    const aInput = document.getElementById('a');
    detectXSS(aInput, 'Barrow By');

</script>