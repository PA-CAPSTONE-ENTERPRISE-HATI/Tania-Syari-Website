<?php
// Mulai sesi jika belum dimulai
session_start();

// Sisipkan file koneksi ke database
include "db.php";

if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Query untuk mengambil data produk berdasarkan ID
    $id_produk = $_GET['id'];
    $sql = "SELECT * FROM produk WHERE id_produk = '$id_produk'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Jika produk sudah ada dalam session, tambahkan kuantitasnya
        if (isset($_SESSION['cart'][$id_produk])) {
            $_SESSION['cart'][$id_produk]['quantity']++;
        } else {
            // Jika produk belum ada dalam session, tambahkan produk baru dengan kuantitas 1
            $_SESSION['cart'][$id_produk] = array(
                'id_produk' => $row['id_produk'],
                'nama_model' => $row['nama_model'],
                'harga_produk' => $row['harga_produk'],
                'foto_produk' => $row['foto_produk'],
                'deskripsi_produk' => $row['deskripsi_produk'],
                'quantity' => 1
            );
        }

        // Arahkan proses ke halaman cart.php setelah menambahkan produk
        header("Location: cart.php");
        exit();
    } else {
        // Pesan jika produk tidak ditemukan
        echo "<script>alert('Produk tidak ditemukan.')</script>";
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Tania Syar'i</title>
    <link href="../syari/assets/images/tania_syari.png" rel="icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD2Hhh_14Uam62GXGaTMcXWhhVkYg0EbDY&callback=initMap" async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Custom CSS File Link -->
    <link rel="stylesheet" href="assets/css/rating.css">
    <link rel="stylesheet" href="assets/css/slider.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/convo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"><!-- font awesome cdn link -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"><!-- Google font cdn link -->
</head>

<body>
    <!-- HEADER SECTION -->
    <?php include 'partials/header.php'; ?>

    <!-- HERO SECTION -->
    <section class="home" id="home">
        <div class="background-image"></div> <!-- Background image container -->
        <div class="content">
            <h3>Selamat Datang di Tania Syar'i</h3>
            <p>
                <strong>Kami buka dari 10.00 - 20.00</strong>
            </p>
            <a href="#menu" class="btn btn-dark text-decoration-none">Pesan Skarang!</a>
        </div>
    </section>
    <section class="rekom" id="rekom">
        <h1 class="heading"><span>Saran untuk</span> Anda</h1>
        <div class="container">
            <div class="slider-wrapper">
                <button id="prev-slide" class="slide-button material-symbols-rounded">
                    &lt;
                </button>
                <ul class="image-list">
                    <li>
                        <img class="image-item" src="produk/Alqiblat Daily.jpeg" alt="img-1" onclick="redirectToProduct('Alqiblat Daily')" />
                        <p class="product-name">Alqiblat Daily</p>
                    </li>
                    <li>
                        <img class="image-item" src="produk/Arsyila Series.jpeg" alt="img-2" onclick="redirectToProduct('Arsyila Series')" />
                        <p class="product-name">Arsyila Series</p>
                    </li>
                    <li>
                        <img class="image-item" src="produk/Syarifah Series.jpeg" alt="img-3" />
                        <p class="product-name">Syarifah Series</p>
                    </li>
                    <li>
                        <img class="image-item" src="produk/Angela Raya Mom Regina.PNG" alt="img-4" />
                        <p class="product-name">Angela Raya Mom Regina</p>
                    </li>
                    <li>
                        <img class="image-item" src="produk/Salwah Serief by Farfadh.jpeg" alt="img-5" />
                        <p class="product-name">Salwah Serief by Farfadh</p>
                    </li>
                </ul>
                <button id="next-slide" class="slide-button material-symbols-rounded">
                    &gt;
                </button>
            </div>
            <div class="slider-scrollbar">
                <div class="scrollbar-track">
                    <div class="scrollbar-thumb"></div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function redirectToProduct(productName) {
            window.location.href = "index.php?nama_model=" + encodeURIComponent(productName);
        }
    </script>


    <!-- ABOUT US SECTION -->
    <section class="about" id="about">
        <h1 class="heading"> <span>Tentang</span> Kami</h1>
        <div class="row g-0">
            <div class="image">
                <img src="assets/images/tania.jpg" alt="" class="img-fluid">
            </div>
            <div class="content">
                <h3>Selamat Datand di Tania Syar'i</h3>
                <p>
                    Tania Syari adalah UMKM yang menyediakan busana syar'i branded dengan harga bersahabat.
                    Kami adalah agen resmi berbagai brand ternama seperti Alya Syari, AC Original, Arsyakayla, dan lainnya.
                    Kami memprioritaskan kualitas produk, keaslian, dan pelayanan terbaik untuk memastikan kepuasan pelanggan.
                    Tania Syari hadir untuk menjawab kebutuhan busana syar'i Anda dengan gaya dan harga yang tepat.
                </p>
                <p>
                    Kami percaya bahwa kepuasan pelanggan adalah kunci kesuksesan kami.
                    Oleh karena itu, Tania Syari selalu berusaha untuk memberikan pengalaman belanja yang memuaskan bagi setiap pelanggan.
                    Kami tidak hanya menyediakan produk berkualitas tinggi, tetapi juga menyediakan layanan pelanggan yang responsif dan personal.
                    Dengan mengutamakan integritas dan kejujuran dalam setiap interaksi, kami berharap dapat membangun hubungan yang kokoh dengan komunitas kami dan menjadi destinasi utama bagi mereka yang mencari busana syar'i yang berkualitas dan terjangkau.
                </p>
                <!-- <a href="#" class="btn btn-dark text-decoration-none">Lebih Lanjut</a> -->
            </div>
        </div>
    </section>

    <!-- MENU SECTION -->
    <section class="menu" id="menu">
        <h1 class="heading"> Katalog <span> Kami </span></h1>
        <div class="box-container">
            <div class="container">
                <div class="row">
                    <?php
                    // Query untuk mengambil data produk
                    $sql = "SELECT * FROM produk";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<div class='col-md-4'>";
                            echo "<div class='box'>";
                            echo "<img src='produk/" . $row['foto_produk'] . "' alt='' class='product-img'>";
                            echo "<h3 class='product-title'>" . $row['nama_model'] . "</h3>";
                            echo "<div class='price'>" . $row['harga_produk'] . "</div>";
                            echo "<a href='index.php?id=" . $row['id_produk'] . "' class='btn add-cart'>Simpan</a>";
                            echo "<a href='detail.php?id=" . $row['id_produk'] . "' class='btn detail'>Detail Produk</a>";
                            echo "</div>";
                            echo "</div><br />";
                        }
                    } else {
                        echo "Tidak ada produk yang tersedia.";
                    }

                    // Tutup koneksi database
                    $conn->close();
                    ?>
                </div>
            </div>
        </div>
    </section>


    <!-- RATING SECTION -->
    <section class="rating" id="rating">
        <h1 class="heading"><span>Ulasan</span></h1>
        <?php include 'partials/rating.php'; ?>
    </section>

    <!-- CONTACT US SECTION -->
    <section class="contact" id="contact">
        <h1 class="heading"><span>Hubungi</span> Kami</h1>
        <div class="row">
            <div id="map" class="map pull-left"></div>
            <form name="contact" method="POST" action="https://formspree.io/f/xayzavgb">
                <h3> Hubungi Kami</h3>
                <div class="inputBox">
                    <span class="fas fa-envelope"></span>
                    <input type="email" name="email" placeholder="Email Address">
                </div>
                <div class="inputBox">
                    <textarea name="message" placeholder="Enter your message..."></textarea>
                </div>
                <button type="submit" class="btn">Hubungi Sekarang</button>
            </form>
        </div>
    </section>

    <!-- FOOTER SECTION -->
    <section class="footer">
        <div class="footer-container">
            <div class="logo">
                <img src="assets/images/tania_syari.png" class="img"><br />
                <i class="fas fa-phone"></i>
                <p>+62 811-5523-120</p><br />
                <i class="fab fa-instagram"></i>
                <p>@taniasyari</p><br />
            </div>
            <div class="support">
                <h2>Support</h2>
                <br />
                <a href="contact">Kontak Kami</a>
            </div>
            <div class="company">
                <h2>HATI</h2>
                <br />
                <a href="#">Tentang Kami</a>
                <a href="#">Sumber Daya</a>
                <a href="#">Kemitraan</a>
            </div>
            <div class="credit">
                <hr /><br />
                <h2>Tania Syar'i © 2024 | All Rights Reserved.</h2>
            </div>
        </div>
    </section>


    <!-- JS File Link -->
    <script src="assets/js/rating.js"></script>
    <script src="assets/js/slider.js"></script>
    <script src="assets/js/googleSignIn.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="assets/js/responses.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="assets/js/convo.js"></script>
    <script src="assets/js/price.js"></script>

    <script>
        // CODE FOR THE FORMSPREE
        window.onbeforeunload = () => {
            for (const form of document.getElementsByTagName('form')) {
                form.reset();
            }
        }

        // CODE FOR THE GOOGLE MAPS API
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: -0.4931941,
                    lng: 117.1425159
                },
                zoom: 15
            });

            var marker = new google.maps.Marker({
                position: {
                    lat: -0.4931941,
                    lng: 117.1425159
                },
                map: map,
                title: 'Your Location'
            });
        }

        // CODE FOR THE SHOW MORE & SHOW LESS BUTTON IN MENU
        $(document).ready(function() {
            $(".row-to-hide").hide();
            $("#showHideBtn").text("SHOW MORE");
            $("#showHideBtn").click(function() {
                $(".row-to-hide").toggle();
                if ($(".row-to-hide").is(":visible")) {
                    $(this).text("SHOW LESS");
                } else {
                    $(this).text("SHOW MORE");
                }
            });
        });
    </script>
</body>

</html>