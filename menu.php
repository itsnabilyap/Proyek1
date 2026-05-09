<?php include 'database.php'; ?>

<?php
$limit = 15;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

$query = $conn->query("
    SELECT * FROM menu
    WHERE status='Tersedia'
    LIMIT $start, $limit
");

$result_total = $conn->query("
    SELECT COUNT(*) as total
    FROM menu
    WHERE status='Tersedia'
");
$data_total = $result_total->fetch_assoc();
$total_data = $data_total['total'];
$total_page = ceil($total_data / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Menu</title>
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/navbar.css">
</head>
<body>

<?php include 'partials/navbar.php'; ?>

<section class="container" id="menu">

<?php while($row = $query->fetch_assoc()) { ?>

    <div class="gallery <?= $row['status'] === 'Tersedia' ? 'Tersedia' : '' ?>">

        <?php if ($row['status'] === 'Tersedia'): ?>
            <a href="detail.php?id=<?= $row['id_menu']; ?>">
        <?php endif; ?>

            <img src="img/<?= $row['foto_produk']; ?>" alt="">

        <?php if ($row['status'] === 'Tersedia'): ?>
            </a>
        <?php endif; ?>

        <!-- Overlay HABIS -->
        <?php if ($row['status'] === 'Habis'): ?>
            <div class="overlay-habis">HABIS</div>
        <?php endif; ?>

        <div class="desc">
            <?= $row['nama_paket']; ?><br>
            Rp.<?= number_format($row['harga'], 0, ',', '.'); ?>
        </div>

    </div>

<?php } ?>

</section>

<div class="pagination">

    <?php if($page > 1): ?>
        <a href="?page=<?php echo $page-1; ?>">&#9664;</a>
    <?php else: ?>
        <a class="disabled">&#9664;</a>
    <?php endif; ?>


    <div class="dots">
        <?php for($i = 1; $i <= $total_page; $i++): ?>
            <a href="?page=<?php echo $i; ?>">
                <div class="dot <?php echo ($i == $page) ? 'active' : ''; ?>"></div>
            </a>
        <?php endfor; ?>
    </div>


    <?php if($page < $total_page): ?>
        <a href="?page=<?php echo $page+1; ?>">&#9654;</a>
    <?php else: ?>
        <a class="disabled">&#9654;</a>
    <?php endif; ?>

</div>

<?php include 'partials/footer.php'; ?>

    <script src="https://unpkg.com/feather-icons"></script>

    <script>
      feather.replace();
    </script>

    <script src="cart.js"></script>

</body>
</html>