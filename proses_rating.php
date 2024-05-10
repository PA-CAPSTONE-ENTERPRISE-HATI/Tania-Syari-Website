<?php
// Mulai session
session_start();

// Sertakan file koneksi ke database
require 'db.php';

// Periksa apakah form rating dan review telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap data yang dikirimkan melalui form
    $id_produk = $_POST['id_produk'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    // Siapkan pernyataan SQL untuk menyimpan rating dan review ke dalam database
    $sql = "INSERT INTO rating (id_produk, rating, review, tanggal_rating) VALUES (?, ?, ?, NOW())";
    
    // Persiapkan pernyataan SQL
    $stmt = $conn->prepare($sql);

    // Bind parameter
    $stmt->bind_param("iis", $id_produk, $rating, $review);

    // Jalankan pernyataan SQL
    if ($stmt->execute()) {
        // Jika penyimpanan berhasil, tampilkan pesan sukses dengan alert
        echo "<script>alert('Rating dan review berhasil disimpan.');</script>";
        // Redirect ke halaman produk
        header("Location: detail.php?id=$id_produk");
        exit();
    } else {
        // Jika terjadi kesalahan, tampilkan pesan error dengan alert
        echo "<script>alert('Rating dan review gagal disimpan.');</script>";
        // Redirect ke halaman produk
        header("Location: detail.php?id=$id_produk");
        exit();
    }
} else {
    // Jika metode request bukan POST, kembalikan ke halaman produk dengan pesan error
    header("Location: detail.php?id=$id_produk&error=1");
    exit();
}
?>
