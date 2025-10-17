function validateForm() {
  const name = document.getElementById('name').value.trim();
  const email = document.getElementById('email').value.trim();
  const message = document.getElementById('message').value.trim();

  if (!name) {
    alert('Bitte geben Sie Ihren Namen ein.');
    return false;
  }

  if (!email) {
    alert('Bitte geben Sie Ihre E-Mail-Adresse ein.');
    return false;
  }

  // تحقق بسيط من صحة البريد الإلكتروني
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailPattern.test(email)) {
    alert('Bitte geben Sie eine gültige E-Mail-Adresse ein.');
    return false;
  }

  if (!message) {
    alert('Bitte geben Sie Ihre Nachricht ein.');
    return false;
  }

  return true;
}
