<?php
session_start();

include 'database.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit;
}

/* ================= TOTAL DATA ================= */

// total pesanan
$totalPesanan = $conn->query("SELECT COUNT(*) as total FROM detail_pesanan")
                      ->fetch_assoc()['total'];

// total menu
$totalMenu = $conn->query("
    SELECT COUNT(*) as total 
    FROM menu
    WHERE status='tersedia'
")->fetch_assoc()['total'];

// total pelanggan
$totalPelanggan = $conn->query("SELECT COUNT(*) as total FROM pelanggan")
                       ->fetch_assoc()['total'];

// total pendapatan
$pendapatan = $conn->query("
    SELECT SUM(total_harga) as total 
    FROM detail_pesanan
    WHERE status_pesanan='selesai'
")->fetch_assoc()['total'];

if (!$pendapatan) {
    $pendapatan = 0;
}

/* ================= PESANAN TERBARU ================= */

$pesanan = $conn->query("
    SELECT 
        d.id_pesanan,
        d.total_harga,
        d.status_pesanan,
        d.tanggal_pemesanan,
        p.nama AS nama_pelanggan,
        m.nama_paket
    FROM detail_pesanan d
    JOIN pelanggan p 
        ON d.id_pelanggan = p.id_pelanggan
    JOIN menu m 
        ON d.id_menu = m.id_menu
    ORDER BY d.id_pesanan DESC
    LIMIT 5
");

?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Admin</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
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

/* MAIN */
.main{
    margin-left:240px;
    width:100%;
    padding:20px;
}

/* TOPBAR */
.topbar {
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

/* CARDS */
.cards{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:15px;
    margin-bottom:20px;
}

.card{
    background:white;
    padding:20px;
    border-radius:15px;
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
}

.card h4{
    font-size:14px;
    color:gray;
}

.card h2{
    margin-top:10px;
}

.growth{
    font-size:12px;
    margin-top:8px;
    color:gray;
}

/* TABLE */
.table-box{
    background:white;
    padding:20px;
    border-radius:15px;
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
}

.table-header{
    display:flex;
    justify-content:space-between;
    margin-bottom:15px;
}

.lihat-semua{
    text-decoration:none;
    color:#6B7D5C;
    font-weight:500;
}

table{
    width:100%;
    border-collapse:collapse;
}

table th,
table td{
    padding:12px;
    text-align:center;
    border-bottom:1px solid #eee;
}

.status{
    padding:5px 10px;
    border-radius:10px;
    font-size:12px;
}

.selesai{
    background:#d4edda;
    color:green;
}

.proses{
    background:#fff3cd;
    color:orange;
}

.batal{
    background:#f8d7da;
    color:red;
}

.action-btn{
    border:none;
    padding:6px 10px;
    border-radius:8px;
    cursor:pointer;
}

.edit{
    background:#e7f1ff;
}

.menu-toggle{
    font-size:24px;
    cursor:pointer;
}

.sidebar.hide{
    transform:translateX(-100%);
    transition:0.3s;
}

.main.full{
    margin-left:0;
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
        <a href="ddashboard.php" class="active"><i class="bi bi-house"></i>Dashboard</a>
        <a href="dmenu.php"><i class="bi bi-list"></i>Menu</a>
        <a href="dpesanan.php"><i class="bi bi-receipt"></i>Pesanan</a>
    </div>
</div>

<!-- MAIN -->
<div class="main">

    <!-- TOPBAR -->
    <div class="topbar">
        <div style="display:flex; align-items:center; gap:15px;">
            <i class="bi bi-list" onclick="toggleSidebar()" style="cursor:pointer;"></i>
            <h2>Dashboard</h2>
        </div>
    </div>

    <!-- CARDS -->
    <div class="cards">

        <div class="card">
            <h4>Total Pesanan</h4>
            <h2><?= $totalPesanan ?></h2>
            <p class="growth">Data seluruh pesanan</p>
        </div>

        <div class="card">
            <h4>Total Menu</h4>
            <h2><?= $totalMenu ?></h2>
            <p class="growth">Menu tersedia</p>
        </div>

        <div class="card">
            <h4>Total Pelanggan</h4>
            <h2><?= $totalPelanggan ?></h2>
            <p class="growth">Pelanggan terdaftar</p>
        </div>

        <div class="card">
            <h4>Pendapatan</h4>
            <h2>Rp <?= number_format($pendapatan, 0, ',', '.'); ?></h2>
            <p class="growth">Pendapatan seluruh transaksi</p>
        </div>

    </div>

    <!-- TABLE PESANAN -->
    <div class="table-box">

        <div class="table-header">
            <h3>Pesanan Terbaru</h3>

            <a href="#" class="lihat-semua">
                Lihat Semua
            </a>
        </div>

        <table>

            <tr>
                <th>ID Pesanan</th>
                <th>Pelanggan</th>
                <th>Menu</th>
                <th>Total</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>

            <?php while($row = $pesanan->fetch_assoc()): ?>

            <tr>

                <td>
                    #ORD-C2VN-<?= str_pad($row['id_pesanan'], 3, '0', STR_PAD_LEFT); ?>
                </td>

                <td>
                    <?= $row['nama_pelanggan']; ?>
                </td>

                <td>
                    <?= $row['nama_paket']; ?>
                </td>

                <td>
                    Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?>
                </td>

                <td>

                    <?php
                    $class = '';

                    if($row['status_pesanan'] == 'selesai'){
                        $class = 'selesai';
                    } elseif($row['status_pesanan'] == 'diproses'){
                        $class = 'proses';
                    } else {
                        $class = 'batal';
                    }
                    ?>

                    <span class="status <?= $class ?>">
                        <?= $row['status_pesanan']; ?>
                    </span>

                </td>

                <td>
                    <?= date('d M Y H:i', strtotime($row['tanggal_pemesanan'])); ?>
                </td>

                <td>
                    <button class="action-btn edit">
                        <i class="bi bi-eye"></i>
                    </button>
                </td>

            </tr>

            <?php endwhile; ?>

        </table>

    </div>

</div>

<script>

function toggleSidebar(){

    document.querySelector(".sidebar")
    .classList.toggle("hide");

    document.querySelector(".main")
    .classList.toggle("full");

}

</script>

</body>
</html>

<?php $conn->close(); ?>