<?php
require "../db.php";

// Ambil id_pesanan dari parameter URL
$id_pesanan = $_GET['id'];

// Ambil data pesanan berdasarkan id_pesanan
$query_pesanan = mysqli_query($conn, "SELECT pesanan.*, bukti.foto_bukti 
    FROM pesanan 
    LEFT JOIN bukti ON pesanan.id_pesanan = bukti.id_pesanan 
    WHERE pesanan.id_pesanan = '$id_pesanan'");

$data_pesanan = mysqli_fetch_assoc($query_pesanan);

// Ambil data detail pesanan berdasarkan id_pesanan
$query_detail = mysqli_query($conn, "SELECT detail_pesanan.*, produk.nama_model, detail_pesanan.jumlah_pesanan * produk.harga_produk AS subtotal
    FROM detail_pesanan
    JOIN produk ON detail_pesanan.id_produk = produk.id_produk
    WHERE detail_pesanan.id_pesanan = '$id_pesanan'");


// Ubah status pembayaran
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $status_pembayaran = $_POST['status_pembayaran'];
    mysqli_query($conn, "UPDATE pesanan SET status_pesanan = '$status_pembayaran' WHERE id_pesanan = '$id_pesanan'");
    // Redirect untuk mencegah pengiriman ulang formulir saat halaman direfresh
    header("Location: {$_SERVER['PHP_SELF']}?id=$id_pesanan");
    exit(); // Pastikan skrip berhenti setelah mengirimkan header redirect
}
?>

<html>

<head>
    <title>Detail Pesanan</title>

</head>
<link href="../assets/images/tania_syari.png" rel="icon">
<link href="../assets/css/view.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<body>
    <div class="container">
        <div class="row justify-content-center title-container">
            <div class="back-button">
                <a href="pesanan_non.php"><i class="fa fa-arrow-left"></i></a>
            </div>
            <h1 class="text-center">Detail Pesanan</h1>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <h2 style="text-align: center;">Data Pesanan</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Nama Pembeli</th>
                            <th>Tanggal Pesanan</th>
                            <th>Alamat Pengiriman</th>
                            <th>Status Pembayaran</th>
                            <th>Total Harga Pesanan</th>
                            <th>Jenis Pembayaran</th>
                            <th>Bukti Transfer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $data_pesanan['id_pesanan']; ?></td>
                            <td><?php echo $data_pesanan['nama_pesanan']; ?></td>
                            <td><?php echo $data_pesanan['tanggal_pesanan']; ?></td>
                            <td><?php echo $data_pesanan['alamat_pesanan']; ?></td>
                            <td><?php echo $data_pesanan['status_pesanan']; ?></td>
                            <td><?php echo 'Rp ' . number_format($data_pesanan['total_harga_pesanan'], 0, ',', '.'); ?></td>
                            <td><?php echo $data_pesanan['jenis_pembayaran']; ?></td>
                            <td>
                                <?php
                                if (!empty($data_pesanan['foto_bukti'])) {
                                    echo '<img src="../uploads/' . $data_pesanan['foto_bukti'] . '" width="100" height="100">';
                                } else {
                                    echo '-';
                                }
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <h2 style="text-align: center;">Detail Pesanan</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Barang</th>
                            <th>Nama Barang</th>
                            <th>Jumlah Pesanan</th>
                            <th>Subtotal Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row_detail = mysqli_fetch_assoc($query_detail)) : ?>
                            <tr>
                                <td><?php echo $row_detail['id_produk']; ?></td>
                                <td><?php echo $row_detail['nama_model']; ?></td>
                                <td><?php echo $row_detail['jumlah_pesanan']; ?></td>
                                <td><?php echo 'Rp ' . number_format($row_detail['subtotal'], 0, ',', '.'); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <!-- Form untuk mengubah status pembayaran -->

                <div class="container">
                    <div class="row justify-content-center">
                        <div class="custom">
                            <form method="post">
                                <div class="form-group">
                                    <label for="status_pembayaran">Status Pembayaran:</label>
                                    <select class="form-control" name="status_pembayaran" id="status_pembayaran">
                                        <option value="Menunggu Pembayaran" <?php if ($data_pesanan['status_pesanan'] == 'Menunggu Pembayaran') echo 'selected'; ?>>Menunggu Pembayaran</option>
                                        <option value="Diproses" <?php if ($data_pesanan['status_pesanan'] == 'Diproses') echo 'selected'; ?>>Diproses</option>
                                        <option value="Dikirim" <?php if ($data_pesanan['status_pesanan'] == 'Dikirim') echo 'selected'; ?>>Dikirim</option>
                                        <option value="Ditolak" <?php if ($data_pesanan['status_pesanan'] == 'Ditolak') echo 'selected'; ?>>Ditolak</option>
                                        <option value="Selesai" <?php if ($data_pesanan['status_pesanan'] == 'Selesai') echo 'selected'; ?>>Selesai</option>
                                    </select>

                                </div>
                                <button type="submit" class="btn btn-primary">Ubah Status Pembayaran</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Bootstrap JS -->
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

            </div>
        </div>
    </div>

</body>

</html>


<style>
    .row.justify-content-center {
        justify-content: center;
    }

    .custom {
        width: 100%;
        max-width: 700px;
        /* Atur lebar maksimum sesuai kebutuhan */
        padding-right: 15px;
        padding-left: 15px;
        margin-right: auto;
        margin-left: auto;
    }


    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 5px;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
</style>