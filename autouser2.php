
<?php
require_once('includes/load.php');

if (isset($_GET['id'])) {
    $user_id = (int)$_GET['id'];
    $user = find_by_id('users', $user_id);
    if (!$user) {
        $session->msg("d", "Missing user id.");
        redirect('autouser.php?access=allowed');
    }

    $sql = "UPDATE users SET session_id = '' WHERE id = {$user_id}";
    $result = $db->query($sql); 

    if ($result) {
        $session->msg("s", "User's session cleared successfully.");
        redirect('autouser.php?access=allowed&success=true&delete_room=true');
    } else {
        $session->msg("d", "Failed to clear user's session.");
        redirect('.php?access=allowed');
    }
}
?>
