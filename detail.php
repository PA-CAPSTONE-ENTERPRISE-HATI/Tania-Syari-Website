<?php 
    session_start();
    require 'db.php';

    $id_produk = $_GET["id"];

    $sql = mysqli_query($conn,"SELECT * FROM produk WHERE id_produk = '$id_produk'");
    $detail = mysqli_fetch_assoc($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
<?php include 'partials/header.php'; ?>
<section class="row justify-content-center" style="margin-top: 150px;">
    <div class="col-md-8">
        <div class="row justify-content-center align-items-center mb-4">
            <div class="col-lg-6 col-md-12 mt-4 text-center">
                <img src="produk/<?php echo $detail["foto_produk"];?>" alt="" class="img-fluid shadow">
            </div>
            <div class="col-lg-6 col-md-12 mt-4">
                <h2><strong><?php echo $detail["nama_model"];?></strong></h2>
                <h4>Rp <?php echo number_format($detail["harga_produk"], 0, ',', '.');?></h4>
                <p><?php echo nl2br($detail["deskripsi_produk"]);?></p>
                <a class="btn addcart" href="index.php?id=<?php echo $id_produk; ?>">Tambah ke Keranjang</a>
            </div>
        </div>

        <div class="row justify-content-center mt-5">
                <h3>Beri Rating dan Review</h3>
                <form action="proses_rating.php" method="POST">
                    <input type="hidden" name="id_produk" value="<?php echo $id_produk; ?>">    
                    <div class="form-group">
                        <label for="rating">Rating : </label>
                        <input type="number" class="form-control" name="rating" id="rating" min="1" max="5" required>
                    </div>
                    <div class="form-group">
                        <label for="review">Review : </label>
                        <textarea class="form-control" name="review" id="review" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
        </div>

        <div class="row justify-content-center mt-5 mb-6">
                <h3>Rating dan Review Produk</h3>
                <?php
                $query_rating = mysqli_query($conn, "SELECT * FROM rating WHERE id_produk = '$id_produk'");
                if (mysqli_num_rows($query_rating) > 0) {
                    while ($row_rating = mysqli_fetch_assoc($query_rating)) {
                        echo '<div class="fw-bold d-flex align-items-center mb-2 mt-3">';
                        echo '<span class="text-warning">';
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $row_rating['rating']) {
                                echo '<i class="bi bi-star-fill"></i>';
                            } else {
                                echo '<i class="bi bi-star"></i>';
                            }
                        }
                        echo '</span>';
                        echo '<span class="ms-2">' . number_format($row_rating['rating'], 1) . '</span>';
                        echo '</div>';
                        echo '<div>' . $row_rating['review'] . '</div>';
                    }
                } else {
                    echo "<p>Belum ada rating dan review untuk produk ini.</p>";
                }
                ?>
        </div>
    </div>
</section>

<script src="assets/js/main.js"></script>

</body>
</html>