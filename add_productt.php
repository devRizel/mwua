<link rel="icon" type="image/x-icon" href="uploads/users/rizel.png">
<?php
$page_title = 'Add User';
require_once('includes/load.php');
// Checking what level user has permission to view this page
page_require_level(1);
$groups = find_all('user_groups');



if (isset($_POST['add_user'])) {
    $req_fields = array('full-name', 'username', 'password', 'level');
    validate_fields($req_fields);

    // Check for empty fields
    $error_msgs = array();
    foreach ($req_fields as $field) {
        if (empty($_POST[$field])) {
            $error_msgs[] = ucfirst($field) . " can't be blank.";
        }
    }

    if (empty($error_msgs)) {
        $name       = remove_junk($db->escape($_POST['full-name']));
        $username   = remove_junk($db->escape($_POST['username']));
        $password   = remove_junk($db->escape($_POST['password']));
        $user_level = (int)$db->escape($_POST['level']);
        $password   = sha1($password);

        $query  = "INSERT INTO users (name, username, password, user_level, status) ";
        $query .= "VALUES ('{$name}', '{$username}', '{$password}', '{$user_level}', '1')";

        if ($db->query($query)) {
            // Success
            redirect('add_user.php?success=true', false);
        } else {
            // Failed
            $session->msg('d', 'Sorry failed to create account!');
            redirect('add_user.php', false);
        }
    } else {
        // Prepare the array for JavaScript
        $js_error_msgs = json_encode($error_msgs);
    }
}
?>
<link rel="icon" type="image/x-icon" href="uploads/users/rizel.png">
<?php include_once('layouts/header.php'); ?>
<div class="row justify-content-center">
    <div class="col-md-6 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>Add New User</strong>
            </div>
            <div class="panel-body">
                <form method="post" action="add_user">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="full-name" placeholder="Full Name">
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="level">User Role</label>
                        <select class="form-control" name="level">
                            <?php foreach ($groups as $group ):?>
                            <option value="<?php echo $group['group_level'];?>"><?php echo ucwords($group['group_name']);?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group clearfix">
                        <button  style=" border-radius: 50% 10% 50% 10% / 10% 50% 10% 50%;" type="submit" name="add_user" class="btn btn-primary">Add User</button>
                    </div>
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
    // Check if success query parameter is present in URL
    const urlParams = new URLSearchParams(window.location.search);
    const successParam = urlParams.get('success');
    if (successParam === 'true') {
        swal("", "User account has been created!", "success")
            .then((value) => {
                window.location.href = 'add_user.php'; 
            });
    }
</script>
