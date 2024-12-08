<link rel="icon" type="image/x-icon" href="uploads/users/rizel.png">

<?php
if (!isset($_GET['access']) || $_GET['access'] !== 'allowed') {
    header("Location: index.html");
    exit();
}
?>
<?php
date_default_timezone_set('Asia/Manila');
$page_title_room = 'Delete Chat';
require_once('includes/load.php');

$all_rooms = find_all_desc('users');

function find_all_desc($table) {
  global $db;
  $sql = "SELECT * FROM {$table} ORDER BY id DESC";
  return find_by_sql($sql);
}

?>

<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-7 col-md-offset-1">
    <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="panel panel-default">
      <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="panel-heading">
        <center><strong>Session</strong></center>
      </div>
      <div class="panel-body">
      <form method="POST" action="autouser">
    <table style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
               <th class="text-center" style="width: 50px;">#</th>
                <th>Email</th>
                <th>Session</th>
                <th class="text-center" style="width: 100px;">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
              $counter = 1; 
              foreach  ($all_rooms as $room):
              ?>
              <tr>
                <td class="text-center"><?php echo $counter; ?></td>
                    <td><?php echo remove_junk(ucfirst($room['username'])); ?></td>
                    <td><?php echo remove_junk(ucfirst($room['session_id'])); ?></td>
                    <td class="text-center">
                        <div class="btn-group">
                            <a href="autouser2.php?id=<?php echo (int)$room['id'];?>" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Remove">
                                <span class="glyphicon glyphicon-trash"></span>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php 
    $counter++;
endforeach; 
?>
        </tbody>
    </table>
</form>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>
<?php if (isset($js_error_msgs)): ?>
  <script src="sweetalert.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
        var errorMessages = <?php echo $js_error_msgs; ?>;
        errorMessages.forEach(function(msg) {
            swal({
                title: "",
                text: msg,
                icon: "warning",
                dangerMode: true
            });
        });
    });
  </script>
<?php endif; ?>

<script src="sweetalert.min.js"></script>
<script>
const urlParams = new URLSearchParams(window.location.search);
const successParam = urlParams.get('success');

if (successParam === 'true') {
    let successMessage = "";
    if (urlParams.get('delete_room')) {
        successMessage = "Session Deleted.";
    }
    
    swal("", successMessage, "success")
        .then((value) => {
          window.location.href = href;
        });
}

// Select All Checkbox Functionality
document.getElementById('select-all').addEventListener('click', function(event) {
  var checkboxes = document.querySelectorAll('.room-checkbox');
  checkboxes.forEach(function(checkbox) {
    checkbox.checked = event.target.checked;
  });
});
</script>
<style>
      body {
    background: url('uploads/users/riz.png');
    background-size: cover; 
    background-position: center; 
}
</style>
<?php include_once('layouts/recapt.php'); ?>