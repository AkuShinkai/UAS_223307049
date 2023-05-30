<?php
// Pengecekan status login
session_start();
if (!isset($_SESSION['username'])) {
  header('Location: login.php');
  exit();
}

// Logout
if (isset($_POST['logout'])) {
  session_destroy();
  header('Location: login.php');
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Home</title>
  <link rel="icon" href="img/icon.jpg" type="image/x-icon">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
  <style>
    body {
      background-image: url("img/88886807_p0.png");
      background-size: cover;
      background-repeat: no-repeat;
      color: #ffffff;
      font-family: Arial, sans-serif;
    }
    .navbar {
      background-color: #333333;
      border-bottom: 1px solid #ffffff;
    }
    .navbar-brand {
      font-size: 24px;
      font-weight: bold;
    }
    .navbar-toggler {
      color: #ffffff;
      border-color: #ffffff;
    }
    .navbar-toggler-icon {
      background-color: #ffffff;
    }
    .nav-link {
      color: #ffffff;
      font-weight: bold;
    }
    .container {
      margin-top: 100px;
    }
    .jumbotron {
      background-color: rgba(0, 0, 0, 0.5);
      padding: 20px;
      border-radius: 10px;
    }
    .jumbotron h1 {
      font-size: 36px;
      font-weight: bold;
      margin-bottom: 20px;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }
    .jumbotron p {
      font-size: 18px;
      text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
    }
    .logout-btn {
      font-weight: bold;
    }
    .slideshow-container {
      position: relative;
      max-width: 1000px;
      margin: 0 auto;
    }
    .mySlides {
      display: none;
    }
    .mySlides img {
      width: 100%;
      height: auto;
    }
    .caption {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      padding: 8px;
      background-color: rgba(0, 0, 0, 0.5);
      color: #fff;
      font-size: 14px;
      text-align: center;
    }
    .prev,
    .next {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      font-size: 24px;
      font-weight: bold;
      padding: 16px;
      color: #fff;
      transition: 0.6s ease;
      border-radius: 0 3px 3px 0;
      user-select: none;
    }
    .prev {
      left: 0;
      border-radius: 3px 0 0 3px;
    }
    .next {
      right: 0;
      border-radius: 3px 0 0 3px;
    }
    .prev:hover,
    .next:hover {
      background-color: rgba(0, 0, 0, 0.8);
    }
    @keyframes slide-fade-in {
      0% {
        opacity: 0;
      }
      100% {
        opacity: 1;
      }
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="#">Home</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="data.php">Produk</a>
        </li>
      </ul>
      <form method="POST" action="" class="form-inline my-2 my-lg-0">
        <button type="submit" class="btn btn-link logout-btn" name="logout">Logout</button>
      </form>
    </div>
  </nav>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="jumbotron animate__animated animate__fadeIn">
          <h1 class="text-center">Welcome, <span style="color: #ff6600;"><?php echo $_SESSION['username']; ?></span>!</h1>
          <div class="slideshow-container">
            <div class="mySlides">
              <img src="img/image1.jpg" alt="Image 1">
              <div class="caption">Caption 1</div>
            </div>
            <div class="mySlides">
              <img src="img/image2.jpg" alt="Image 2">
              <div class="caption">Caption 2</div>
            </div>
            <div class="mySlides">
              <img src="img/image3.png" alt="Image 3">
              <div class="caption">Caption 3</div>
            </div>
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <script>
    var slideIndex = 0;
    showSlides();

    function showSlides() {
      var slides = document.getElementsByClassName("mySlides");
      var captions = [
        "Hallo <span style='color: #ff6600;'><?php echo $_SESSION['username']; ?></span>, selamat datang di website yang kubuat! Website ini saya buat untuk project UAS semester 2 Politeknik Negeri Madiun.",
        "Perkenalkan, Namaku Muhammad Fariz, aku berasal dari kota Madiun. Saya merupakan mahasiswa semester 2 dari Politeknik Negeri Madiun.",
        "Website ini saya buat dengan tujuan agar user dapat menyimpan data produk untuk gudang ataupun hanya sebagai catatan data barang saja. Mungkin konsep website ini terlalu sederhana, saya sendiri juga merasa website yang saya buat ini masih terlalu sederhana dan perlu peningkatan lagi. Oleh karena itu, kedepannya saya berniat untuk meningkatkan skill saya dalam pemrograman web sehingga dapat membuat website yang lebih baik secara visual maupun fungsionalitasnya."
      ];
      var captionElements = document.getElementsByClassName("caption"); // Menyimpan elemen caption
      for (var i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
      }
      slideIndex++;
      if (slideIndex > slides.length) {
        slideIndex = 1;
      }
      slides[slideIndex - 1].style.display = "block";
      captionElements[slideIndex - 1].innerHTML = captions[slideIndex - 1]; // Mengubah konten caption di bawah gambar
      setTimeout(showSlides, 10000); // Change slide every 10 seconds
    }

    function plusSlides(n) {
      showSlidesByIndex((slideIndex += n));
    }

    function showSlidesByIndex(n) {
      var slides = document.getElementsByClassName("mySlides");
      var captions = [
        "Hallo <span style='color: #ff6600;'><?php echo $_SESSION['username']; ?></span>, selamat datang di website yang kubuat! Website ini saya buat untuk project UAS semester 2 Politeknik Negeri Madiun.",
        "Perkenalkan, Namaku Muhammad Fariz, aku berasal dari kota Madiun. Saya merupakan mahasiswa semester 2 dari Politeknik Negeri Madiun.",
        "Website ini saya buat dengan tujuan agar user dapat menyimpan data produk untuk gudang ataupun hanya sebagai catatan data barang saja. Mungkin konsep website ini terlalu sederhana, saya sendiri juga merasa website yang saya buat ini masih terlalu sederhana dan perlu peningkatan lagi. Oleh karena itu, kedepannya saya berniat untuk meningkatkan skill saya dalam pemrograman web sehingga dapat membuat website yang lebih baik secara visual maupun fungsionalitasnya."
      ];
      var captionElements = document.getElementsByClassName("caption"); // Menyimpan elemen caption
      if (n > slides.length) {
        slideIndex = 1;
      } else if (n < 1) {
        slideIndex = slides.length;
      }
      for (var i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
      }
      slides[slideIndex - 1].style.display = "block";
      captionElements[slideIndex - 1].innerHTML = captions[slideIndex - 1]; // Mengubah konten caption di bawah gambar
    }
  </script>
</body>
</html>
