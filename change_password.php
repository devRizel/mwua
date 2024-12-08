<link rel="icon" type="image/x-icon" href="uploads/users/rizel.png">
<?php
date_default_timezone_set('Asia/Manila');
$page_title = 'Change Password';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(3);
?>


<?php $user = current_user(); ?>
<?php
if(isset($_POST['update'])) {

    $req_fields = array('newpassword', 'confirmpassword', 'oldpassword', 'id');
    validate_fields($req_fields);

    if(empty($errors)) {
        $new_password = remove_junk($db->escape($_POST['newpassword']));
        $confirm_password = remove_junk($db->escape($_POST['confirmpassword']));

        if($new_password !== $confirm_password) {
            $session->msg('d', "New password and confirmation password do not match");
            redirect('change_password.php', false);
        }

        // Verify the old password using password_verify
        if(!password_verify($_POST['oldpassword'], $user['password'])) {
            $session->msg('d', "Your old password does not match");
            redirect('change_password.php', false);
        }

        $id = (int)$_POST['id'];
        // Hash the new password using password_hash
        $new_hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        $sql = "UPDATE users SET password ='{$db->escape($new_hashed_password)}' WHERE id='{$db->escape($id)}'";
        $result = $db->query($sql);

        if($result && $db->affected_rows() === 1) {
            // Clear the session ID after password change
            $sql = "UPDATE users SET session_id = '' WHERE id = " . (int)$user['id'];
            $db->query($sql);
        
            // Log the user out and redirect
            $session->logout();
            $_SESSION['logout'] = "Password updated. Please log in with your new one.";
            redirect('L-Login.php?access=allowed', false);
        } else {
            $session->msg('d', 'Failed to update password');
            redirect('change_password.php', false);
        }
        
    } else {
        $session->msg("d", $errors);
        redirect('change_password.php', false);
    }
}
?>
<link rel="icon" type="image/x-icon" href="uploads/users/rizel.png">
<?php include_once('layouts/header.php'); ?>
<div style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" class="login-page">
    <div class="text-center">
       <h3>Change your password</h3>
     </div>
     <?php echo display_msg($msg); ?>
      <form method="post" action="change_password" class="clearfix">
        <div class="form-group">
              <label for="oldPassword" class="control-label">Old password</label>
              <input style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" type="password" class="form-control" name="oldpassword" id="oldpassword" placeholder="Old password">
        </div>
        <div class="form-group">
              <label for="newPassword" class="control-label">New password</label>
              <input style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" type="password" class="form-control" name="newpassword" id="newpassword" placeholder="New password">
        </div>
        <div class="form-group">
              <label for="confirmPassword" class="control-label">Confirm password</label>
              <input style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Confirm password">
        </div>
        <div class="form-group clearfix">
               <input style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" type="hidden" name="id" value="<?php echo (int)$user['id'];?>">
                <center><button style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" type="submit" name="update" class="btn btn-info">Change</button></center>
        </div>
    </form>
</div>
<?php include_once('layouts/footer.php'); ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('#confirmpassword').addEventListener('input', function() {
        let newPassword = document.querySelector('#newpassword').value;
        let confirmPassword = this.value;
        if(newPassword !== confirmPassword) {
            this.style.borderColor = 'red';
        } else {
            this.style.borderColor = ''; // Reset border color
        }
    });
});
</script>
<script src="sweetalert.min.js"></script>
<script>
    function detectXSS(inputField, fieldName) {
        const symbolPattern = /[^a-zA-Z0-9]/;
        const xssPattern =  /[<>:\/\$\;\,\?\!]/;
        inputField.addEventListener('input', function() {
            // Check for XSS
            if (xssPattern.test(this.value)) {
                swal("XSS Detected", `Please avoid using script tags in your ${fieldName}.`, "error");
                this.value = "";
                return;
            }
            if ((fieldName === 'Old Password' || fieldName === 'New Password' || fieldName === 'Confirm Password') && symbolPattern.test(this.value)) {
                swal("Invalid Input", `Please avoid using symbols in your ${fieldName}.`, "error");
                this.value = "";
            }
        });
    }
    const oldpasswordInput = document.getElementById('oldpassword');
    const newpasswordInput = document.getElementById('newpassword');
    const confirmpasswordInput = document.getElementById('confirmpassword');
    detectXSS(oldpasswordInput, 'Old Password');
    detectXSS(newpasswordInput, 'New Password');
    detectXSS(confirmpasswordInput, 'Confirm Password');
</script>
