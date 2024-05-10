<?php
// Include auth_session.php file on all user panel pages
include '../db.php';
session_start();
include '../function.php';

// Periksa apakah sesi id_member ada dan tidak kosong
if(isset($_SESSION['id_member']) && !empty($_SESSION['id_member'])) {
    $id_member = $_SESSION['id_member'];
    $sql = "SELECT nama_member, nohp_member, alamat_member, email FROM member WHERE id_member = '$id_member'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nama_member = $row['nama_member'];
        $nohp_member = $row['nohp_member'];
        $alamat_member = $row['alamat_member'];
        $email = $row['email'];
    } else {
        // Member tidak ditemukan
        echo "<script>alert('Data member tidak ditemukan.')</script>";
        // Lakukan pengalihan atau tindakan lain jika diperlukan
        header("Location: login.php");
        exit;
    }

    // Periksa apakah sesi cartItems telah diatur
    if (isset($_SESSION['cartItems'])) {
        // Dapatkan data cartItems dari sesi
        $cartItems = $_SESSION['cartItems'];

        // Hitung total harga pesanan
        $total_harga_pesanan = 0;
        foreach ($cartItems as $item) {
            $total_harga_pesanan += $item['harga_produk'] * $item['quantity'];
        }

        // Hitung diskon dan total harga pesanan setelah diskon
        $diskon = $total_harga_pesanan * 0.1;
        $total_harga_pesanan_setelah_diskon = $total_harga_pesanan - $diskon;

        // Hitung total pembayaran termasuk biaya tambahan
        $total_pembayaran = $total_harga_pesanan_setelah_diskon + 10000;

        // Cek jika formulir telah disubmit
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Dapatkan data formulir
            $nama_pesanan = $row['nama_member'];
            $alamat_pesanan = $row['alamat_member'];
            $nohp_pesanan = $row['nohp_member'];
            $email_pesanan = $row['email'];
            $jenis_pembayaran = $_POST['jenis_pembayaran'];

            // Buat kode unik untuk id_pesanan
            $id_pesanan = generateUniqueCode();

            // Masukkan data ke tabel pesanan
            $sql_pesanan = "INSERT INTO pesanan (id_pesanan, nama_pesanan, alamat_pesanan, no_hp_pesanan, email_pesanan, total_harga_pesanan, status_pesanan, tanggal_pesanan, jenis_pembayaran) VALUES ('$id_pesanan', '$nama_pesanan', '$alamat_pesanan', '$nohp_pesanan', '$email_pesanan', '$total_pembayaran', 'Menunggu Pembayaran', NOW(), '$jenis_pembayaran')";
            if ($conn->query($sql_pesanan) === true) {
                // Masukkan data ke tabel detail_pesanan untuk setiap produk yang di-checkout
                foreach ($cartItems as $item) {
                    // Periksa apakah item sudah ada di tabel detail_pesanan
                    $sql_check_existing = "SELECT * FROM detail_pesanan WHERE id_pesanan = '$id_pesanan' AND id_produk = '{$item['id_produk']}'";
                    $result_check_existing = $conn->query($sql_check_existing);

                    if ($result_check_existing->num_rows > 0) {
                        // Jika item sudah ada, perbarui jumlah dan subtotal
                        $existing_item = $result_check_existing->fetch_assoc();
                        $new_quantity = $existing_item['jumlah_pesanan'] + $item['quantity'];
                        $new_subtotal = $existing_item['subtotal'] + ($item['quantity'] * $item['harga_produk']);

                        // Perbarui item yang sudah ada jika jumlah atau subtotal lebih besar dari 0
                        if ($new_quantity > 0 && $new_subtotal > 0) {
                            $sql_update_existing = "UPDATE detail_pesanan SET jumlah_pesanan = '$new_quantity', subtotal = '$new_subtotal' WHERE id_pesanan = '$id_pesanan' AND id_produk = '{$item['id_produk']}'";
                            if (!$conn->query($sql_update_existing)) {
                                echo "Error updating record: " . $conn->error;
                            }
                        } else {
                            // Hapus item yang sudah ada jika jumlah atau subtotal 0
                            $sql_delete_existing = "DELETE FROM detail_pesanan WHERE id_pesanan = '$id_pesanan' AND id_produk = '{$item['id_produk']}'";
                            if (!$conn->query($sql_delete_existing)) {
                                echo "Error deleting record: " . $conn->error;
                            }
                        }
                    } else {
                        // Jika item belum ada, masukkan item baru hanya jika jumlah dan subtotal lebih besar dari 0
                        $jumlah_pesanan = $item['quantity'];
                        $subtotal = $item['quantity'] * $item['harga_produk'];

                        if ($jumlah_pesanan > 0 && $subtotal > 0) {
                            // Masukkan data ke tabel detail_pesanan
                            $sql_detail = "INSERT INTO detail_pesanan (id_pesanan, id_produk, jumlah_pesanan, subtotal_harga) VALUES ('$id_pesanan', '{$item['id_produk']}', '$jumlah_pesanan', '$subtotal')";
                            if (!$conn->query($sql_detail)) {
                                echo "Error inserting record: " . $conn->error;
                            }
                        }
                    }
                }

                // Kosongkan sesi cartItems setelah checkout
                unset($_SESSION['cart']);

                // Alihkan ke halaman sukses atau lakukan tindakan lain yang diperlukan
                header("Location: ../success.php?kode_pesanan=$id_pesanan");
                exit;
            } else {
                echo "Error: " . $sql_pesanan . "<br>" . $conn->error;
            }
        }
    }
} else {
    // Jika id_member tidak tersedia dalam sesi, alihkan ke halaman login
    header("Location: login.php");
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
    <title>Tania Syar'i</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>

    <!-- Custom CSS File Link -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/convo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"><!-- font awesome cdn link -->
    <link rel="icon" type="image/x-icon" href="../assets/images/tania_syari.png"><!-- Favicon / Icon -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"><!-- Google font cdn link -->
</head>


<body>
    <!-- HEADER SECTION -->
    <header class="header">
        <a href="#" class="logo">
            <img src="../assets/images/tania_syari.png" class="img-logo" alt="tania Logo">
        </a>

        <!-- MAIN MENU FOR SMALLER DEVICES -->
        <nav class="navbar navbar-expand-lg">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="#home" class="text-decoration-none">Pemesanan Member</a>
                </li>
            </ul>
            </div>
        </nav>
        <div class="nav-item">
            <a href="../index.php" class="btn btn-primary"> Logout</a>
        </div>
    </header>

    <!--SECTION -->
    
    <section>
    <div class="container" style="margin-top: 150px;">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow p-4">
                <?php if (!isset($_SESSION['cartItems'])): ?>
                        <h2>Data Member</h2>
                    <?php else: ?>
                        <h2>Checkout</h2>
                    <?php endif; ?>
                    <hr>
                    <form method="post"> <!-- Tambahkan method="post" di sini -->
                        <div class="mb-3">
                            <label for="nama_member" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama_member" value="<?php echo $nama_member; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="nohp_member" class="form-label">No. HP</label>
                            <input type="text" class="form-control" id="nohp_member" value="<?php echo $nohp_member; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="alamat_member" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat_member" rows="3" readonly><?php echo $alamat_member; ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" value="<?php echo $email; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="jenis_pembayaran">Jenis Pembayaran:</label>
                            <select class="form-control" id="jenis_pembayaran" name="jenis_pembayaran" required>
                                <option value="COD">COD</option>
                                <option value="Transfer">Transfer</option>
                            </select>
                        </div>
                    
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="row justify-content-center mt-5">
                    <div class="col-md-4" <?php if (!isset($_SESSION['cartItems'])) echo 'style="display: none;"'; ?>>
                    <div class="custom-box">
                        <div class="text-center">
                            <h5>Total Pembelian (Diskon 10%)</h5>
                            <p><?php echo 'Rp ' . number_format($total_harga_pesanan_setelah_diskon, 0, ',', '.'); ?></p>

                        </div>
                    </div>
                </div>
                <div class="col-md-4" <?php if (!isset($_SESSION['cartItems'])) echo 'style="display: none;"'; ?>>
                    <div class="custom-box">
                        <div class="text-center">
                            <h5>Ongkos Kirim</h5>
                            <p><?php echo 'Rp 10.000'; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" <?php if (!isset($_SESSION['cartItems'])) echo 'style="display: none;"'; ?>>
                    <div class="custom-box">
                        <div class="text-center">
                            <h5>Total Pembayaran</h5>
                            <p><strong><?php echo 'Rp ' . number_format($total_pembayaran, 0, ',', '.'); ?></strong></p>
                        </div>
                    </div>
                </div>
                <?php if (isset($_SESSION['cartItems'])) : ?>
                <button type="submit" class="btn btn-primary">Checkout</button>
                <?php endif; ?>
            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <style>
   .custom-box {
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    padding: 10px;
    margin-bottom: 20px;
    height: 80px;
    text-align: center; /* Mengatur teks menjadi rata tengah */
    display: flex;
    align-items: center;
    justify-content: center;
}

</style>