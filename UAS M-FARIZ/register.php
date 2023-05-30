<?php
require_once('koneksi.php');
?>

<!DOCTYPE html>
<html>
<head>
  <title>Registration Page</title>
  <link rel="icon" href="img/icon.jpg" type="image/x-icon">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <style>
    body {
      background-image: url("img/88886807_p0.png");
      background-size: cover;
      background-repeat: no-repeat;
    }
    .card {
      background-color: rgba(255, 255, 255, 0.8);
      width: 550px; /* Tambahkan lebar pada card */
      margin: 0 auto; /* Agar card berada di tengah horizontal */
      margin-top: 150px; /* Atur jarak atas card sesuai keinginan */
    }
    .card-header {
      background-color: #007bff;
      color: #fff;
      text-align: center;
      padding: 20px;
    }
    .form-control:focus {
      border-color: #007bff;
      box-shadow: none;
    }
    .btn-primary {
      background-color: #007bff;
      border-color: #007bff;
    }
    .btn-primary:hover {
      background-color: #0069d9;
      border-color: #0062cc;
    }
    .btn-outline-secondary {
      color: #007bff;
      border-color: #007bff;
    }
    .btn-outline-secondary:hover {
      color: #fff;
      background-color: #007bff;
      border-color: #007bff;
    }
    .password-rules {
      position: absolute;
      bottom: -25px;
      font-size: 12px;
      color: #888;
    }
    .password-rules ul {
      margin: 0;
      padding-left: 15px;
    }
  </style>
  <script>
    function showRegistrationSuccessNotification() {
      Swal.fire({
        icon: 'success',
        title: 'Registrasi Berhasil',
        text: 'Silakan login dengan akun yang telah didaftarkan.',
      }).then(() => {
        window.location.href = 'login.php';
      });
    }

    function showRegistrationErrorNotification(errorMessage) {
      Swal.fire({
        icon: 'error',
        title: 'Registrasi Gagal',
        text: errorMessage,
      });
    }

    function togglePasswordVisibility(inputId, showButtonId, hideButtonId) {
      var passwordInput = document.getElementById(inputId);
      var showButton = document.getElementById(showButtonId);
      var hideButton = document.getElementById(hideButtonId);

      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        showButton.style.display = 'none';
        hideButton.style.display = 'inline-block';
      } else {
        passwordInput.type = 'password';
        showButton.style.display = 'inline-block';
        hideButton.style.display = 'none';
      }
    }
  </script>
</head>
<body>
  <div class="card">
    <div class="card-header">
      <h3 class="text-center">Registrasi</h3>
    </div>
    <div class="card-body">
      <form method="POST" action="register.php">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
          <label for="password">Password (minimal 8 karakter)</label>
          <div class="input-group">
            <input type="password" class="form-control" id="password" name="password" required>
            <div class="input-group-append">
              <button type="button" class="btn btn-outline-secondary" id="show_password" onclick="togglePasswordVisibility('password', 'show_password', 'hide_password')">Show</button>
              <button type="button" class="btn btn-outline-secondary" id="hide_password" style="display: none;" onclick="togglePasswordVisibility('password', 'show_password', 'hide_password')">Hide</button>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="confirm_password">Konfirmasi Password</label>
          <div class="input-group">
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            <div class="input-group-append">
              <button type="button" class="btn btn-outline-secondary" id="show_confirm_password" onclick="togglePasswordVisibility('confirm_password', 'show_confirm_password', 'hide_confirm_password')">Show</button>
              <button type="button" class="btn btn-outline-secondary" id="hide_confirm_password" style="display: none;" onclick="togglePasswordVisibility('confirm_password', 'show_confirm_password', 'hide_confirm_password')">Hide</button>
            </div>
          </div>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-block">Daftar</button>
        </div>
        <p class="text-center">Sudah punya akun? <a href="login.php">Login</a></p>
      </form>
      <div class="password-rules">
      
      </div>
    </div>
  </div>


  <?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil nilai dari form registrasi
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Periksa apakah password dan konfirmasi password sesuai
    if ($password !== $confirm_password) {
      echo "<script>showRegistrationErrorNotification('Password dan konfirmasi password tidak cocok.');</script>";
      exit;
    }

    // Periksa apakah password memenuhi persyaratan
    if (strlen($password) < 8) {
      echo "<script>showRegistrationErrorNotification('Password harus memiliki minimal 8 karakter/huruf.');</script>";
      exit;
    }

    // Periksa apakah username sudah digunakan
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
      echo "<script>showRegistrationErrorNotification('Username sudah digunakan.');</script>";
      exit;
    }

    // Tambahkan user baru ke database
    $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    if ($conn->query($query) === TRUE) {
      echo "<script>showRegistrationSuccessNotification();</script>";
    } else {
      echo "<script>showRegistrationErrorNotification('Registrasi gagal: " . $conn->error . "');</script>";
    }
  }
  ?>

</body>
</html>
