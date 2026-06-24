function showForm(type) {
  document.getElementById('loginForm').classList.toggle('active', type === 'login');
  document.getElementById('registerForm').classList.toggle('active', type === 'register');
  document.getElementById('loginTab').classList.toggle('active', type === 'login');
  document.getElementById('registerTab').classList.toggle('active', type === 'register');
}
