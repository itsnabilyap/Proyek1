<?php
session_start();

include 'database.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit;
}

$limit = 10;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if($page < 1){
    $page = 1;
}

$start = ($page - 1) * $limit;

$totalData = mysqli_num_rows(
    mysqli_query($conn,"SELECT * FROM detail_pesanan")
);

$totalPage = ceil($totalData / $limit);

$totalPesanan = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM detail_pesanan"));
$totalDiproses = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM detail_pesanan WHERE status_pesanan='diproses'"));
$totalSelesai = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM detail_pesanan WHERE status_pesanan='selesai'"));
$totalBatal = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM detail_pesanan WHERE status_pesanan='dibatalkan'"));

$query = mysqli_query($conn,"
    SELECT detail_pesanan.*, pelanggan.nama, pelanggan.no_hp
    FROM detail_pesanan
    JOIN pelanggan
    ON detail_pesanan.id_pelanggan = pelanggan.id_pelanggan
    ORDER BY detail_pesanan.id_pesanan DESC
    LIMIT $start,$limit
");

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

.sidebar.hide {
    transform: translateX(-100%);
}

.main.full {
    margin-left:0;
}

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
    display:flex;
    align-items:center;
    gap:15px;
}

.card i{
    width:45px;
    height:45px;
    min-width:45px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:18px;
}

.card h4{
    font-size:14px;
    color:#666;
}

.card h2{
    margin-top:10px;
}

.growth{
    font-size:12px;
    margin-top:8px;
    color:gray;
}

.green{
    color:#18b76a;
    border:1px solid #18b76a;
    background:rgba(24,183,106,0.08);
}

.yellow{
    color:#f4c21b;
    border:1px solid #f4c21b;
    background:rgba(244,194,27,0.08);
}

.red{
    color:#ff5722;
    border:1px solid #ff5722;
    background:rgba(255,87,34,0.08);
}

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

.pagination {
    display:flex;
    justify-content:space-between;
    margin-top:15px;
    align-items:center;
}

.pagination a {
    text-decoration: none;
    color: inherit;
}

.pages button {
    padding:6px 10px;
    margin:2px;
    border:none;
    border-radius:8px;
    cursor:pointer;
}

.pages .active {
    background:#6B7D5C;
    color:white;
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
        <a href="dpesanan.php" class="active"><i class="bi bi-receipt"></i>Pesanan</a>
    </div>

    <a href="admin.php" class="btn-logout">Logout</a>

</div>

<div class="main">

    <div class="topbar">
        <div style="display:flex; align-items:center; gap:15px;">
            <i class="bi bi-list" onclick="toggleSidebar()" style="cursor:pointer;"></i>
            <h2>Pesanan</h2>
        </div>
    </div>

    <div class="cards">

        <div class="card">
            <i class="bi bi-bag-check green"></i>

            <div>
                <h4>Pesanan</h4>
                <h2><?= $totalPesanan ?></h2>
                <p class="growth">Total pesanan</p>
            </div>
        </div>

        <div class="card">
            <i class="bi bi-clock-history yellow"></i>

            <div>
                <h4>Di Proses</h4>
                <h2><?= $totalDiproses ?></h2>
                <p class="growth">Sedang diproses</p>
            </div>
        </div>

        <div class="card">
            <i class="bi bi-check-circle green"></i>

            <div>
                <h4>Selesai</h4>
                <h2><?= $totalSelesai ?></h2>
                <p class="growth">Pesanan selesai</p>
            </div>
        </div>

        <div class="card">
            <i class="bi bi-x-circle red"></i>

            <div>
                <h4>Dibatalkan</h4>
                <h2><?= $totalBatal ?></h2>
                <p class="growth">Pesanan dibatalkan</p>
            </div>
        </div>

    </div>

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
                        elseif($data['status_pesanan']=="pending"){
                            echo "<span class='badge bg-yellow'>Pending</span>";
                        }
                        elseif($data['status_pesanan']=="dikonfirmasi"){
                            echo "<span class='badge bg-yellow'>Dikonfirmasi</span>";
                        }
                        else{
                            echo "<span class='badge bg-red'>Dibatalkan</span>";
                        }
                        ?>

                    </td>

                    <td>
                        <button class="view">
                            <i class="bi bi-eye"></i>
                        </button>
                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

<div class="pagination">
            <small>
                Menampilkan <?= $start+1 ?> - <?= min($start+$limit,$totalData) ?> dari <?= $totalData ?>
            </small>

    <div class="pages">

        <?php if($page>1): ?>
            <a href="?page=<?= $page-1 ?>">
                <button>&laquo;</button>
            </a>
        <?php else: ?>
            <button disabled>&laquo;</button>
        <?php endif; ?>


        <?php for($i=1;$i<=$totalPage;$i++): ?>

            <a href="?page=<?= $i ?>">
                <button class="<?= $i==$page ? 'active':'' ?>">
                    <?= $i ?>
                </button>
            </a>

        <?php endfor; ?>



        <?php if($page<$totalPage): ?>
            <a href="?page=<?= $page+1 ?>">
                <button>&raquo;</button>
            </a>
        <?php else: ?>
            <button disabled>&raquo;</button>
        <?php endif; ?>

    </div>

</div>

    </div>

</div>

<script>
    function toggleSidebar(){
    document.querySelector(".sidebar").classList.toggle("hide");
    document.querySelector(".main").classList.toggle("full");
}
</script>

</body>
</html>

<?php $conn->close(); ?>