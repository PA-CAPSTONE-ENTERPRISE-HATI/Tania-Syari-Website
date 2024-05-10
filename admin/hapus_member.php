<?php
require "../db.php";

// Periksa apakah parameter id terkirim melalui URL
if (isset($_GET['id'])) {
    // Tangkap nilai id dari URL
    $id_member = $_GET['id'];

    // Query untuk menghapus data member berdasarkan id
    $query_delete = "DELETE FROM member WHERE id_member = '$id_member'";
    $result_delete = mysqli_query($conn, $query_delete);

    // Periksa apakah query berhasil dieksekusi
    if ($result_delete) {
        // Jika berhasil, alihkan kembali ke halaman data member
        header("Location: member.php");
        exit;
    } else {
        // Jika query gagal, tampilkan pesan kesalahan
        echo "Error: " . mysqli_error($conn);
    }
}
?>
