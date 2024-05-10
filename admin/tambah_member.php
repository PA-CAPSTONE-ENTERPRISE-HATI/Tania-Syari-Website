<?php
    require "../db.php";

    if(isset($_POST['simpan'])){
        $nama_member = $_POST['nama_member'];
        $nohp_member = $_POST['nohp_member'];
        $alamat_member = $_POST['alamat_member'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Query untuk menyimpan data ke tabel member
        $query = "INSERT INTO member (nama_member, nohp_member, alamat_member, email, username, password, create_datetime) VALUES ('$nama_member', '$nohp_member', '$alamat_member', '$email', '$username', '$password', NOW())";

        if(mysqli_query($conn, $query)){
            // Jika penyimpanan berhasil, arahkan ke halaman member.php
            header("Location: ./member.php");
            exit();
        } else{
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
    }
?>
<html>
    <head>
        <title>
            Tambah Member
        </title>
    </head>
</html>

<link href="../assets/images/tania_syari.png" rel="icon" >
<link href="../assets/css/tambahproduk.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<div class="container">
    <div class="back-button">
        <a href="index.php"><i class="fa fa-arrow-left"></i></a>
    </div>
    <div class="row title-container"> 
        <h2 class="text-center">Tambah Member</h2>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <form method="post" enctype="multipart/form-data">
                <div class="form-group mt-2">
                    <label>Nama Member</label>
                    <input type="text" class="form-control" name="nama_member">
                </div>
                <div class="form-group mt-2">
                    <label>No. HP Member</label>
                    <input type="text" class="form-control" name="nohp_member">
                </div>
                <div class="form-group mt-2">
                    <label>Alamat Member</label>
                    <textarea class="form-control" name="alamat_member" rows="3"></textarea>
                </div>
                <div class="form-group mt-2">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email">
                </div>
                <div class="form-group mt-2">
                    <label>Username</label>
                    <input type="text" class="form-control" name="username">
                </div>
                <div class="form-group mt-2">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <button class="btn btn-primary" name="simpan">Simpan Member</button>
            </form>
        </div>
    </div>
</div>
