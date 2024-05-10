<?php
// Include database connection file
include "db.php";

// Cek apakah ada data yang dikirim dari form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    // Tangkap data yang dikirimkan melalui form
    $id_pesanan = $_POST["id_pesanan"];

    // Lokasi penyimpanan file yang diupload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek apakah file adalah gambar atau bukan
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        if ($check !== false) {
            echo "File adalah gambar - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File bukan gambar.";
            $uploadOk = 0;
        }
    }

    // Cek apakah file sudah ada
    if (file_exists($target_file)) {
        echo "Maaf, file sudah ada.";
        $uploadOk = 0;
    }

    // Cek ukuran file
    if ($_FILES["file"]["size"] > 500000) {
        echo "Maaf, ukuran file terlalu besar.";
        $uploadOk = 0;
    }

    // Izinkan format file tertentu
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        echo "Maaf, hanya file JPG, JPEG, PNG & GIF yang diperbolehkan.";
        $uploadOk = 0;
    }

    // Cek jika $uploadOk bernilai 0
    if ($uploadOk == 0) {
        echo "Maaf, file tidak diunggah.";
    } // Jika semua kondisi terpenuhi, coba unggah file
    else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            // Simpan data bukti transfer ke database
            $file_name = basename($_FILES["file"]["name"]);
            $sql_bukti = "INSERT INTO bukti (id_pesanan, foto_bukti) VALUES ('$id_pesanan', '$file_name')";
            if ($conn->query($sql_bukti) === TRUE) {
                echo '<script>alert("File berhasil diunggah. Data bukti transfer berhasil disimpan.");</script>';
                echo '<script>window.location.replace("index.php");</script>';
            } else {
                echo "Error: " . $sql_bukti . "<br>" . $conn->error;
            }
        } else {
            echo "Maaf, terjadi kesalahan saat mengunggah file.";
        }
    }
} else {
    echo "Maaf, tidak ada data yang dikirimkan.";
}
?>
