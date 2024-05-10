<?php
// Sisipkan file koneksi ke database
include "db.php";

// Inisialisasi variabel untuk menampung hasil pencarian
$order_data = array();

// Periksa apakah form pencarian telah dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil kode pesanan dari form
    $search_order_code = $_POST['search_order_code'];

    // Lakukan pencarian data pesanan berdasarkan kode pesanan
    $sql_search_order = "SELECT * FROM pesanan WHERE id_pesanan = '$search_order_code'";
    $result_search_order = $conn->query($sql_search_order);

    // Jika data pesanan ditemukan, simpan ke dalam variabel $order_data
    if ($result_search_order && $result_search_order->num_rows > 0) {
        $order_data = $result_search_order->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Status Pesanan</title>
    <link href="../baju/assets/images/tania_syari.png" rel="icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD2Hhh_14Uam62GXGaTMcXWhhVkYg0EbDY&callback=initMap" async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Custom CSS File Link -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"><!-- font awesome cdn link -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"><!-- Google font cdn link -->
</head>


<body>
    <!-- HEADER SECTION -->
    <?php include 'partials/header.php'; ?>
    <div class="container" style="margin-top: 200px;">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h3 class="mb-3">Cek Status Pesanan</h3>
                <!-- Form pencarian kode pesanan -->
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="mb-3">
                        <label for="search_order_code" class="form-label">Masukkan Kode Pesanan : </label>
                        <input type="text" class="form-control" id="search_order_code" name="search_order_code" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Cari</button>
                </form>

                <!-- Tampilkan detail pesanan jika ada -->
                <?php if (!empty($order_data)) : ?>
                    <div class="mt-4 mb-5">
                        <h5>Detail Pesanan</h5>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th scope="row">Kode Pesanan</th>
                                    <td><?php echo $order_data['id_pesanan']; ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Nama</th>
                                    <td><?php echo $order_data['nama_pesanan']; ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Alamat</th>
                                    <td><?php echo $order_data['alamat_pesanan']; ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Nomor Telepon</th>
                                    <td><?php echo $order_data['no_hp_pesanan']; ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Email</th>
                                    <td><?php echo $order_data['email_pesanan']; ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Total Harga Pesanan</th>
                                    <td>Rp <?php echo number_format($order_data['total_harga_pesanan'], 0, ',', '.'); ?></td>
                                </tr>

                                <tr>
                                    <th scope="row">Status Pesanan</th>
                                    <td><?php echo $order_data['status_pesanan']; ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Tanggal Pesanan</th>
                                    <td><?php echo $order_data['tanggal_pesanan']; ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Jenis Pembayaran</th>
                                    <td><?php echo $order_data['jenis_pembayaran']; ?></td>
                                </tr>
                                <?php if ($order_data['jenis_pembayaran'] === 'Transfer'): ?>
                                    <tr>
                                        <th scope="row">Upload Bukti Transfer</th>
                                        <td>
                                            <form action="upload_bukti.php" method="post" enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="no_rekening" class="form-label">No. Rekening</label>
                                                        <h5>BCA 067128321</h5>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="file" class="form-label">Upload File</label>
                                                        <input type="file" class="form-control" id="file" name="file">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="id_pesanan" value="<?php echo $order_data['id_pesanan']; ?>">
                                            </form>
                                        </td>
                                    </tr>
                                <?php endif; ?>


                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                 <!-- Pesan "Data tidak ditemukan" -->
                    <div class="mt-4">
                        <h5>Data tidak ditemukan.</h5>
                    </div>
                    
                <?php endif; ?>

            </div>
        </div>
    </div>


    <!-- Include your footer content here -->

    <!-- Include your scripts here -->
</body>

</html>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

<!-- Core plugin JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

