<?php
// Mulai sesi jika belum dimulai
session_start();

// Periksa apakah permintaan POST memiliki data yang diperlukan
if (isset($_POST['cart_id']) && isset($_POST['quantity'])) {
    // Ambil nilai cart_id dan quantity dari permintaan POST
    $cartId = $_POST['cart_id'];
    $newQuantity = $_POST['quantity'];

    // Periksa apakah quantity yang baru valid (bilangan bulat positif)
    if (is_numeric($newQuantity) && intval($newQuantity) > 0) {
        // Perbarui quantity produk dalam session
        if (isset($_SESSION['cart'][$cartId])) {
            $_SESSION['cart'][$cartId]['quantity'] = intval($newQuantity);

            // Kirim respons JSON untuk memberi tahu klien bahwa pembaruan berhasil
            $response = array(
                'success' => true,
                'message' => 'Quantity produk berhasil diperbarui.'
            );
            echo json_encode($response);
            exit(); // Keluar dari skrip setelah mengirim respons
        } else {
            // Jika cart_id tidak ditemukan dalam session
            $response = array(
                'success' => false,
                'message' => 'Produk tidak ditemukan dalam keranjang.'
            );
            echo json_encode($response);
            exit(); // Keluar dari skrip setelah mengirim respons
        }
    } else {
        // Jika quantity tidak valid
        $response = array(
            'success' => false,
            'message' => 'Quantity harus berupa bilangan bulat positif.'
        );
        echo json_encode($response);
        exit(); // Keluar dari skrip setelah mengirim respons
    }
} else {
    // Jika permintaan POST tidak mengandung data yang diperlukan
    $response = array(
        'success' => false,
        'message' => 'Data yang diperlukan tidak ditemukan dalam permintaan.'
    );
    echo json_encode($response);
    exit(); // Keluar dari skrip setelah mengirim respons
}
?>
