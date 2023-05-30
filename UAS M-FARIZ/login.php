<?php
require_once('koneksi.php');

// Cek apakah pengguna sudah login sebelumnya
session_start();
if (isset($_SESSION['username'])) {
  header("Location: index.php");
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login Page</title>
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
      margin-top: 100px; /* Atur jarak atas card sesuai keinginan */
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
    .center {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
  </style>
  <script>
    function showFailedLoginNotification() {
      Swal.fire({
        icon: 'error',
        title: 'Login Gagal',
        text: 'Username atau password yang Anda masukkan salah.',
      });
    }

    function redirectToHome() {
      window.location.href = 'index.php';
    }

    function togglePasswordVisibility() {
      const passwordInput = document.getElementById('password');
      const passwordToggle = document.getElementById('password-toggle');

      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordToggle.innerText = 'Hide';
      } else {
        passwordInput.type = 'password';
        passwordToggle.innerText = 'Show';
      }
    }
  </script>
</head>
<body>
  <div class="center">
    <div class="card">
      <div class="card-header">
        <h3>Login</h3>
      </div>
      <div class="card-body">
        <form method="POST" action="login.php">
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <div class="input-group">
              <input type="password" class="form-control" id="password" name="password" required>
              <div class="input-group-append">
                <button type="button" class="btn btn-outline-secondary" id="password-toggle" onclick="togglePasswordVisibility()">Show</button>
              </div>
            </div>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Login</button>
          </div>
          <p class="text-center">Belum punya akun? <a href="register.php">Daftar</a></p>
        </form>
      </div>
    </div>
  </div>

  <?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil nilai dari form login
    $username = $_POST['username'];
    $password = $_POST['password'];
  
    // Cek username dan password di database
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);
  
    if ($result->num_rows > 0) {
      // Login berhasil
      $_SESSION['username'] = $username;
      $_SESSION['userId'] = $username; // Menggunakan username sebagai userId
      echo "<script>Swal.fire('Login Berhasil').then(() => { redirectToHome(); });</script>";
    } else {
      // Login gagal
      echo "<script>showFailedLoginNotification();</script>";
    }
  }
  ?>

</body>
</html>
