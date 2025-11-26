function register() {
  const username = document.getElementById("newUsername").value.trim();
  const password = document.getElementById("newPassword").value.trim();
  const confirmPassword = document.getElementById("confirmPassword").value.trim();
  const result = document.getElementById("regResult");
  const welcomeMessage = document.getElementById("welcomeMessage");

  if (!username || !password || !confirmPassword) {
    result.style.color = "#c0392b";
    result.textContent = "⚠️ Semua kolom harus diisi.";
    welcomeMessage.style.display = "none";
    return;
  }

  if (password !== confirmPassword) {
    result.style.color = "#c0392b";
    result.textContent = "⚠️ Password dan konfirmasi tidak cocok.";
    welcomeMessage.style.display = "none";
    return;
  }

  localStorage.setItem("registeredUsername", username);
  localStorage.setItem("registeredPassword", password);

  result.style.color = "#27ae60";
  result.textContent = "✅ Registrasi berhasil!";
  welcomeMessage.textContent = `🎉 Selamat datang, ${username}!`;
  welcomeMessage.style.display = "block";

  setTimeout(() => {
    window.location.href = "login.html";
  }, 3000);
}
