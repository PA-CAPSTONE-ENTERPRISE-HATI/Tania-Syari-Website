<?php
require "../db.php";

// Periksa apakah parameter id terkirim melalui URL
if (isset($_GET['id'])) {
    // Tangkap nilai id dari URL
    $id_member = $_GET['id'];

    // Query untuk mendapatkan data member berdasarkan id
    $query = "SELECT * FROM member WHERE id_member = '$id_member'";
    $result = mysqli_query($conn, $query);

    // Periksa apakah query berhasil dieksekusi
    if ($result) {
        // Ambil data member
        $member = mysqli_fetch_assoc($result);
    } else {
        // Jika query gagal, tampilkan pesan kesalahan
        echo "Error: " . mysqli_error($conn);
    }
}

// Periksa apakah tombol "Simpan Perubahan" telah diklik
if (isset($_POST['update'])) {
    // Tangkap data yang dikirimkan melalui form
    $id_member = $_POST['id_member'];
    $nama_member = $_POST['nama_member'];
    $email = $_POST['email'];
    $nohp_member = $_POST['nohp_member'];
    $alamat_member = $_POST['alamat_member'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mengupdate data member
    $query_update = "UPDATE member SET nama_member = '$nama_member', email = '$email', nohp_member = '$nohp_member', alamat_member = '$alamat_member', username = '$username', password = '$password' WHERE id_member = '$id_member'";
    $result_update = mysqli_query($conn, $query_update);

    // Periksa apakah query berhasil dieksekusi
    if ($result_update) {
        // Jika berhasil, alihkan kembali ke halaman data member
        header("Location: member.php");
        exit;
    } else {
        // Jika query gagal, tampilkan pesan kesalahan
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!-- Tampilkan form untuk mengubah data member -->
<html>
<head>
    <title>Ubah Data Member</title>
    <link href="../assets/images/tania_syari.png" rel="icon" >
    <link href="../assets/css/tambahproduk.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="back-button">
        <a href="member.php"><i class="fa fa-arrow-left"></i></a>
    </div>
    <div class="row title-container"> 
        <h2 class="text-center">Ubah Data Member</h2>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_member" value="<?php echo $member['id_member']; ?>">
                <div class="form-group mt-2">
                    <label>Nama Member</label>
                    <input type="text" class="form-control" name="nama_member" value="<?php echo $member['nama_member']; ?>">
                </div>
                <div class="form-group mt-2">
                    <label>No. HP Member</label>
                    <input type="text" class="form-control" name="nohp_member" value="<?php echo $member['nohp_member']; ?>">
                </div>
                <div class="form-group mt-2">
                    <label>Alamat Member</label>
                    <textarea class="form-control" name="alamat_member" rows="3"><?php echo $member['alamat_member']; ?></textarea>
                </div>
                <div class="form-group mt-2">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" value="<?php echo $member['email']; ?>">
                </div>
                <div class="form-group mt-2">
                    <label>Username</label>
                    <input type="text" class="form-control" name="username" value="<?php echo $member['username']; ?>">
                </div>
                <div class="form-group mt-2">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" value="<?php echo $member['password']; ?>">
                </div>
                <button class="btn btn-primary" name="update">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
