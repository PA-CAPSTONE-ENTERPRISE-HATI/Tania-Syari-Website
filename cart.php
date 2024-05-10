<?php
// Mulai sesi jika belum dimulai
session_start();

// Sisipkan file koneksi ke database
include "db.php";

$subtotal = 0;

// Cek apakah session keranjang tidak kosong
if (!empty($_SESSION['cart'])) {
    // Mendapatkan array produk dari session
    $cartItems = $_SESSION['cart'];
    // Hitung total item dalam keranjang
    $totalItems = count($cartItems);

    // Loop untuk mendapatkan detail produk dari database
    foreach ($cartItems as $id_produk => $produk) {
        // Ambil harga produk dari database
        $sql = "SELECT * FROM produk WHERE id_produk = '$id_produk'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Hitung subtotal dengan mengalikan harga produk dari database dengan quantity yang disimpan dalam session
            $subtotal += $row['harga_produk'] * $produk['quantity'];
        }
    }

    // Tambahkan subtotal ke dalam session cartItems
    $_SESSION['cartItems']['subtotal'] = $subtotal;
} else {
    // Jika session keranjang kosong
    $cartItems = [];
    $totalItems = 0;
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
    <link href="../baju/assets/images/tania_syari.png" rel="icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD2Hhh_14Uam62GXGaTMcXWhhVkYg0EbDY&callback=initMap" async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Custom CSS File Link -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"><!-- font awesome cdn link -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"><!-- Google font cdn link -->
</head>


<body>
    <!-- HEADER SECTION -->
    <?php include 'partials/header.php'; ?>
    
    
<section class="py-5 mb-8" style="margin-top: 200px;">
    <div class="container">
        <?php if (!empty($cartItems)) : ?>
            <div class="row w-100">
                <div class="col-lg-12 col-md-12 col-12">
                    <h3 class="display-5 mb-2 text-center fw-bolder">Keranjang</h3>
                    <p class="mb-5 text-center">
                        <i class="fw-bolder"><?php echo $totalItems; ?></i> Item di Keranjang
                    </p>

                    <table id="shoppingCart" class="table table-condensed table-responsive">
                        <thead>
                            <tr class="text-center">
                                <th style="width: 60%">Produk</th>
                                <th style="width: 15%">Harga</th>
                                <th style="width: 10%">Jumlah Barang</th>
                                <th style="width: 15%">Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
    <?php foreach ($cartItems as $id_produk => $quantity) : ?>
        <?php
        // Ambil detail produk dari database
        $sql = "SELECT * FROM produk WHERE id_produk = '$id_produk'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        }
        ?>
        <tr>
            <td>
                <div class="row">
                    <div class="col-md-3 text-left">
                        <img src="produk/<?php echo $row['foto_produk']; ?>" alt="Product Image" class="img-fluid d-none d-md-block rounded mb-2 shadow" />
                    </div>
                    <div class="col-md-9 text-left mt-sm-2">
                        <h4><?php echo $row['nama_model']; ?></h4>
                        <p><?php echo $row['deskripsi_produk']; ?></p>
                    </div>
                </div>
            </td>
            <td class="text-center"><h5 class="fw-bolder mb-1">Rp <?php echo number_format($row['harga_produk'],0, ',', '.' ); ?></h5></td>
            <td class="text-center">
                <!-- Input field untuk quantity dengan nilai dari session -->
                <input type="number" class="form-control form-control-lg text-center" value="<?php echo $_SESSION['cart'][$id_produk]['quantity']; ?>" min="1" onchange="updateQuantity(<?php echo $id_produk; ?>, this.value)" />
            </td>
            <td class="text-center">
                <button class="btn btn-danger" style="background-color: red; padding: 0.500rem 1rem; border: none; margin-top: 0px;" onclick="removeItem(<?php echo $id_produk; ?>)">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </td>

        </tr>
    <?php endforeach; ?>
</tbody>
                    </table>

                    <div class="text-end">
                        <h4>Subtotal:</h4>
                        <h2 class="fw-bolder">Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></h2>
                    </div>

                </div>
                <div class="d-flex justify-content-between mb-5">
                    <a href="#" onclick="window.history.back();" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <div class="text-right">
                    <a href="#" onclick="clearCart();" class="btn btn-danger" style="background-color: red; margin-right: 5px;">
                        <i class="bi bi-trash"></i> Bersihkan
                    </a>
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#memberModal">Lanjutkan ke Checkout <i class="bi bi-arrow-right"></i></a>

                <!-- Modal -->
                <div class="modal fade" id="memberModal" tabindex="-1" aria-labelledby="memberModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="memberModalLabel">Apakah kamu memiliki member?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Jika Anda adalah member, silakan login untuk melanjutkan.
                    </div>
                    <div class="modal-footer">
                        <a href="checkout.php?cartItems=<?php echo urlencode(json_encode($cartItems)); ?>&subtotal=<?php echo $subtotal; ?>" class="btn btn-primary">Tidak</a>
                        <a href="member/login.php?cartItems=<?php echo urlencode(json_encode($cartItems)); ?>&subtotal=<?php echo $subtotal; ?>" class="btn btn-primary">Ya, Login</a>
                    </div>
                    </div>
                </div>
                </div>
                    </div>   
                </div>
            </div>
        <?php else : ?>
            <div class="row w-100">
                <div class="col-lg-12 col-md-12 col-12">
                    <h3 class="display-5 mb-2 text-center fw-bolder">Keranjang</h3>
                </div>
                <div class="h3 fw-bolder text-center">
                    Tidak ada barang di keranjang
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

    <!-- Include your footer content here -->

    <!-- Include your scripts here -->
</body>

</html>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

<!-- Core plugin JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

<script>
    
    function clearCart() {
        if (confirm('Apakah Anda yakin ingin menghapus semua barang dari keranjang?')) {
            fetch('clear_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: ''
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    window.location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    }
function updateQuantity(cartId, newQuantity) {
    fetch('update_quantity.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `cart_id=${cartId}&quantity=${newQuantity}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

    function removeItem(cartId) {
        if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
            fetch('remove_item.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `cart_id=${cartId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    }

    function checkout() {
    fetch('checkout.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: ''
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            window.location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
</script>
