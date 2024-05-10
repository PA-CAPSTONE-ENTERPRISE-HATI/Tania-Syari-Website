<?php
// Mulai sesi jika belum dimulai
session_start();

// Hapus semua data dari session cart
unset($_SESSION['cart']);

// Kirim respons JSON untuk memberi tahu klien bahwa penghapusan berhasil
$response = array(
    'success' => true,
    'message' => 'Semua barang dari keranjang telah dihapus.'
);
echo json_encode($response);
?>
