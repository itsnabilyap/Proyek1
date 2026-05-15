<?php
session_start();

include 'database.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit;
}

/* =========================
   TOTAL DATA
========================= */

// total pelanggan
$totalPelanggan = $conn->query("
    SELECT COUNT(*) as total 
    FROM pelanggan
")->fetch_assoc()['total'];

// pelanggan baru (30 hari terakhir)
$pelangganBaru = $conn->query("
    SELECT COUNT(*) as total
    FROM pelanggan
")->fetch_assoc()['total'];

// total order
$totalOrder = $conn->query("
    SELECT COUNT(*) as total
    FROM detail_pesanan
")->fetch_assoc()['total'];

// total pendapatan
$totalBelanja = $conn->query("
    SELECT SUM(total_harga) as total
    FROM detail_pesanan
    WHERE status_pesanan='selesai'
")->fetch_assoc()['total'];

if(!$totalBelanja){
    $totalBelanja = 0;
}

/* =========================
   DATA PELANGGAN
========================= */

$query = $conn->query("
    SELECT 
        p.id_pelanggan,
        p.nama,
        p.no_hp,
        p.alamat,

        COUNT(d.id_pesanan) as total_order,

        COALESCE(SUM(d.total_harga),0) as total_belanja,

        MAX(d.tanggal_pemesanan) as terakhir_order

    FROM pelanggan p

    LEFT JOIN detail_pesanan d
    ON p.id_pelanggan = d.id_pelanggan

    GROUP BY p.id_pelanggan

    ORDER BY p.id_pelanggan DESC
");

?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ADMIN C2VIN</title>

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

.sidebar{
    width:240px;
    height:100vh;
    background:#728663;
    color:white;
    padding:20px;
    position:fixed;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
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

.btn-logout{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    padding:12px;
    border-radius:12px;
    background:white;
    color:#728663;
    text-decoration:none;
    font-weight:600;
    margin-top:auto;
}

.main{
    margin-left:240px;
    width:100%;
    padding:20px;
}

.topbar {
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.header-menu {
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.header-menu button {
    background: #728663;
    color:white;
    border:none;
    padding:10px 15px;
    border-radius:10px;
    cursor:pointer;
}

.search {
    background:white;
    padding:8px 15px;
    border-radius:12px;
    border: 2px solid #728663;
}

.search input {
    border:none;
    outline:none;
}

/* ================= CARDS ================= */

.cards{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:15px;

    margin-bottom:20px;
}

.card{
    background:white;
    border-radius:15px;

    padding:20px;

    display:flex;
    align-items:center;
    gap:15px;

    border:1px solid #eee;
}

.card i{
    width:50px;
    height:50px;

    border-radius:50%;

    display:flex;
    align-items:center;
    justify-content:center;

    background:#edf4e7;
    color:#728663;

    font-size:20px;
}

.card h2{
    margin:5px 0;
}

/* ================= TABLE ================= */

.table-box{
    background:white;
    padding:20px;
    border-radius:15px;
    border:1px solid #eee;
}

.table-top{
    display:flex;
    justify-content:space-between;
    margin-bottom:20px;
}

.table-search{
    width:400px;
    position:relative;
}

.table-search input{
    width:100%;
    padding:12px 45px 12px 15px;

    border:1px solid #ddd;
    border-radius:12px;
}

.table-search i{
    position:absolute;
    right:15px;
    top:50%;
    transform:translateY(-50%);
    color:#999;
}

.filter-btn{
    padding:12px 20px;
    border-radius:12px;
    border:1px solid #ddd;
    background:white;
    cursor:pointer;
}

/* ================= TABLE ================= */

table{
    width:100%;
    border-collapse:collapse;
}

table th{
    background:#f1f1f1;
    padding:16px;
    text-align:center;
}

table td{
    padding:16px;
    border-bottom:1px solid #ddd;
    text-align:center;
}

.avatar{
    width:40px;
    height:40px;

    border-radius:50%;

    background:#edf4e7;
    color:#728663;

    display:flex;
    align-items:center;
    justify-content:center;

    font-weight:600;
}

.pelanggan{
    display:flex;
    align-items:center;
    gap:12px;
}

.view{
    width:45px;
    height:45px;
    border-radius:10px;
    border:1px solid #ddd;
    background:white;
    cursor:pointer;
}

/* ================= PAGINATION ================= */

.pagination{
    margin-top:20px;

    display:flex;
    justify-content:space-between;
    align-items:center;
}

.page-number{
    display:flex;
    gap:10px;
}

.page-number a{
    width:35px;
    height:35px;

    border-radius:8px;

    display:flex;
    align-items:center;
    justify-content:center;

    text-decoration:none;

    background:#f1f1f1;
    color:black;
}

.page-number a.active{
    background:#728663;
    color:white;
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
        <a href="dpesanan.php"><i class="bi bi-receipt"></i>Pesanan</a>
        <a href="dpelanggan.php" class="active"><i class="bi bi-people"></i>Pelanggan</a>
    </div>

    <a href="logout.php" class="btn-logout">Logout</a>
</div>


<div class="main">

    <div class="topbar">
        <div style="display:flex; align-items:center; gap:15px;">
            <i class="bi bi-list" onclick="toggleSidebar()" style="cursor:pointer;"></i>
            <h2>Pelanggan</h2>
        </div>
    </div>

    <!-- HEADER -->

    <div class="header-menu">    <!-- page header -->

        <div>
            <h2>Daftar Pelanggan</h2>
            <small>Kelola semua data pelanggan catering Anda</small>
        </div>

        <div style="display:flex; gap:10px;">
            <form method="GET" class="search">
                <input type="text" name="keyword" placeholder="Cari menu..."
                    value="">
            </form>
        </div>

    </div>

    <!-- CARDS -->

    <div class="cards">

        <div class="card">
            <i class="bi bi-people"></i>

            <div>
                <p>Total Pelanggan</p>
                <h2><?= $totalPelanggan ?></h2>
            </div>
        </div>

        <div class="card">
            <i class="bi bi-person-plus"></i>

            <div>
                <p>Pelanggan Baru</p>
                <h2><?= $pelangganBaru ?></h2>
            </div>
        </div>

        <div class="card">
            <i class="bi bi-bag"></i>

            <div>
                <p>Total Order</p>
                <h2><?= $totalOrder ?></h2>
            </div>
        </div>

        <div class="card">
            <i class="bi bi-wallet2"></i>

            <div>
                <p>Total Belanja</p>
                <h2>
                    Rp <?= number_format($totalBelanja,0,',','.') ?>
                </h2>
            </div>
        </div>

    </div>

    <!-- TABLE -->

    <div class="table-box">

        <table>

            <thead>
                <tr>
                    <th>No</th>
                    <th>Pelanggan</th>
                    <th>No Telepon</th>
                    <th>Alamat</th>
                    <th>Total Order</th>
                    <th>Total Belanja</th>
                    <th>Terakhir Order</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

            <?php $no=1; while($row = $query->fetch_assoc()) : ?>

            <tr>

                <td><?= $no++ ?></td>

                <td>
                    <?= $row['nama'] ?>
                </td>

                <td><?= $row['no_hp'] ?></td>

                <td><?= $row['alamat'] ?></td>

                <td><?= $row['total_order'] ?></td>

                <td>
                    Rp <?= number_format($row['total_belanja'],0,',','.') ?>
                </td>

                <td>

                    <?php
                    if($row['terakhir_order']){
                        echo date(
                            'd M Y',
                            strtotime($row['terakhir_order'])
                        );
                    } else {
                        echo "-";
                    }
                    ?>

                </td>

                    <td>
                        <button class="view">
                            <i class="bi bi-eye"></i>
                        </button>
                    </td>

            </tr>

            <?php endwhile; ?>

            </tbody>

        </table>

        <!-- PAGINATION -->

        <div class="pagination">

            <p>
                Menampilkan data pelanggan
            </p>

            <div class="page-number">
                <a href="#">1</a>
                <a href="#" class="active">2</a>
                <a href="#">3</a>
            </div>

        </div>

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