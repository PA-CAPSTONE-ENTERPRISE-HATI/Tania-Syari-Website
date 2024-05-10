<?php
    require "../db.php";
?>    

<link href="../assets/images/tania_syari.png" rel="icon" >
<link href="../assets/css/tambahproduk.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<?php
    $sql = mysqli_query($conn,"SELECT * FROM produk WHERE id_produk='$_GET[id]'");
    $pecah = mysqli_fetch_assoc($sql);
?>

<div class="container">
    <div class="back-button">
        <a href="produk.php"><i class="fa fa-arrow-left"></i></a>
    </div>
    <div class="row title-container"> 
        <h2 class="text-center">Ubah Produk</h2>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <form method="post" enctype="multipart/form-data">
                <div class="form-group mt-2">
                    <label>Nama Produk</label>
                    <input type="text" name="nama" class="form-control" value="<?php echo $pecah['nama_model'];?>">
                </div>
                <div class="form-group mt-2">
                    <label>Harga Produk</label>
                    <input type="number" name="harga" class="form-control" value="<?php echo $pecah['harga_produk'];?>">
                </div>
                <div class="form-group mt-2">
                    <img src="../produk/<?php echo $pecah['foto_produk'] ?>" width="100">
                </div>
                <div class="form-group mt-2">
                    <label>Ganti Foto</label>
                    <input type="file" name="foto" class="form-control">
                </div>
                <div class="form-group mt-2">
                    <label>Deskripsi Produk</label>
                    <textarea class="form-control" name="deskripsi" rows="10"></textarea>
                </div>
                <button class="btn btn-primary mt-2" name="ubah">Ubah</button>
            </form>
        </div>
    </div>
</div>

<?php
    if (isset($_POST['ubah'] )) {
        $namafoto = $_FILES['foto']['name'];
        $lokasifoto = $_FILES['foto']['tmp_name'];
        // Jika foto diubah
        if (!empty($lokasifoto))
        {
            move_uploaded_file($lokasifoto, "../produk/$namafoto");

            $sql = mysqli_query($conn,"UPDATE produk SET nama_model = '$_POST[nama]',
                harga_produk='$_POST[harga]', foto_produk = '$namafoto', deskripsi_produk='$_POST[deskripsi]' WHERE id_produk = '$_GET[id]'");
        }
        else{
            $sql = mysqli_query($conn,"UPDATE produk SET nama_model = '$_POST[nama]',
            harga_produk='$_POST[harga]', deskripsi_produk='$_POST[deskripsi]' WHERE id_produk = '$_GET[id]'");
        }
        echo "<script>alert('Data produk telah diubah');</script>";
        echo "<script>location='produk.php';</script>";
    }   
?>