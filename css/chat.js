function toggleChatWindow() {
    var chatWindow = document.getElementById('chatWindow');
    var chatForm = document.getElementById('chatForm');
    if (chatWindow.style.display === 'none' || chatWindow.style.display === '') {
        chatWindow.style.display = 'block';
    } else {
        chatWindow.style.display = 'none';
        chatForm.reset(); // Clear the form fields
    }
}