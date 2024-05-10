<?php
    require "../db.php";
?>

<link href="../assets/images/tania_syari.png" rel="icon" >
<link href="../assets/css/produkbutton.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<div class="container">
    <div class="row justify-content-center title-container"> 
        <div class="back-button">
            <a href="index.php"><i class="fa fa-arrow-left"></i></a>
        </div>
        <h1 class="text-center">Data Pembelian Member</h1>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">Nama Member</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Alamat</th>
                        <th class="text-center">Status Pembelian</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $nomor=1;
                        $sql = mysqli_query($conn, "SELECT * FROM pembelian_member JOIN member ON 
                        pembelian_member.id_member=member.id_member");
                        while ($pecah = mysqli_fetch_assoc($sql)) {
                    ?>
                    <tr class="text-center">
                        <td><?php echo $nomor;?></</td>
                        <td><?php echo $pecah['nama_member'];?></td>
                        <td><?php echo $pecah['tanggal_pembelian'];?></td>
                        <td><?php echo $pecah['alamat_pengiriman'];?></td>
                        <td><?php echo $pecah['status_pembelian'];?></td>
                        <td>Rp. <?php echo number_format( $pecah['total_pembelian']);?></td>
                        <td>
                            <a href="detail_mem.php?id=<?php echo $pecah['id_pembelian_mem'];?>" class="btn btn-custom">Detail</a>

                            <?php if ($pecah['status_pembelian'] == "Sudah bayar"): ?>
                            <a href="pembayaran_member.php?id=<?php echo $pecah['id_pembelian_mem'];?>" class="btn btn-custom2">Pembayaran</a>
                            <?php endif ?>
                    </tr>
                    <?php $nomor++ ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

