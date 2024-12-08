<link rel="icon" type="image/x-icon" href="uploads/users/rizel.png">
<?php
date_default_timezone_set('Asia/Manila');
  $page_title = 'Edit User';
  require_once('includes/load.php');
   page_require_level(1);
?>

<?php
  $e_user = find_by_id('users',(int)$_GET['id']);
  $groups  = find_all('user_groups');
  if(!$e_user){
    $session->msg("d","Missing user id.");
    redirect('users.php');
  }
?>
<?php

  if(isset($_POST['update'])) {
    $req_fields = array('name','phone','username','level');
    validate_fields($req_fields);
    if(empty($errors)){
             $id = (int)$e_user['id'];
          $name = remove_junk($db->escape($_POST['name']));
          $username = remove_junk($db->escape($_POST['username']));
          $phone = remove_junk($db->escape($_POST['phone']));
          $level = (int)$db->escape($_POST['level']);
          $status   = remove_junk($db->escape($_POST['status']));
          $sql = "UPDATE users SET name ='{$name}', username ='{$username}', phone ='{$phone}',user_level='{$level}',status='{$status}' WHERE id='{$db->escape($id)}'";
          $result = $db->query($sql);
          if($result && $db->affected_rows() === 1){
            $session->msg('s',"Acount Updated ");
            redirect('edit_user.php?id='.(int)$e_user['id'], false);
          } else {
            $session->msg('d',' Sorry failed to updated!');
            redirect('edit_user.php?id='.(int)$e_user['id'], false);
          }
    } else {
      $session->msg("d", $errors);
      redirect('edit_user.php?id='.(int)$e_user['id'],false);
    }
  }
?>
<?php

if(isset($_POST['update-pass'])) {
  $req_fields = array('password');
  validate_fields($req_fields);
  if(empty($errors)){
           $id = (int)$e_user['id'];
     $password = remove_junk($db->escape($_POST['password']));
     $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
          $sql = "UPDATE users SET password='{$password}' WHERE id='{$db->escape($id)}'";
       $result = $db->query($sql);
        if($result && $db->affected_rows() === 1){
          $session->msg('s',"User password has been updated ");
          redirect('edit_user.php?id='.(int)$e_user['id'], false);
        } else {
          $session->msg('d',' Sorry failed to updated user password!');
          redirect('edit_user.php?id='.(int)$e_user['id'], false);
        }
  } else {
    $session->msg("d", $errors);
    redirect('edit_user.php?id='.(int)$e_user['id'],false);
  }
}

?>
<?php include_once('layouts/header.php'); ?>
 <div class="row">
   <div class="col-md-12"> <?php echo display_msg($msg); ?> </div>
  <div class="col-md-6">
     <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="panel panel-default">
       <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          Update <?php echo remove_junk(ucwords($e_user['name'])); ?> Account
        </strong>
       </div>
       <div class="panel-body">
          <form method="post" action="edit_user?id=<?php echo (int)$e_user['id'];?>" class="clearfix">
            <div class="form-group">
                  <label for="name" class="control-label">Name</label>
                  <input id="name" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" type="name" class="form-control" name="name" value="<?php echo remove_junk(ucwords($e_user['name'])); ?>">
            </div>
            <div class="form-group">
                  <label for="username" class="control-label">Username</label>
                  <input id="username" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" type="text" class="form-control" name="username" value="<?php echo remove_junk(ucwords($e_user['username'])); ?>">
            </div>
            <div class="form-group">
                  <label for="phone" class="control-label">Number</label>
                  <input oninput="validatephoneInput(event)" id="phone" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" type="tel" maxlength="11" class="form-control" name="phone" value="<?php echo remove_junk(ucwords($e_user['phone'])); ?>">
            </div>
            <div class="form-group">
              <label for="level">User Role</label>
                <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="form-control" name="level">
                  <?php foreach ($groups as $group ):?>
                   <option <?php if($group['group_level'] === $e_user['user_level']) echo 'selected="selected"';?> value="<?php echo $group['group_level'];?>"><?php echo ucwords($group['group_name']);?></option>
                <?php endforeach;?>
                </select>
            </div>
            <!-- <div class="form-group">
              <label for="status">Status</label>
                <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="form-control" name="status">
                  <option <?php if($e_user['status'] === '1') echo 'selected="selected"';?>value="1">Active</option>
                  <option <?php if($e_user['status'] === '0') echo 'selected="selected"';?> value="0">Deactive</option>
                </select>
            </div> -->
            <div class="form-group clearfix">
                    <button style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" type="submit" name="update" class="btn btn-info">Update</button>
            </div>
        </form>
       </div>
     </div>
  </div>
  <div class="col-md-6">
    <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="panel panel-default">
      <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          Change <?php echo remove_junk(ucwords($e_user['name'])); ?> password
        </strong>
      </div>
      <div class="panel-body">
        <form action="edit_user?id=<?php echo (int)$e_user['id'];?>" method="post" class="clearfix">
          <div class="form-group">
                <label for="password" class="control-label">Password</label>
                <input id="password" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" type="password" class="form-control" name="password" placeholder="Type user new password">
          </div>
          <div class="form-group clearfix">
                  <button style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" type="submit" name="update-pass" class="btn btn-danger pull-right">Change</button>
          </div>
        </form>
      </div>
    </div>
  </div>

 </div>
 <script>
    function validatephoneInput(event) {
        let inputValue = event.target.value;
        inputValue = inputValue.replace(/[^0-9]/g, '');
        event.target.value = inputValue;
    }
</script>
<script>
document.querySelector('form').addEventListener('submit', function(event) {
    const password = document.getElementById('password').value;
    const phone = document.getElementById('phone').value;

    if (password && password.length < 8) {
        event.preventDefault(); 
        swal("Error", "Password must be at least 8 characters.", "error");
    }
    
    if (phone && phone.length !== 11) {
        event.preventDefault(); 
        swal("Error", "Please ensure the phone number is exactly 11 digits.", "error");
    }
});
</script>
 <script src="sweetalert.min.js"></script>
<script>
    function detectXSS(inputField, fieldName) {
        const symbolPattern = /[^a-zA-Z0-9]/;
        const xssPattern = /[<>:\/\$\;\,\?\!]/;
        inputField.addEventListener('input', function() {
            if (xssPattern.test(this.value)) {
                swal("XSS Detected", `Please avoid using script tags in your ${fieldName}.`, "error");
                this.value = "";
            }
            if (fieldName === 'Password' && symbolPattern.test(this.value)) {
                swal("Invalid Input", `Please avoid using symbols in your ${fieldName}.`, "error");
                this.value = "";
            }
        });
    }
    const nameInput = document.getElementById('name');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    detectXSS(nameInput, 'Name');
    detectXSS(usernameInput, 'Username');
    detectXSS(passwordInput, 'Password');

</script>
<script>
document.querySelector('form').addEventListener('submit', function(event) {
    const password = document.getElementById('password').value;
    const phone = document.getElementById('phone').value;

    if (password && password.length < 8) {
        event.preventDefault(); 
        swal("Error", "Password must be at least 8 characters.", "error");
        return; 
    }

    if (phone && phone.length !== 11) {
        event.preventDefault(); 
        swal("Error", "Please ensure the phone number is exactly 11 digits.", "error");
        return; 
    }
});
</script>
<?php include_once('layouts/footer.php'); ?>