<link rel="icon" type="image/x-icon" href="uploads/users/rizel.png">
<?php
date_default_timezone_set('Asia/Manila');
$page_title = 'Edit Account';
require_once('includes/load.php');
page_require_level(3);

function find_by_name($name, $exclude_id = null) {
    global $db;
    $name = $db->escape($name);
    $query = "SELECT * FROM users WHERE name = '{$name}'";
  
    if ($exclude_id) {
        $exclude_id = (int)$exclude_id;
        $query .= " AND id != {$exclude_id}";
    }
  
    $query .= " LIMIT 1";
    $result = $db->query($query);
    return $db->fetch_assoc($result);
  }

function find_by_username($username, $exclude_id = null) {
    global $db;
    $username = $db->escape($username);
    $query = "SELECT * FROM users WHERE username = '{$username}'";
  
    if ($exclude_id) {
        $exclude_id = (int)$exclude_id;
        $query .= " AND id != {$exclude_id}";
    }
  
    $query .= " LIMIT 1";
    $result = $db->query($query);
    return $db->fetch_assoc($result);
  }

  function find_by_phone($phone, $exclude_id = null) {
    global $db;
    $phone = $db->escape($phone);
    $query = "SELECT * FROM users WHERE phone = '{$phone}'";
  
    if ($exclude_id) {
        $exclude_id = (int)$exclude_id;
        $query .= " AND id != {$exclude_id}";
    }
  
    $query .= " LIMIT 1";
    $result = $db->query($query);
    return $db->fetch_assoc($result);
  }



if(isset($_POST['submit'])) {
  if(empty($_FILES['file_upload']['name'])) {
      $js_error_msgs[] = "No file was uploaded";
  } else {
    
      $photo = new Media();
      $user_id = (int)$_POST['user_id'];
      $photo->upload($_FILES['file_upload']);
      if($photo->process_user($user_id)){
          $session->msg('s','Photo has been uploaded.');
          redirect('edit_account.php?success=true'); // Add success parameter to URL
      } else {
          $session->msg('d',join($photo->errors));
          redirect('edit_account.php');
      }
  }
}
if (isset($_SESSION['user_id'])) {
    $user_id = (int)$_SESSION['user_id'];
    $user = find_by_id('users', $user_id); // Fetch user data
} else {

    header('Location: edit_account.php');
    exit;
}

if(isset($_POST['update'])){
  $req_fields = array('name', 'username', 'phone');
  validate_fields($req_fields);
  
    if (empty($errors)) {
     if (isset($_POST['name']) && !empty($_POST['name'])) {
        $existing_name = find_by_name($_POST['name'], $user['id']);
        if ($existing_name) {
            $errors[] = "Name '{$_POST['name']}' Already Exists.";
            $js_error_msgs['name'] = $errors[count($errors) - 1];
             }
        } else {
              $js_error_msgs[] = "Name is required.";
        }
    }

    if (empty($errors)) {
        if (isset($_POST['username']) && !empty($_POST['username'])) {
           $existing_username = find_by_username($_POST['username'], $user['id']);
           if ($existing_username) {
               $errors[] = "Email '{$_POST['username']}' Already Exists.";
               $js_error_msgs['username'] = $errors[count($errors) - 1];
                }
           } else {
                 $js_error_msgs[] = "Username is required.";
           }
    }
 
    if (empty($errors)) {
        if (isset($_POST['phone']) && !empty($_POST['phone'])) {
           $existing_phone = find_by_phone($_POST['phone'], $user['id']);
           if ($existing_phone) {
               $errors[] = "Number '{$_POST['phone']}' Already Exists.";
               $js_error_msgs['phone'] = $errors[count($errors) - 1];
                }
           } else {
                 $js_error_msgs[] = "Number is required.";
           }
       }

  if(empty($errors)){
      $id = (int)$_SESSION['user_id'];
      $name = remove_junk($db->escape($_POST['name']));
      $username = remove_junk($db->escape($_POST['username']));
      $phone = remove_junk($db->escape($_POST['phone']));
      
      // Check if either name or username is empty
      if(empty($name) || empty($username)) {
          $js_error_msgs[] = "Name and Username can't be blank.";
      } else {
          // Always attempt to update, regardless of changes
          $sql = "UPDATE users SET name ='{$name}', username ='{$username}', phone ='{$phone}' WHERE id='{$id}'";
          $result = $db->query($sql);
          
          if($result && $db->affected_rows() >= 0){ // Check for any rows affected
              $session->msg('s',"Account updated");
              redirect('edit_account.php?update_success=true'); // Add update_success parameter to URL
          } else {
              $session->msg('d','Sorry failed to update!');
              redirect('edit_account.php');
          }
      }
  } else {
      // If validation errors exist, add to $js_error_msgs
      if(empty($_POST['name'])) {
          $js_error_msgs[] = "Name can't be blank.";
      }
      if(empty($_POST['username'])) {
          $js_error_msgs[] = "Username can't be blank.";
      }
  }
}

?>
<link rel="icon" type="image/x-icon" href="uploads/users/rizel.png">
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="col-md-6">
      <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="panel panel-default">
        <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="panel-heading">
          <div class="panel-heading clearfix">
            <span class="glyphicon glyphicon-camera"></span>
            <span>Change My photo</span>
          </div>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-md-4">
                <img class="img-circle img-size-2" src="uploads/users/<?php echo $user['image'];?>" alt="">
            </div>
            <div class="col-md-8">
              <form class="form" action="edit_account" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <input style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" type="file" name="file_upload" multiple="multiple" class="btn btn-default btn-file"/>
              </div>
              <div class="form-group">
                <input style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" type="hidden" name="user_id" value="<?php echo $user['id'];?>">
                 <button style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" type="submit" name="submit" class="btn btn-warning">Change</button>
              </div>
             </form>
            </div>
          </div>
        </div>
      </div>
  </div>
  <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="col-md-6">
    <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="panel panel-default">
      <div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="panel-heading clearfix">
        <span class="glyphicon glyphicon-edit"></span>
        <span>Edit My Account</span>
      </div>
      <div class="panel-body">
          <form method="post" action="edit_account?id=<?php echo (int)$user['id'];?>" class="clearfix">
            <div class="form-group">
                  <label for="name" class="control-label">Name</label>
                  <input style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" type="name" class="form-control" id="name" name="name" value="<?php echo remove_junk(ucwords($user['name'])); ?>">
            </div>
            <div class="form-group">
                  <label for="username" class="control-label">Username</label>
                  <input style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" type="text" class="form-control" id="username" name="username" value="<?php echo remove_junk(ucwords($user['username'])); ?>">
            </div>
            <div class="form-group">
    <label for="phone" class="control-label">Number</label>
    <input oninput="validatephoneInput(event)" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" type="tel" maxlength="11" class="form-control" id="phone" name="phone" value="<?php echo remove_junk(ucwords($user['phone'])); ?>">
</div>
            <div class="form-group clearfix">
                    <a href="change_password.php" title="change password" class="btn btn-danger pull-right">Change Password</a>
                    <button title="Number must be at least 11 digits" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" type="submit" name="update" class="btn btn-info">Update</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>


<?php include_once('layouts/footer.php'); ?>

<script>
    function validatephoneInput(event) {
        let inputValue = event.target.value;
        inputValue = inputValue.replace(/[^0-9]/g, ''); 
        event.target.value = inputValue;
        
        toggleUpdateButton(inputValue);
    }

    function toggleUpdateButton(inputValue) {
        const updateButton = document.querySelector('button[name="update"]');
        if (inputValue.length === 11) {
            updateButton.disabled = false; 
        } else {
            updateButton.disabled = true;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const phoneInput = document.getElementById('phone');
        toggleUpdateButton(phoneInput.value); 
    });
</script>

<script src="sweetalert.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    function handleSuccessMessage(message) {
        swal("", message, "success");
    }

    const urlParams = new URLSearchParams(window.location.search);
    const successParam = urlParams.get('success');
    if (successParam === 'true') {
        handleSuccessMessage("Photo has been uploaded.");
    }

    const updateSuccessParam = urlParams.get('update_success');
    if (updateSuccessParam === 'true') {
        handleSuccessMessage("Account updated.");
    }
});
</script>

<?php if (!empty($js_error_msgs)): ?>
  <script src="sweetalert.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            swal({
                title: "",
                text: "<?php echo $js_error_msgs[0]; ?>",
                icon: "warning",
                dangerMode: true
            });
        });
    </script>
<?php endif; ?>
<?php if (!empty($js_error_msgs)): ?>
  <script src="sweetalert.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            swal({
                title: "",
                text: "<?php echo implode("\n", $js_error_msgs); ?>",
                icon: "warning",
                dangerMode: true
            });
        });
    </script>
<?php endif; ?>
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
    const nameInput = document.getElementById('name');
    const usernameInput = document.getElementById('username');
    detectXSS(nameInput, 'Name');
    detectXSS(usernameInput, 'Username');
</script>
