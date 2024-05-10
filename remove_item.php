<?php
// Mulai sesi jika belum dimulai
session_start();

// Sisipkan file koneksi ke database
include "db.php";

// Pastikan cart_id ada dalam request
if (isset($_POST['cart_id'])) {
    // Ambil cart_id dari request
    $cart_id = $_POST['cart_id'];

    // Periksa apakah produk dengan cart_id tersebut ada dalam session
    if (isset($_SESSION['cart'][$cart_id])) {
        // Hapus produk dari session
        unset($_SESSION['cart'][$cart_id]);

        // Kirim respons JSON ke client
        echo json_encode(array('success' => true, 'message' => 'Item berhasil dihapus.'));
        exit();
    } else {
        // Kirim respons JSON jika produk tidak ditemukan dalam session
        echo json_encode(array('success' => false, 'message' => 'Item tidak ditemukan di keranjang.'));
        exit();
    }
} else {
    // Kirim respons JSON jika cart_id tidak disertakan dalam request
    echo json_encode(array('success' => false, 'message' => 'Cart ID tidak diberikan.'));
    exit();
}
?>
