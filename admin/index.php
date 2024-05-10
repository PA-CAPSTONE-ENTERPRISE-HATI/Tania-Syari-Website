<?php
  session_start();

  if (!isset($_SESSION['admin'])) 
  {
    echo "<script>location='loginadmin.php';</script>";
    header('Location: loginadmin.php');
    exit();
  }
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/dashboard.css">
    <script src="../assets/js/admin.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../assets/js/script.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="../assets/images/tania_syari.png" rel="icon" >
    <title>Dashboard Admin</title>
</head>
<body>
    <header class="header">
        <div class="logo">
            <img src="../assets/images/tania_syari.png" alt="Silhouette Image"><br><br>
            <h1>Tania Syar'i</h1>
        </div>
        <nav class="navigation">
            <ul class="nav-menu">
                <li><a href="../index.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <div class="sidebar">
            <ul class="sidebar-menu">
                <li><a href="index.php"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="./produk.php"><i class="fa fa-edit"></i> Data Produk</a></li>
                <li class="dropdown">
                    <a href="#content" class="dropdown-btn"><i class="fa fa-user-plus"></i> Member</a>
                    <div class="dropdown-content">
                        <a href="./member.php">Data Member</a>
                        <a href="./tambah_member.php">Tambah Membership</a>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="#content" class="dropdown-btn"><i class="fa fa-shopping-basket"></i> Pesanan</a>
                    <div class="dropdown-content">
                        <a href="./pesanan_non.php">Pesanan Non-Member</a>
                        <a href="./pesanan_member.php">Pesanan Member</a>
                    </div>
                </li>

            </ul>
        </div>

        <div class="content">
            <div class="dashboard-overview">
                <h2>Dashboard Overview</h2>
                <p>Selamat Datang di Admin Dashboard. Disini, kamu bisa mengelola produk, melihat data penjualan, melihat data pelanggan, dan menambahkan member.</p>
                <p>semua data disini bersifat RAHASIA!</p>
            </div>
            <br>
            <div class="dashboard-container">
                <div class="dashboard-widget pie-chart-container">
                    <h2>Produk Terlaris</h2>
                    <canvas id="userPieChart" class="pie-chart" width="400" height="400"></canvas>
                </div>

                <div class="dashboard-widget userGrowth-chart">
                    <h2>Laba Tertinggi</h2>
                    <canvas id="userLineChart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>


    <footer class="footer">
        <p>&copy; Tania Syar'i 2024 | All Rights Reserved.</p>
    </footer>

    <script>
        var userPieData = {
            labels: ['Arsyila Seris', 'Syarifah Series', 'Salwah Series', 'Angela Raya Mom Regina', 'Alqiblat Daily' ],
            datasets: [{
                data: [40, 80, 50, 75, 65],
                backgroundColor: ['#36a2eb', '#ffcd56', '#ff6384', 'pink', 'blue']
            }]
        };

        var userLineData = {
            labels: ['Arsyila Seris', 'Syarifah Series', 'Salwah Series', 'Angela Raya Mom Regina', 'Alqiblat Daily'],
            datasets: [{
                label: 'Number of Users',
                data: [250, 350, 600, 450, 550],
                borderColor: '#ff6384',
                fill: false
            }]
        };

        var userPieChart = new Chart(document.getElementById('userPieChart'), {
            type: 'pie',
            data: userPieData
        });

        var userLineChart = new Chart(document.getElementById('userLineChart'), {
            type: 'line',
            data: userLineData
        });
    </script>

</body>
</html>
