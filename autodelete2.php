
<?php
require_once('includes/load.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_selected'])) {
    if (isset($_POST['rooms']) && !empty($_POST['rooms'])) {
        foreach ($_POST['rooms'] as $room_id) {
            $room_id = (int)$room_id;
            delete_by_id('chat', $room_id); 
        }
        $session->msg("s", "Selected chats deleted successfully.");
        redirect('autodelete.php?access=allowed&success=true&delete_room=true');
    } else {
        $session->msg("d", "No rooms selected for deletion.");
        redirect('autodelete.php?access=allowed');
    }
} else {
    if (isset($_GET['id'])) {
        $product = find_by_id('chat', (int)$_GET['id']);
        if (!$product) {
            $session->msg("d", "Missing chat id.");
            redirect('autodelete.php?access=allowed');
        }
        $delete_id = delete_by_id('chat', (int)$product['id']);
        if ($delete_id) {
            $session->msg("s", "Chat deleted successfully.");
            redirect('autodelete.php?access=allowed&success=true&delete_room=true');
        } else {
            $session->msg("d", "Chat deletion failed.");
            redirect('autodelete.php?access=allowed');
        }
    }
}
?>