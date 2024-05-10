
<?php
    require "../db.php";
?>

<html>
    <head>
        <title>
            Data Pesanan Member
        </title>
    </head>
</html>

<link href="../assets/images/tania_syari.png" rel="icon" >
<link href="../assets/css/produkbutton.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<div class="container">
    <div class="row justify-content-center title-container"> 
        <div class="back-button">
            <a href="index.php"><i class="fa fa-arrow-left"></i></a>
        </div>
        <h1 class="text-center">Data Pesanan Member</h1>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">Kode Pesanan</th>
                        <th class="text-center">Nama Member</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Alamat</th>
                        <th class="text-center">Status Pesanan</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Jenis Pembayaran</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $nomor=1;
                        $sql = mysqli_query($conn, "SELECT pesanan.id_pesanan, member.nama_member, pesanan.tanggal_pesanan, pesanan.alamat_pesanan, pesanan.status_pesanan, pesanan.total_harga_pesanan, pesanan.jenis_pembayaran 
                            FROM pesanan 
                            JOIN member ON pesanan.nama_pesanan COLLATE utf8mb4_unicode_ci = member.nama_member COLLATE utf8mb4_unicode_ci
                            GROUP BY pesanan.id_pesanan");
                        while ($pecah = mysqli_fetch_assoc($sql)) {
                    ?>
                    <tr class="text-center">
                        <td><?php echo $nomor;?></</td>
                        <td><?php echo $pecah['id_pesanan'];?></td>
                        <td><?php echo $pecah['nama_member'];?></td>
                        <td><?php echo $pecah['tanggal_pesanan'];?></td>
                        <td><?php echo $pecah['alamat_pesanan'];?></td>
                        <td><?php echo $pecah['status_pesanan'];?></td>
                        <td><?php echo $pecah['jenis_pembayaran'];?></td>
                        <td>Rp. <?php echo number_format( $pecah['total_harga_pesanan'], 0, ',', '.');?></td>
                        <td><a href="detail_pesanan.php?id=<?php echo $pecah['id_pesanan'];?>" class="btn btn-custom">Detail</a></td>
                    </tr>
                    <?php $nomor++ ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

