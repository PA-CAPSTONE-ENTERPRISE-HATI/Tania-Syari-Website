<?php
session_start();
require '../db.php';

?>

<html>

<head>
  <title>Admin Login</title>
  <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <link rel="stylesheet" href="../assets/css/adminlogin.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
  <link href="../assets/images/tania_syari.png" rel="icon">
</head>

<body>

  <div class="login-form">
    <h2>Login Admin</h2>
    <form method="POST">
      <div class="input-field">
        <i class="bi bi-person-circle"></i>
        <input type="text" placeholder="Username" name="username">
      </div>
      <div class="input-field">
        <i class="bi bi-shield-lock"></i>
        <input type="password" placeholder="Password" name="password">
      </div>
      <button type="submit" name="login">Login</button>
      <a href="../index.php" class="back-button">Back to Home</a>
    </form>
  </div>

  <?php
  if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Memeriksa kecocokan username dan password di database
    $sql = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username'");
    $admin = mysqli_fetch_assoc($sql);

    // Memeriksa apakah ada data admin dengan username yang dimasukkan
    if ($admin) {
        // Memeriksa kecocokan password mentah
        if ($password == $admin['password']) {
            $_SESSION['admin'] = $admin['username'];
            echo "<meta http-equiv='refresh' content='1;url=index.php'>";
        } else {
            echo "<script>alert('Username atau Password Anda Salah');</script>";
            echo "<meta http-equiv='refresh' content='1;url=loginadmin.php'>";
        }
    } else {
        echo "<script>alert('Username atau Password Anda Salah');</script>";
        echo "<meta http-equiv='refresh' content='1;url=loginadmin.php'>";
    }
  }
  ?>


</body>

</html>
