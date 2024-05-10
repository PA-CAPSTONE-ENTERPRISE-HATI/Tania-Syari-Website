<?php
    require "../db.php";
?>

<html>
    <head>
        <title>
            Data Member
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
        <h1 class="text-center">Data Member</h1>
    </div>
    <div class="row" style="justify-content: space-between;">
        <div class="col-lg-9" style="width: 80%; margin: 20px auto;">
            <div class="text-center" style="text-align: end;">
                <a href="tambah_member.php" class="btn btn-primary btn-add-product">Tambah Membership</a>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">ID Member</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Nomor Handphone</th>
                        <th class="text-center">Alamat</th>
                        <th class="text-center">Aksi</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $nomor=1;
                        $sql = mysqli_query($conn, "SELECT * FROM member");
                        while ($pecah = mysqli_fetch_assoc($sql)) {
                    ?>
                    <tr class="text-center">
                        <td><?php echo $nomor;?></</td>
                        <td><?php echo $pecah['id_member'];?></td>
                        <td><?php echo $pecah['nama_member'];?></td>
                        <td><?php echo $pecah['email'];?></td>
                        <td><?php echo $pecah['nohp_member'];?></td>
                        <td><?php echo $pecah['alamat_member'];?></td>
                        <td>
                            <div class="btn-group">
                                <a href="ubah_member.php?id=<?php echo $pecah['id_member'];?>" class="btn btn-info">Ubah</a>
                                <a href="javascript:void(0);" onclick="confirmDelete('<?php echo $pecah['nama_member'];?>', <?php echo $pecah['id_member'];?>);" class="btn btn-danger">Hapus</a>
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

<script>
    function confirmDelete(nama, id) {
        var result = confirm("Apakah Anda yakin ingin menghapus data member " + nama + "?");
        if (result) {
            window.location = "hapus_member.php?id=" + id;
        }
    }
</script>