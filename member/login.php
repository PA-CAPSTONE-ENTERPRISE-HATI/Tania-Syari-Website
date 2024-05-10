<?php
include '../db.php';
session_start();

// Pastikan koneksi ke database sudah dibuat dan variabel $conn sudah didefinisikan
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// When form submitted, check and create user session.
if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Gunakan parameterized query untuk mencegah SQL injection
    $query = "SELECT * FROM member WHERE username=? AND password=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Periksa jumlah baris yang ditemukan
    if (mysqli_num_rows($result) == 1) {
        // Ambil data member dari hasil query
        $member = mysqli_fetch_assoc($result);

        // Set session username dan id_member
        $_SESSION['username'] = $member['username'];
        $_SESSION['id_member'] = $member['id_member'];

        // Ambil data session keranjang jika ada
        if (isset($_GET['cartItems'])) {
            $_SESSION['cartItems'] = json_decode(urldecode($_GET['cartItems']), true);
        }

        // Redirect ke halaman index.php
        header("Location: index.php");
        exit;
    } else {
        $errorMessage = "Username atau Password salah. Silakan coba lagi.";
    }
}
?>



<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Member | Login Form</title>
    <link rel="stylesheet" href="../assets/css/login.css" />
    <link rel="icon" type="image/x-icon" href="../assets/images/asterix.png">
    <script src="https://accounts.google.com/gsi/client" async defer></script>
</head>

<body>
    <form class="form" method="post" name="login">
        <center>
            <img src="../assets/images/tania_syari.png" alt="" class="img img-fluid">
        </center>
        <hr />
        <h1 class="login-title">Login</h1>
        <?php if (isset($errorMessage)) : ?>
            <p class="error-message"><?php echo $errorMessage; ?></p>
        <?php endif; ?>
        <input type="text" class="login-input" name="username" placeholder="Username" autofocus="true" />
        <input type="password" class="login-input" name="password" placeholder="Password" />
        <input type="submit" value="Login" name="submit" class="login-button" />
        <a href="../index.php" class="back-button">Back to Home</a>
        <!-- <input type="button" onclick="window.location.href='../index.php'" value="Back to Home" class="login-button" /> -->
        <hr />
    </form>

    <script src="js/script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</body>

</html>