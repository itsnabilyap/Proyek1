<?php
session_start();

include 'database.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit;
}

// total data
$totalPesanan = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM detail_pesanan"));
$totalDiproses = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM detail_pesanan WHERE status_pesanan='diproses'"));
$totalSelesai = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM detail_pesanan WHERE status_pesanan='selesai'"));
$totalBatal = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM detail_pesanan WHERE status_pesanan='dibatalkan'"));

// ambil data pesanan
$query = mysqli_query($conn, "SELECT * FROM detail_pesanan ORDER BY id_pesanan DESC");

?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Menu - Admin</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
* {
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body {
    display:flex;
    background:#f5f5f5;
}

/* SIDEBAR */
.sidebar {
    width:240px;
    height:100vh;
    background: #728663;
    color:white;
    padding:20px;
    position:fixed;
}

.logo {
    display:flex;
    align-items:center;
    gap:10px;
    margin-bottom:30px;
}

.logo img {
    width:50px;
    border-radius:50%;
}

.menu a {
    display:flex;
    align-items:center;
    padding:12px;
    margin:8px 0;
    color:white;
    text-decoration:none;
    border-radius:10px;
}

.menu a.active,
.menu a:hover {
    background:#8FA083;
}

.menu i {
    margin-right:10px;
}


/* CONTENT */

.main{
    margin-left:250px;
    padding:30px;
    width:100%;
}

.title{
    display:flex;
    align-items:center;
    gap:15px;
    margin-bottom:30px;
}

.title i{
    font-size:50px;
}

.title h1{
    font-size:55px;
}

/* CARD */

.stats{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
    margin-bottom:25px;
}

.card{
    background:white;
    border-radius:18px;
    padding:20px;
    display:flex;
    align-items:center;
    gap:18px;
    border:1px solid #ddd;
}

.card i{
    width:60px;
    height:60px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:28px;
}

.green{
    color:#18b76a;
    border:2px solid #18b76a;
}

.yellow{
    color:#f4c21b;
    border:2px solid #f4c21b;
}

.red{
    color:#ff5722;
    border:2px solid #ff5722;
}

.card h2{
    font-size:40px;
}

.card p{
    font-size:14px;
    color:#666;
}

/* TABLE */

.table-box{
    background:white;
    border-radius:18px;
    padding:25px;
    border:1px solid #ddd;
}

.top-table{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.filter{
    display:flex;
    gap:10px;
}

.filter button{
    border:none;
    padding:10px 20px;
    border-radius:10px;
    color:white;
    font-weight:600;
    cursor:pointer;
}

.semua{ background:#748663; }
.proses{ background:#f4c21b; }
.selesai{ background:#18b76a; }
.batal{ background:#ff5722; }

.search{
    display:flex;
    gap:10px;
}

.search input{
    padding:10px 15px;
    border-radius:10px;
    border:1px solid #ddd;
}

table{
    width:100%;
    border-collapse:collapse;
}

table th{
    background:#f1f1f1;
    padding:18px;
    text-align:center;
}

table td{
    padding:18px;
    border-bottom:1px solid #ddd;
    text-align:center;
}

.nama{
    text-align:left;
}

.nama small{
    color:#999;
}

.badge{
    padding:8px 18px;
    border-radius:10px;
    color:white;
    font-weight:600;
}

.bg-green{ background:#18b76a; }
.bg-yellow{ background:#f4c21b; }
.bg-red{ background:#ff5722; }

.view{
    width:45px;
    height:45px;
    border-radius:10px;
    border:1px solid #ddd;
    background:white;
    cursor:pointer;
}

.pagination{
    display:flex;
    justify-content:flex-end;
    gap:10px;
    margin-top:20px;
}

.pagination a{
    width:35px;
    height:35px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:8px;
    background:#eee;
    color:black;
    text-decoration:none;
}

.pagination a.active{
    background:#748663;
    color:white;
}

</style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="logo">
        <img src="logo-brand.jpeg">
        <div>
            <b>C2VIN Catering</b><br>
            <small>Admin Panel</small>
        </div>
    </div>

    <div class="menu">
        <a href="ddashboard.php"><i class="bi bi-house"></i>Dashboard</a>
        <a href="dmenu.php"><i class="bi bi-list"></i>Menu</a>
        <a href="dpesanan.php" class="active"><i class="bi bi-receipt"></i>Pesanan</a>
    </div>
</div>

<div class="main">

    <div class="title">
        <i class="fa fa-table-list"></i>
        <h1>Pesanan</h1>
    </div>

    <!-- STATS -->

    <div class="stats">

        <div class="card">
            <i class="fa fa-bag-shopping green"></i>

            <div>
                <h3>Semua Pesanan</h3>
                <h2><?= $totalPesanan ?></h2>
                <p>Total semua pesanan</p>
            </div>
        </div>

        <div class="card">
            <i class="fa fa-clock yellow"></i>

            <div>
                <h3>Di Proses</h3>
                <h2><?= $totalDiproses ?></h2>
                <p>Sedang diproses</p>
            </div>
        </div>

        <div class="card">
            <i class="fa fa-check green"></i>

            <div>
                <h3>Selesai</h3>
                <h2><?= $totalSelesai ?></h2>
                <p>Pesanan selesai</p>
            </div>
        </div>

        <div class="card">
            <i class="fa fa-xmark red"></i>

            <div>
                <h3>Dibatalkan</h3>
                <h2><?= $totalBatal ?></h2>
                <p>Pesanan dibatalkan</p>
            </div>
        </div>

    </div>

    <!-- TABLE -->

    <div class="table-box">

        <div class="top-table">

            <div class="filter">
                <button class="semua">Semua</button>
                <button class="proses">Diproses</button>
                <button class="selesai">Selesai</button>
                <button class="batal">Dibatalkan</button>
            </div>

            <div class="search">
                <input type="date">
                <input type="text" placeholder="Cari Pesanan">
            </div>

        </div>

        <table>

            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Nama Pelanggan</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

            <?php while($data = mysqli_fetch_assoc($query)) { ?>

                <tr>

                    <td>#ORD-C2VN-<?= str_pad($data['id_pesanan'], 3, '0', STR_PAD_LEFT); ?></td>

                    <td class="nama">
                        <b><?= $data['nama'] ?></b><br>
                        <small><?= $data['no_hp'] ?></small>
                    </td>

                    <td><?= date('d M Y', strtotime($data['tanggal_pemesanan'])) ?></td>

                    <td>
                        Rp. <?= number_format($data['total_harga'],0,',','.') ?>
                    </td>

                    <td>

                        <?php
                        if($data['status_pesanan']=="selesai"){
                            echo "<span class='badge bg-green'>Selesai</span>";
                        }
                        elseif($data['status_pesanan']=="diproses"){
                            echo "<span class='badge bg-yellow'>Diproses</span>";
                        }
                        else{
                            echo "<span class='badge bg-red'>Dibatalkan</span>";
                        }
                        ?>

                    </td>

                    <td>
                        <button class="view">
                            <i class="fa fa-eye"></i>
                        </button>
                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

        <div class="pagination">
            <a href="#">&lt;</a>
            <a href="#">1</a>
            <a href="#" class="active">2</a>
            <a href="#">3</a>
            <a href="#">4</a>
            <a href="#">&gt;</a>
        </div>

    </div>

</div>

</body>
</html>

<?php $conn->close(); ?>