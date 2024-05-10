<?php
require "../db.php";

// Hapus data terkait dari tabel rating
$sql_delete_rating = mysqli_query($conn, "DELETE FROM rating WHERE id_produk='$_GET[id]'");

// Periksa apakah query berhasil dijalankan
if (!$sql_delete_rating) {
    // Query gagal, tangani kesalahan
    echo "Error: " . mysqli_error($conn);
} else {
    // Query berhasil, lanjutkan untuk menghapus produk dari tabel produk
    $sql_delete_produk = mysqli_query($conn, "DELETE FROM produk WHERE id_produk='$_GET[id]'");

    // Periksa apakah query berhasil dijalankan
    if ($sql_delete_produk) {
        // Produk berhasil dihapus
        echo "<script>alert('Produk terhapus');</script>";
        echo "<script>location='produk.php';</script>";
    } else {
        // Produk gagal dihapus, tangani kesalahan
        echo "Error: " . mysqli_error($conn);
    }
}
?>
