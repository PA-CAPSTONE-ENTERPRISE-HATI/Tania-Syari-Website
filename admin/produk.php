<?php
    require "../db.php";
?>

<html>
    <head>
        <title>
            Data Produk
        </title>
    </head>
</html>

<link href="../assets/images/tania_syari.png" rel="icon" >
<link href="../assets/css/view.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<div class="container">
    <div class="row justify-content-center title-container"> 
        <div class="back-button">
            <a href="index.php"><i class="fa fa-arrow-left"></i></a>
        </div>
        <h1 class="text-center">Data Produk</h1>
    </div>
    
    <div class="row" style="justify-content: space-between;">
        <div class="col-lg-9" style="width: 80%; margin: 20px auto;">
            <div class="text-center" style="text-align: end;">
                <a href="tambahproduk.php" class="btn btn-primary btn-add-product">Tambah Produk</a>
            </div>
        </div>
    </div>
    
    
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Foto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php 
                        $nomor=1;
                        $sql = mysqli_query($conn, "SELECT * FROM produk");
                        while ($pecah = mysqli_fetch_assoc($sql)) {
                    ?>
                    <tr>
                        <td><?php echo $nomor;?></td>
                        <td><?php echo $pecah['nama_model'];?></td>
                        <td>Rp <?php echo number_format($pecah['harga_produk'],0, ',', '.' );?></td>
                        <td>
                            <img src="../produk/<?php echo $pecah['foto_produk'];?>" width="100px">
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="ubahproduk.php?id=<?php echo $pecah['id_produk'];?>" class="btn btn-info">Ubah</a>
                                <a href="hapusproduk.php?id=<?php echo $pecah['id_produk'];?>" class="btn btn-danger">Hapus</a>
                            </div>
                        </td>
                    </tr>
                    <?php $nomor++ ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


