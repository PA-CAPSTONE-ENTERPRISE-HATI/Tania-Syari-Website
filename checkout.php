<?php
// Include database connection file
include 'db.php';
session_start();
include 'function.php';

// Check if cartItems are passed in the URL
if (isset($_GET['cartItems'])) {
    // Decode the JSON string and store cart items in the session
    $_SESSION['cartItems'] = json_decode(urldecode($_GET['cartItems']), true);
}

// Check if cartItems session is set
if (isset($_SESSION['cartItems'])) {
    // Get cartItems data from session
    $cartItems = $_SESSION['cartItems'];

    // Get total harga pesanan
    $total_harga_pesanan = 0;
    foreach ($cartItems as $item) {
        $total_harga_pesanan += $item['harga_produk'] * $item['quantity'];
    }

    $total_pembayaran = $total_harga_pesanan + 10000;

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get form data
        $nama_pesanan = $_POST['nama_pesanan'];
        $alamat_pesanan = $_POST['alamat_pesanan'];
        $nohp_pesanan = $_POST['nohp_pesanan'];
        $email_pesanan = $_POST['email_pesanan'];
        $jenis_pembayaran = $_POST['jenis_pembayaran'];

        // Generate unique code for id_pesanan
        $id_pesanan = generateUniqueCode();

        // Insert data into pesanan table
        $sql_pesanan = "INSERT INTO pesanan (id_pesanan, nama_pesanan, alamat_pesanan, no_hp_pesanan, email_pesanan, total_harga_pesanan, status_pesanan, tanggal_pesanan, jenis_pembayaran) VALUES ('$id_pesanan', '$nama_pesanan', '$alamat_pesanan', '$nohp_pesanan', '$email_pesanan', '$total_pembayaran', 'Menunggu Pembayaran', NOW(), '$jenis_pembayaran')";
        if ($conn->query($sql_pesanan) === TRUE) {
            $sql_pembeli = "INSERT INTO pembeli (nama_pembeli, nohp_pembeli, alamat_pembeli, email_pembeli) VALUES ('$nama_pesanan', '$nohp_pesanan', '$alamat_pesanan', '$email_pesanan')";
            // Insert data into detail_pesanan table for each checked out product
            if ($conn->query($sql_pembeli) === TRUE) {
                
            foreach ($cartItems as $item) {
                // Get quantity and subtotal from session
                $jumlah_pesanan = $item['quantity'];
                $subtotal = $item['quantity'] * $item['harga_produk'];

                // Insert data into detail_pesanan table
                $sql_detail = "INSERT INTO detail_pesanan (id_pesanan, id_produk, jumlah_pesanan, subtotal_harga) VALUES ('$id_pesanan', '{$item['id_produk']}', '$jumlah_pesanan', '$subtotal')";
                $conn->query($sql_detail);
            }
            }

            // Clear the cartItems session after checkout
            unset($_SESSION['cart']);

            // Redirect to success page or perform any other necessary actions
            header("Location: success.php?kode_pesanan=$id_pesanan");
            exit;
        } else {
            echo "Error: " . $sql_pesanan . "<br>" . $conn->error;
        }
    }
} else {
    // Redirect back to cart page or display an error message
    header("Location: cart.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Checkout</title>
    <link href="../baju/assets/images/tania_syari.png" rel="icon">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD2Hhh_14Uam62GXGaTMcXWhhVkYg0EbDY&callback=initMap" async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Custom CSS File Link -->
    <link rel="stylesheet" href="assets/css/rating.css">
    <link rel="stylesheet" href="assets/css/slider.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/convo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"><!-- font awesome cdn link -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"><!-- Google font cdn link -->
</head>

<body>
<?php include 'partials/header.php'; ?>

<div class="container" style="margin-top: 200px;">
    <div class="row">
        <div class="col-md-6">
            <h2>Checkout</h2>
            <hr>
            <form method="post">
                <!-- Your form fields -->
                <div class="form-group">
                    <label for="nama_pesanan">Nama : </label>
                    <input type="text" class="form-control" id="nama_pesanan" name="nama_pesanan" required>
                </div>
                <div class="form-group">
                    <label for="alamat_pesanan">Alamat : </label>
                    <input type="text" class="form-control" id="alamat_pesanan" name="alamat_pesanan" required>
                </div>
                <div class="form-group">
                    <label for="nohp_pesanan">No. HP : </label>
                    <input type="text" class="form-control" id="nohp_pesanan" name="nohp_pesanan" required>
                </div>
                <div class="form-group">
                    <label for="email_pesanan">Email : </label>
                    <input type="email" class="form-control" id="email_pesanan" name="email_pesanan" required>
                </div>
                <div class="form-group">
                    <label for="jenis_pembayaran">Jenis Pembayaran : </label>
                    <select class="form-control" id="jenis_pembayaran" name="jenis_pembayaran" required>
                        <option value="COD">COD</option>
                        <option value="Transfer">Transfer</option>
                    </select>
                </div>

                <!-- Total Pembelian, Ongkos Kirim, and Total Pembayaran -->
                <style>
    .custom-box {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        padding: 10px;
        margin-bottom: 20px;
        height: 60px;
    }
</style>

<div class="row justify-content-center mt-5">
    <div class="col-md-4">
        <div class="custom-box">
            <div class="text-center">
                <h5>Total Pembelian</h5>
                <p><?php echo 'Rp ' . number_format($total_harga_pesanan, 0, ',', '.'); ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="custom-box">
            <div class="text-center">
                <h5>Ongkos Kirim</h5>
                <p><?php echo 'Rp 10.000'; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="custom-box">
            <div class="text-center">
                <h5>Total Pembayaran</h5>
                <p><strong><?php echo 'Rp ' . number_format($total_pembayaran, 0, ',', '.'); ?></strong></p>
            </div>
        </div>
    </div>
</div>

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary">Checkout</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>