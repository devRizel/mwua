<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

<?php
$page_title = 'Add User';
require_once('includes/load.php');

page_require_level(1);
$groups = find_all('user_groups');


if (isset($_POST['add_user'])) {
    $req_fields = array('password', 'phone','username', 'full-name', 'level');
    validate_fields($req_fields);


    $error_msgs = array();
    foreach ($req_fields as $field) {
        if (empty($_POST[$field])) {
            $error_msgs[] = ucfirst($field) . " can't be blank.";
        }
    }


    if (empty($error_msgs)) {

        $existing_name = find_by_name($_POST['full-name']);
        if ($existing_name) {  
            $error_msgs[] = "Name '{$_POST['full-name']}' already exists.";
        }
    }

    if (empty($error_msgs)) {

        $existing_username = find_by_username($_POST['username']);
        if ($existing_username) {
            $error_msgs[] = "Username '{$_POST['username']}' already exists.";
        }
    }

    if (empty($error_msgs)) {

        $existing_phone = find_by_phone($_POST['phone']);
        if ($existing_phone) {
            $error_msgs[] = "Number '{$_POST['phone']}' already exists.";
        }
    }


    if (empty($error_msgs)) {
        $name       = remove_junk($db->escape($_POST['full-name']));
        $username   = remove_junk($db->escape($_POST['username']));
        $phone   = remove_junk($db->escape($_POST['phone']));
        $password   = remove_junk($db->escape($_POST['password']));
        $user_level = (int)$db->escape($_POST['level']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $query  = "INSERT INTO users (name, username,phone, password, user_level, status) ";
        $query .= "VALUES ('{$name}', '{$username}','{$phone}', '{$password}', '{$user_level}', '1')";

        if ($db->query($query)) {

            redirect('add_user.php?success=true', false);
        } else {

            $session->msg('d', 'Sorry failed to create account!');
            redirect('add_user.php', false);
        }
    } else {

        $js_error_msgs = json_encode($error_msgs);
    }
}

function find_by_name($name) {
    global $db;
    $escaped_name = $db->escape($name);
    $query = "SELECT id FROM users WHERE name = '{$escaped_name}' LIMIT 1";
    $result_set = $db->query($query);
    return $db->fetch_assoc($result_set);
}

function find_by_username($username) {
    global $db;
    $escaped_username = $db->escape($username);
    $query = "SELECT id FROM users WHERE username = '{$escaped_username}' LIMIT 1";
    $result_set = $db->query($query);
    return $db->fetch_assoc($result_set);
}

function find_by_phone($phone) {
    global $db;
    $escaped_phone = $db->escape($phone);
    $query = "SELECT id FROM users WHERE phone = '{$escaped_phone}' LIMIT 1";
    $result_set = $db->query($query);
    return $db->fetch_assoc($result_set);
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
                    <input type="text" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);" class="form-control" name="full-name" placeholder="Full Name" value="<?php echo isset($_POST['full-name']) ? $_POST['full-name'] : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="username">Email</label>
                    <input id="username" type="email" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);" class="form-control" name="username" placeholder="Username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="phone">Number</label>
                    <input id="phone" type="tel" maxlength="11" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);" class="form-control" name="phone" placeholder="Number" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>" oninput="validatephoneInput(event)">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <div style="position: relative;">
                        <input id="password" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);" type="password" name="password" class="form-control" placeholder="Password" value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>">
                        <i id="togglePassword" class="fa fa-eye" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; display: none;"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label for="level">User Role</label>
                    <select style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);" class="form-control" name="level">
                        <?php foreach ($groups as $group): ?>
                        <option value="<?php echo $group['group_level']; ?>" <?php echo isset($_POST['level']) && $_POST['level'] == $group['group_level'] ? 'selected' : ''; ?>>
                        <?php echo ucwords($group['group_name']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group clearfix">
                    <button style="border-radius: 50% 10% 50% 10% / 10% 50% 10% 50%; box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);" type="submit" name="add_user" class="btn btn-primary">Add User</button>
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
    }
</script>
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
        swal("", "User account has been created!", "success")
            .then((value) => {
                window.location.href = 'add_user.php'; 
            });
    }
</script>

<script>
  document.getElementById('password').addEventListener('input', function() {
    var togglePassword = document.getElementById('togglePassword');
    togglePassword.style.display = this.value ? 'block' : 'none';
  });

  document.getElementById('togglePassword').addEventListener('click', function() {
    var passwordInput = document.getElementById('password');
    var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    this.classList.toggle('fa-eye');
    this.classList.toggle('fa-eye-slash');
  });
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
        const xssPattern =  /[<>:\/\$\;\,\?\!]/;
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