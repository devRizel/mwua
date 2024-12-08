  // Initially hide the togglePassword icon
  document.getElementById('togglePassword').style.display = 'none';

  // Show/hide the togglePassword icon based on input
  document.getElementById('password').addEventListener('input', function() {
    var togglePassword = document.getElementById('togglePassword');
    togglePassword.style.display = this.value.length > 0 ? 'block' : 'none';
  });

  
  // Toggle password visibility
  document.getElementById('togglePassword').addEventListener('click', function() {
    var passwordInput = document.getElementById('password');
    var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    this.classList.toggle('fa-eye');
    this.classList.toggle('fa-eye-slash');
  });