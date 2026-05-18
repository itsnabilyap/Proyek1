<?php 
include 'database.php';

$id_menu = isset($_GET['id']) ? $_GET['id'] : 0;

$query = $conn->query("SELECT * FROM menu WHERE id_menu='$id_menu'");
$data = $query->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Menu</title>
    <link rel="stylesheet" href="css/detailpesanan.css">
    <link rel="stylesheet" href="css/navbar.css">
</head>
<body>

<?php include 'partials/navbar.php'; ?>

<main class="container content">
    <h1>Detail Menu</h1>

    <div class="product-detail">

        <div class="product-image">
            <img src="img/<?php echo $data['foto_produk']; ?>">
        </div>

        <div class="product-info">
            <h1><?php echo $data['nama_paket']; ?></h1>
            <p>Rp. <?php echo number_format($data['harga'],0,',','.'); ?></p>

            <div class="form-group">
                <label>/Paket</label>
                <select id="pilihan-jumlah">

                    <?php
                        $menuPaket = [1, 2, 3];
                    ?>
                    <?php if (in_array($data['id_menu'], $menuPaket)) { ?>
                    <option value="" disabled selected>Pilih Jumlah</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>

                    <?php } else { ?>
                        <option value=""disabled selected>Pilih Jumlah</option>
                        <option value="20">20</option>
                        <option value="40">40</option>
                        <option value="50">50</option>
                    <?php } ?>

                </select>
            </div>

            <button class="button" onclick="tambahDariDetail(
                '<?php echo $data['nama_paket']; ?>',
                <?php echo $data['harga']; ?>,
                'img/<?php echo $data['foto_produk']; ?>'
                )">Tambah ke Keranjang
            </button>
        </div>

    </div>

    <div class="description">
        <h3>Deskripsi</h3>
        <p><?php echo isset($data['deskripsi']) ? $data['deskripsi'] : 'Tidak ada deskripsi'; ?></p>
    </div>

</main>

<?php include 'partials/footer.php'; ?>

<script src="https://unpkg.com/feather-icons"></script>

    <script>
        feather.replace();
    </script>

<script src="cart.js"></script>

</body>
</html>