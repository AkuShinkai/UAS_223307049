<?php
// Include file koneksi database
include 'koneksi.php';

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

// Mendapatkan data produk berdasarkan ID
function getProductById($idProduk)
{
    global $conn;

    $sql = "SELECT * FROM produk WHERE idProduk = '$idProduk'";
    $result = mysqli_query($conn, $sql);

    $product = mysqli_fetch_assoc($result);

    return $product;
}

// Memproses form update produk
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_product'])) {
        $idProduk = $_POST['idProduk'];
        $namaProduk = $_POST['namaProduk'];
        $hargaProduk = $_POST['hargaProduk'];
        $stok = $_POST['stok'];

        // Check if the product already exists for the user
        $userId = $_SESSION['username']; // Assuming the user ID is stored in 'username'
        $existingProductQuery = "SELECT * FROM produk WHERE idProduk != '$idProduk' AND userId = '$userId' AND namaProduk = '$namaProduk'";
        $existingProductResult = mysqli_query($conn, $existingProductQuery);
        $existingProduct = mysqli_fetch_assoc($existingProductResult);
        if ($existingProduct) {
            // Product already exists for the user, display a notification
            echo '<div class="alert alert-danger">Produk dengan nama tersebut sudah ada.</div>';
        } else {
            // Perform the update query
            $sql = "UPDATE produk SET namaProduk='$namaProduk', hargaProduk='$hargaProduk', stok='$stok' WHERE idProduk='$idProduk'";
            mysqli_query($conn, $sql);

            header('Location: data.php');
            exit();
        }
    }
}

// Mendapatkan ID produk dari parameter URL
if (isset($_GET['id'])) {
    $idProduk = $_GET['id'];

    // Mendapatkan data produk berdasarkan ID
    $product = getProductById($idProduk);
} else {
    // Handle jika ID produk tidak tersedia
    echo "ID produk tidak tersedia.";
    exit();
}
?>


<!DOCTYPE html>
<html>

<head>
    <title>Edit Produk</title>
    <link rel="icon" href="img/icon.jpg" type="image/x-icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            background-image: url("img/88886807_p0.png");
            background-size: cover;
        }

        .jumbotron {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            margin-top: 50px;
        }

        @media (min-width: 576px) {
            .jumbotron {
                margin-top: 100px;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Edit</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                <div class="jumbotron">
                    <h1 class="text-center">Edit Produk</h1>
                    <form method="POST" action="">
                        <input type="hidden" name="idProduk" value="<?php echo $product['idProduk']; ?>">
                        <div class="form-group">
                            <label for="namaProduk">Nama Produk</label>
                            <input type="text" class="form-control" name="namaProduk" id="namaProduk"
                                placeholder="Nama Produk" value="<?php echo $product['namaProduk']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="hargaProduk">Harga Produk</label>
                            <input type="number" class="form-control" name="hargaProduk" id="hargaProduk"
                                placeholder="Harga Produk" value="<?php echo $product['hargaProduk']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="stok">Stok</label>
                            <input type="number" class="form-control" name="stok" id="stok" placeholder="Stok"
                                value="<?php echo $product['stok']; ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="update_product">Simpan</button>
                        <a href="data.php" class="btn btn-danger">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>

</html>
