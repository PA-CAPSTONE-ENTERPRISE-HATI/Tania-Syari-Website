<?php
    require "../db.php";
?>

<link href="../assets/images/tania_syari.png" rel="icon" >
<link href="../assets/css/tambahproduk.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<div class="container">
    <div class="back-button">
        <a href="produk.php"><i class="fa fa-arrow-left"></i></a>
    </div>
    <div class="row title-container"> 
        <h2 class="text-center">Tambah Produk</h2>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <form method="post" enctype="multipart/form-data">
                <div class="form-group mt-2">
                    <label>Nama Produk</label>
                    <input type="text" class="form-control" name="nama">
                </div>
                <div class="form-group mt-2">
                    <label>Harga (Rp)</label>
                    <input type="number" class="form-control" name="harga">
                </div>
                <div class="form-group mt-2">
                    <label>Foto Produk</label>
                    <input type="file" class="form-control" name="foto">
                </div>
                <div class="form-group mt-2">
                    <label>Deskripsi Produk</label>
                    <textarea class="form-control" name="deskripsi" rows="10"></textarea>
                </div>
                <button class="btn btn-primary" name="simpan">Simpan Produk</button>
            </form>
        </div>
    </div>
</div>

<?php
if (isset($_POST["simpan"])) 
{
    $nama = $_FILES['foto']['name'];
    $lokasi = $_FILES['foto']['tmp_name'];
    move_uploaded_file($lokasi, "../produk/".$nama);
    $sql = mysqli_query($conn, "INSERT INTO produk
        (nama_model, harga_produk, foto_produk, deskripsi_produk) 
        VALUES('$_POST[nama]','$_POST[harga]', '$nama', '$_POST[deskripsi]')");

    echo "<script>alert('Berhasil menambahkan produk');</script>";
    echo "<meta http-equiv='refresh' content='1;url=produk.php'>";
}
?>
