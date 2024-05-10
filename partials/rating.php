<?php 
    require 'db.php';

    // Query untuk mengambil data rating dan nama produk
    $query_rating = "SELECT produk.nama_model, rating.rating, rating.review
    FROM rating
    INNER JOIN produk ON rating.id_produk = produk.id_produk
    ORDER BY produk.nama_model";
    $result_rating = mysqli_query($conn, $query_rating);
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<div class="mt-5">
    <div class="d-flex justify-content-center align-items-center">
        <div class="col-md-8 bg-white shadow rounded-lg p-4" style="border-radius: 2rem;">
            <?php
            $current_product = null;
            while ($row_rating = mysqli_fetch_assoc($result_rating)) {
                if ($row_rating['nama_model'] !== $current_product) {
                    // Tampilkan nama produk hanya jika berbeda dari produk sebelumnya
                    echo "<h4 class='mt-4'>" . $row_rating['nama_model'] . "</h4>";
                    $current_product = $row_rating['nama_model'];
                }
                // Tampilkan bintang rating dan review
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
            ?>
        </div>
    </div>
</div>
