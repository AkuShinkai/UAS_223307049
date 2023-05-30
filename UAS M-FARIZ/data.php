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

// Fungsi CRUD Data Produk

// Fungsi untuk mendapatkan daftar produk berdasarkan userId
function getProducts($userId)
{
    global $conn;

    $sql = "SELECT * FROM produk WHERE userId = '$userId'";
    $result = mysqli_query($conn, $sql);

    $products = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }

    return $products;
}

// Fungsi untuk menambahkan produk baru
function addProduct($userId, $namaProduk, $hargaProduk, $stok)
{
    global $conn;

    // Mengecek apakah produk sudah ada
    $existingProduct = getProductByName($userId, $namaProduk);
    if ($existingProduct) {
        echo "<script>alert('Produk dengan nama tersebut sudah ada. Mohon gunakan nama yang berbeda.');</script>";
        return;
    }

    $sql = "INSERT INTO produk (userId, namaProduk, hargaProduk, stok) VALUES ('$userId', '$namaProduk', '$hargaProduk', '$stok')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Data berhasil ditambahkan.');</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat menambahkan data. Silakan coba lagi.');</script>";
    }
}

// Fungsi untuk memperbarui produk
function updateProduct($idProduk, $namaProduk, $hargaProduk, $stok)
{
    global $conn;

    // Mengecek apakah produk sudah ada
    $existingProduct = getProductByName($_SESSION['userId'], $namaProduk);
    if ($existingProduct && $existingProduct['idProduk'] !== $idProduk) {
        echo "<script>alert('Produk dengan nama tersebut sudah ada. Mohon gunakan nama yang berbeda.');</script>";
        return;
    }

    $sql = "UPDATE produk SET namaProduk = '$namaProduk', hargaProduk = '$hargaProduk', stok = '$stok' WHERE idProduk = '$idProduk'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Data berhasil diubah.');</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat mengubah data. Silakan coba lagi.');</script>";
    }
}

// Fungsi untuk menghapus produk
function deleteProduct($idProduk)
{
    global $conn;

    $sql = "DELETE FROM produk WHERE idProduk = '$idProduk'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Data berhasil dihapus.');</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat menghapus data. Silakan coba lagi.');</script>";
    }
}

// Fungsi untuk mendapatkan produk berdasarkan userId dan namaProduk
function getProductByName($userId, $namaProduk)
{
    global $conn;

    $sql = "SELECT * FROM produk WHERE userId = '$userId' AND namaProduk = '$namaProduk'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    return $row;
}

// Memproses form tambah produk
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_product'])) {
        $userId = $_SESSION['userId'];
        $namaProduk = $_POST['namaProduk'];
        $hargaProduk = $_POST['hargaProduk'];
        $stok = $_POST['stok'];

        addProduct($userId, $namaProduk, $hargaProduk, $stok);
    }

    // Memproses form update produk
    if (isset($_POST['update_product'])) {
        $idProduk = $_POST['idProduk'];
        $namaProduk = $_POST['namaProduk'];
        $hargaProduk = $_POST['hargaProduk'];
        $stok = $_POST['stok'];

        updateProduct($idProduk, $namaProduk, $hargaProduk, $stok);
    }

    // Memproses form hapus produk
    if (isset($_POST['delete_product'])) {
        $idProduk = $_POST['idProduk'];

        deleteProduct($idProduk);
    }
}

// Mendapatkan daftar produk berdasarkan userId
$userId = $_SESSION['userId'];
$products = getProducts($userId);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Produk</title>
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
    </style>
    <script>
        // Fungsi untuk menampilkan konfirmasi penghapusan
        function confirmDelete() {
            return confirm("Apakah Anda yakin ingin menghapus produk ini?");
        }
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Produk</a>
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
                <div class="jumbotron mt-4">
                    <h1 class="text-center">Data Produk
                    </h1>
                    <?php if (isset($_SESSION['success_message'])): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $_SESSION['success_message']; ?>
                        </div>
                        <?php unset($_SESSION['success_message']); ?>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['error_message'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $_SESSION['error_message']; ?>
                        </div>
                        <?php unset($_SESSION['error_message']); ?>
                    <?php endif; ?>
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="namaProduk">Nama Produk</label>
                            <input type="text" class="form-control" name="namaProduk" id="namaProduk"
                                placeholder="Nama Produk" required>
                        </div>
                        <div class="form-group">
                            <label for="hargaProduk">Harga Produk</label>
                            <input type="number" class="form-control" name="hargaProduk" id="hargaProduk"
                                placeholder="Harga Produk" required>
                        </div>
                        <div class="form-group">
                            <label for="stok">Stok</label>
                            <input type="number" class="form-control" name="stok" id="stok" placeholder="Stok" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="add_product">Tambah Produk</button>
                    </form>

                    <h3 class="text-center">List Produk</h3>
                    <?php if (!empty($products)): ?>
                        <table class="table mt-4">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Harga Produk</th>
                                    <th>Stok</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $product): ?>
                                    <?php if ($product['userId'] === $userId): ?>
                                        <tr>
                                            <td>
                                                <?php echo $product['namaProduk']; ?>
                                            </td>
                                            <td>
                                                <?php echo $product['hargaProduk']; ?>
                                            </td>
                                            <td>
                                                <?php echo $product['stok']; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <form method="POST"
                                                        action="edit.php?id=<?php echo $product['idProduk']; ?>">
                                                        <input type="hidden" name="idProduk"
                                                            value="<?php echo $product['idProduk']; ?>">
                                                        <button class="btn btn-sm btn-primary"
                                                            name="edit_product">Edit</button>
                                                    </form>
                                                    <form method="POST" action="" onsubmit="return confirmDelete();">
                                                        <input type="hidden" name="idProduk"
                                                            value="<?php echo $product['idProduk']; ?>">
                                                        <button class="btn btn-sm btn-danger"
                                                            name="delete_product">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p class="mt-4">No products found.</p>
                    <?php endif; ?>
                    <h20 class="text-center">*Note: List tersebut ditampilkan berdasarkan data dari akun yang dipakai</h20>

                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>

</html>
