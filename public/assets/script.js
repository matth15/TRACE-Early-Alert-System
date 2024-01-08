

document.getElementById('show-password-toggle').addEventListener('change', function() {
    var passwordInput = document.getElementById('passwordInput');
    if (this.checked) {
      passwordInput.type = 'text';
    } else {
      passwordInput.type = 'password';
    }
  });