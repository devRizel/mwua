<link rel="icon" type="image/x-icon" href="uploads/users/rizel.png">
<?php
date_default_timezone_set('Asia/Manila');
  $page_title = 'All User';
  require_once('includes/load.php');
?>
<?php
// Checkin What level user has permission to view this page
 page_require_level(1);
//pull out all user form database
 $all_users = find_all_user();
?>


<?php include_once('layouts/header.php'); ?>
<div class="row">
   <div class="col-md-12">
     <?php echo display_msg($msg); ?>
   </div>
</div>
<div class="row">
  <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="col-md-12">
    <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="panel panel-default">
      <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span style="text-shadow: 2px 2px 2px rgba(0, 0, 0, 0.2);">Users</span>
       </strong>
         <a href="add_user.php"  style=" border-radius: 50% 10% 50% 10% / 10% 50% 10% 50%; box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="btn btn-info pull-right">Add New User</a>
      </div>
     <div class="panel-body">
      <table style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th class="text-center" style="width: 50px;">#</th>
            <th>Name </th>
            <th>Username</th>
            <th class="text-center" style="width: 15%;">User Role</th>
            <!-- <th class="text-center" style="width: 10%;">Status</th> -->
            <th style="width: 20%;">Last Login</th>
            <!-- <th class="text-center" style="width: 100px;">Actions</th> -->
          </tr>
        </thead>
        <tbody>
          <?php foreach($all_users as $a_user): ?>
            <?php if ($a_user['name'] === 'Rizel Bracero') continue;?>
          <tr>
           <td class="text-center"><?php echo count_id();?></td>
           <td><?php echo remove_junk(ucwords($a_user['name']))?></td>
           <td><?php echo remove_junk(ucwords($a_user['username']))?></td>
           <td class="text-center"><?php echo remove_junk(ucwords($a_user['group_name']))?></td>
           <!-- <td class="text-center">
           <?php if($a_user['status'] === '1'): ?>
            <span class="label label-success"><?php echo "Active"; ?></span>
          <?php else: ?>
            <span class="label label-danger"><?php echo "Deactive"; ?></span>
          <?php endif;?>
           </td> -->
           <td><?php echo read_date($a_user['last_login'])?></td>

           <td class="text-center">
  <div class="btn-group">
    <?php if (remove_junk(ucfirst($user['name'])) === 'Rizel Bracero'): ?>
      <a href="edit_user.php?id=<?php echo (int)$a_user['id'];?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit">
        <i class="glyphicon glyphicon-pencil"></i>
      </a>
      <a href="delete_user.php?id=<?php echo (int)$a_user['id'];?>" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Remove">
        <i class="glyphicon glyphicon-remove"></i>
      </a>
    <?php endif; ?>
  </div>
</td>

          </tr>
        <?php endforeach;?>
       </tbody>
     </table>
     </div>
    </div>
  </div>
</div>
  <?php include_once('layouts/footer.php'); ?>
