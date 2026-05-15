<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "catering_db");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

/*TOGGLE STATUS*/
if (isset($_POST['toggle'])) {
    $id     = (int)$_POST['id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE menu SET status=? WHERE id_menu=?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();

    echo json_encode(["success" => true]);
    exit;
}

/*HAPUS MENU*/
if (isset($_POST['hapus'])) {

    $id = (int)$_POST['id'];

    $get = $conn->prepare("SELECT foto_produk FROM menu WHERE id_menu=?");
    $get->bind_param("i", $id);
    $get->execute();

    $resultFoto = $get->get_result();
    $dataFoto = $resultFoto->fetch_assoc();

    if ($dataFoto && $dataFoto['foto_produk'] != '') {

        $path = "img/" . $dataFoto['foto_produk'];

        if (file_exists($path)) {
            unlink($path);
        }
    }

    $stmt = $conn->prepare("DELETE FROM menu WHERE id_menu=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {

        echo json_encode([
            "success" => true
        ]);

    } else {

        echo json_encode([
            "success" => false
        ]);
    }

    exit;
}

/*PAGINATION*/
$limit = 10;
$page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if ($page < 1) $page = 1;

$start = ($page - 1) * $limit;

$totalQuery = $conn->query("SELECT COUNT(*) as total FROM menu");
$totalData  = $totalQuery->fetch_assoc()['total'];
$totalPages = ceil($totalData / $limit);

/*SEARCH*/
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

if ($keyword != '') {

    $stmt = $conn->prepare("
        SELECT * FROM menu
        WHERE nama_paket LIKE ?
        LIMIT ?, ?
    ");

    $search = "%$keyword%";

    $stmt->bind_param(
        "sii",
        $search,
        $start,
        $limit
    );

    $stmt->execute();
    $result = $stmt->get_result();

} else {

    $result = $conn->query("
        SELECT * FROM menu
        LIMIT $start, $limit
    ");
}

/*TAMBAH MENU*/
if (isset($_POST['tambah_menu'])) {

    $nama       = $_POST['nama_paket'];
    $deskripsi  = $_POST['deskripsi'];
    $harga      = $_POST['harga'];

    $foto = '';

    if ($_FILES['foto_produk']['name'] != '') {

        $foto = time() . '_' . $_FILES['foto_produk']['name'];

        move_uploaded_file(
            $_FILES['foto_produk']['tmp_name'],
            "img/" . $foto
        );
    }

    $status = "Tersedia";

    $stmt = $conn->prepare("
        INSERT INTO menu
        (nama_paket, deskripsi, harga, foto_produk, status)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "ssiss",
        $nama,
        $deskripsi,
        $harga,
        $foto,
        $status
    );

    if ($stmt->execute()) {

        echo "
        <script>
            alert('Menu berhasil ditambahkan');
            window.location.href='dmenu.php';
        </script>
        ";

        exit;
    }
}

/*EDIT MENU*/
if (isset($_POST['edit_menu'])) {

    $id         = $_POST['id_menu'];
    $nama       = $_POST['nama_paket'];
    $deskripsi  = $_POST['deskripsi'];
    $harga      = $_POST['harga'];

    $foto = "";

    if ($_FILES['foto_produk']['name'] != '') {

        $foto = time() . '_' . $_FILES['foto_produk']['name'];

        move_uploaded_file(
            $_FILES['foto_produk']['tmp_name'],
            "img/" . $foto
        );

        $stmt = $conn->prepare("
            UPDATE menu 
            SET nama_paket=?, deskripsi=?, harga=?, foto_produk=?
            WHERE id_menu=?
        ");

        $stmt->bind_param(
            "ssisi",
            $nama,
            $deskripsi,
            $harga,
            $foto,
            $id
        );

    } else {

        $stmt = $conn->prepare("
            UPDATE menu 
            SET nama_paket=?, deskripsi=?, harga=?
            WHERE id_menu=?
        ");

        $stmt->bind_param(
            "ssii",
            $nama,
            $deskripsi,
            $harga,
            $id
        );
    }

    if ($stmt->execute()) {

    echo "
    <script>
        alert('Menu berhasil diperbarui');
        window.location.href='dmenu.php';
    </script>
    ";

    exit;
    }
}

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

.main {
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

.table-box {
    background: #728663;
    color: #ccc;
    padding:20px;
    border-radius:15px;
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
}

table {
    width:100%;
    border-collapse:collapse;
}

th, td {
    padding:15px;
    border-bottom:1px solid #eee;
    text-align: center;
}

.menu-item {
    display:flex;
    align-items:center;
    gap:10px;
}

.menu-img {
    width:60px;
    height:60px;
    border-radius:10px;
    object-fit:cover;
}

.status-btn {
    border: none;
    padding: 6px 12px;
    border-radius: 8px;
    cursor: pointer;
    color: white;
    position: relative;
    font-size: 13px;
}

.status-btn.tersedia {
    background: #4CAF50;
}

.status-btn.habis {
    background: #f44336;
}

.action-btn {
    border:none;
    padding:6px 10px;
    border-radius:8px;
    cursor:pointer;
    margin-right:5px;
}

.edit { background:#e7f1ff; }
.delete { background:#ffe7e7; }

.aksi {
    display:flex;
    gap:8px;
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

.sidebar.hide {
    transform: translateX(-100%);
}

.main.full {
    margin-left:0;
}

.modal{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.4);
    display:none;
    justify-content:center;
    align-items:center;
    z-index:999;
    overflow-y:auto;
}

.modal-content{
    background:white;
    width:700px;
    max-width:95%;
    border-radius:20px;
    padding:30px;
    animation:popup 0.3s ease;
}

@keyframes popup{
    from{
        transform:scale(0.8);
        opacity:0;
    }
    to{
        transform:scale(1);
        opacity:1;
    }
}

.modal-content h2{
    margin-bottom:20px;
}

.modal-content label{
    display:block;
    margin-top:15px;
    margin-bottom:8px;
    font-weight:600;
}

.modal-content input,
.modal-content textarea{
    width:100%;
    padding:12px;
    border:1px solid #ccc;
    border-radius:10px;
    outline:none;
}

.modal-content textarea{
    height:120px;
    resize:none;
}

.preview-box{
    margin-bottom:10px;
}

.preview-box img{
    border-radius:10px;
    object-fit:cover;
}

.modal-action{
    margin-top:20px;
    display:flex;
    gap:10px;
}

.btn-cancel{
    background:#ddd;
    border:none;
    padding:10px 20px;
    border-radius:10px;
    cursor:pointer;
}

.btn-save{
    background:#6B7D5C;
    color:white;
    border:none;
    padding:10px 20px;
    border-radius:10px;
    cursor:pointer;
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
        <a href="dmenu.php" class="active"><i class="bi bi-list"></i>Menu</a>
        <a href="dpesanan.php"><i class="bi bi-receipt"></i>Pesanan</a>
    </div>

    <a href="admin.php" class="btn-logout">Logout</a>

</div>

<div class="main">

    <div class="topbar">
        <div style="display:flex; align-items:center; gap:15px;">
            <i class="bi bi-list" onclick="toggleSidebar()" style="cursor:pointer;"></i>
            <h2>Menu</h2>
        </div>
    </div>

    <div class="header-menu">
        <div>
            <h2>Daftar Menu</h2>
            <small>Kelola semua menu paket catering Anda</small>
        </div>

        <div style="display:flex; gap:10px;">
            <form method="GET" class="search">
                <input type="text" name="keyword" placeholder="Cari menu..."
                    value="<?= $keyword ?>">
            </form>

            <button onclick="openTambahModal()">
                + Tambah Menu
            </button>
        </div>
    </div>

    <div class="table-box">
        <table>
            <tr>
                <th>Nama Paket</th>
                <th>Deskripsi</th>
                <th>Harga</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>

            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td>
                    <div class="menu-item">
                        <img src="img/<?= $row['foto_produk']; ?>" class="menu-img">
                        <?= $row['nama_paket']; ?>
                    </div>
                </td>

                <td><?= $row['deskripsi']; ?></td>

                <td>Rp <?= number_format($row['harga']); ?></td>

                <td>
    <button 
    class="status-btn <?= $row['status']=='Tersedia' ? 'tersedia' : 'habis' ?>"
    onclick="ubahStatus(<?= $row['id_menu']; ?>, this)">
    <?= $row['status']; ?>
</button>
</td>

                <td>
                    <div class="aksi">
                        <button class="action-btn edit"
                            onclick='openEditModal(
                            <?= $row["id_menu"] ?>,
                            <?= json_encode($row["nama_paket"]) ?>,
                            <?= json_encode($row["deskripsi"]) ?>,
                            <?= $row["harga"] ?>,
                            <?= json_encode($row["foto_produk"]) ?>
                            )'>
                                <i class="bi bi-pencil"></i>
                        </button>

                        <button class="action-btn delete" onclick="hapusMenu(<?= $row['id_menu']; ?>, this)">
    <i class="bi bi-trash"></i>
</button>
                    </div>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>

        <div class="pagination">
            <small>
                Menampilkan <?= $start+1 ?> - <?= min($start+$limit,$totalData) ?> dari <?= $totalData ?>
            </small>

            <div class="pages">
                <?php if ($page > 1): ?>
            <a href="?page=<?= $page-1 ?>&keyword=<?= $keyword ?>">
                <button>&laquo;</button>
            </a>
                <?php else: ?>
                    <button disabled style="opacity:0.5;cursor:not-allowed;">&laquo;</button>
                <?php endif; ?>
        
                <?php for ($i=1;$i<=$totalPages;$i++): ?>
                    <a href="?page=<?= $i ?>&keyword=<?= $keyword ?>">
                        <button class="<?= $i==$page?'active':'' ?>"><?= $i ?></button>
                    </a>
                <?php endfor; ?>
                
                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?= $page+1 ?>&keyword=<?= $keyword ?>">
                        <button>&raquo;</button>
                    </a>
                <?php else: ?>
                    <button disabled style="opacity:0.5;cursor:not-allowed;">&raquo;</button>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>

<div class="modal" id="tambahModal">

    <div class="modal-content">

        <h2>Tambah Menu</h2>

        <form method="POST" enctype="multipart/form-data">

            <input type="hidden" name="tambah_menu" value="1">

            <label>Nama Paket</label>
            <input type="text" name="nama_paket" required>

            <label>Gambar Produk</label>

            <div class="preview-box">
                <img src="upload-icon.png" width="80">
            </div>

            <input type="file" name="foto_produk" required>

            <label>Deskripsi</label>
            <textarea name="deskripsi" required></textarea>

            <label>Harga</label>
            <input type="number" name="harga" required>

            <div class="modal-action">

                <button type="button"
                    class="btn-cancel"
                    onclick="closeTambahModal()">
                    Kembali
                </button>

                <button type="submit"
                    class="btn-save">
                    Tambah Menu
                </button>

            </div>

        </form>

    </div>

</div>

<div class="modal" id="editModal">

    <div class="modal-content">

        <h2>Edit Menu</h2>

<form method="POST" enctype="multipart/form-data">

    <input type="hidden" name="edit_menu" value="1">
    <input type="hidden" name="id_menu" id="edit_id">

    <label>Nama Paket</label>
    <input type="text" name="nama_paket" id="edit_nama">

            <label>Gambar Produk</label>

            <div class="preview-box">
                <img id="previewImg" src="" width="120">
            </div>

            <input type="file" name="foto_produk">

            <label>Deskripsi</label>
            <textarea name="deskripsi" id="edit_deskripsi"></textarea>

            <label>Harga</label>
            <input type="number" name="harga" id="edit_harga">

            <div class="modal-action">
                <button type="button" class="btn-cancel" onclick="closeModal()">
                    Kembali
                </button>

                <button type="submit" class="btn-save">
                    Simpan Perubahan
                </button>
            </div>

        </form>

    </div>

</div>

<script>
function toggleSidebar(){
    document.querySelector(".sidebar").classList.toggle("hide");
    document.querySelector(".main").classList.toggle("full");
}

function ubahStatus(id, el) {
    const isTersedia = el.classList.contains("tersedia");
    const newStatus = isTersedia ? 'Habis' : 'Tersedia';

    fetch('', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `toggle=1&id=${id}&status=${newStatus}`
    })

    .then(res => res.json())

    .then(res => {

        if (res.success) {

            el.classList.toggle("tersedia");
            el.classList.toggle("habis");

            el.innerText = newStatus;

            if(newStatus == "Tersedia"){
                alert("Menu berhasil diubah menjadi TERSEDIA");
            } else {
                alert("Menu berhasil diubah menjadi HABIS");
            }

        } else {

            alert('Gagal update status');

        }

    })
    .catch(() => {
        alert('Error koneksi');
    });
}

function hapusMenu(id, el) {
    if (!confirm("Yakin mau hapus menu ini?")) return;

    fetch('', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `hapus=1&id=${id}`
    })
    .then(res => res.json())
    .then(res => {
        if (res.success) {
            el.closest("tr").remove();
        } else {
            alert('Gagal hapus');
        }
    })
    .catch(() => alert('Error'));
}

function openEditModal(id, nama, deskripsi, harga, foto){

    document.getElementById("editModal").style.display = "flex";

    document.getElementById("edit_id").value = id;
    document.getElementById("edit_nama").value = nama;
    document.getElementById("edit_deskripsi").value = deskripsi;
    document.getElementById("edit_harga").value = harga;

    document.getElementById("previewImg").src = "img/" + foto;
}

function closeModal(){
    document.getElementById("editModal").style.display = "none";
}

window.onclick = function(e){

    const modal = document.getElementById("editModal");

    if(e.target == modal){
        modal.style.display = "none";
    }
}

function openTambahModal(){

    document.getElementById("tambahModal").style.display = "flex";

}

function closeTambahModal(){

    document.getElementById("tambahModal").style.display = "none";

}

</script>

</body>
</html>

<?php $conn->close(); ?>