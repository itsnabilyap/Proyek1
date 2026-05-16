<?php
include 'database.php';

if (isset($_POST['order'])) {

    $nama    = $_POST['nama'];
    $hp      = $_POST['hp'];
    $alamat  = $_POST['alamat'];
    $catatan = $_POST['catatan'];

    if (!preg_match("/^[A-Za-z ]+$/", $nama)) {
        echo "<script>alert('Nama hanya boleh huruf!');</script>";
        exit;
    }

    if (!preg_match("/^[0-9]+$/", $hp)) {
        echo "<script>alert('No HP hanya angka!');</script>";
        exit;
    }

    $cart = json_decode($_POST['cart_data'], true);

    $stmt = $conn->prepare("
        INSERT INTO pelanggan (nama, no_hp, alamat)
        VALUES (?, ?, ?)
    ");

    $stmt->bind_param("sss", $nama, $hp, $alamat);
    $stmt->execute();

    $id_pelanggan = $conn->insert_id;


    foreach ($cart as $item) {

        $nama_menu = $item['nama'];

        $queryMenu = $conn->query("
            SELECT id_menu
            FROM menu
            WHERE nama_paket = '$nama_menu'
        ");

        $dataMenu = $queryMenu->fetch_assoc();

        $id_menu = $dataMenu['id_menu'];

        $jumlah = $item['qty'];

        $subtotal = $item['harga'] * $jumlah;

        $status = "pending";

        $stmt2 = $conn->prepare("
            INSERT INTO detail_pesanan
            (
                id_pelanggan,
                id_menu,
                jumlah_pesanan,
                total_harga,
                status_pesanan,
                catatan
            )
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $stmt2->bind_param(
            "iiidss",
            $id_pelanggan,
            $id_menu,
            $jumlah,
            $subtotal,
            $status,
            $catatan
        );

        $stmt2->execute();
    }

    $pesan = "Halo C2VIN Catering, saya ingin memesan:\n\n";

    $pesan .= "Nama: $nama\n";
    $pesan .= "No HP: $hp\n";
    $pesan .= "Alamat: $alamat\n";
    $pesan .= "Catatan: $catatan\n\n";

    $pesan .= "Detail Pesanan:\n\n";

    $total = 0;

    foreach ($cart as $i => $item) {

        $subtotal = $item['harga'] * $item['qty'];

        $total += $subtotal;

        $pesan .= ($i + 1) . ". " . $item['nama'] . "\n";

        $pesan .= "   Jumlah: " . $item['qty'] . " " . $item['tipe'] . "\n";

        $pesan .= "   Subtotal: Rp. "
            . number_format($subtotal, 0, ',', '.')
            . "\n\n";
    }

    $pesan .= "--------------------------\n";

    $pesan .= "Total Pesanan: Rp. "
        . number_format($total, 0, ',', '.')
        . "\n";

    $wa = "6287826913182";

    $link = "https://wa.me/" . $wa . "?text=" . urlencode($pesan);

    echo "
    <script>

    alert('Pesanan berhasil dikirim!');

    localStorage.removeItem('cart');

    window.location.href='$link';

    </script>
    ";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Keranjang</title>

    <link rel="stylesheet" href="css/navbar.css">

    <link rel="stylesheet" href="css/keranjang.css">

    <script src="https://unpkg.com/feather-icons"></script>

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>

<?php include 'partials/navbar.php'; ?>

<div class="cart-container" id="keranjang">

    <h2 class="title">Pesanan Saya</h2>

    <div class="grid">

        <div class="card left">

            <div class="table-head">

                <div>Produk</div>
                <div>Harga</div>
                <div>/Paket</div>
                <div>Total</div>
                <div></div>

            </div>

            <div id="cart-items"></div>

        </div>

        <form method="POST" class="card right">

            <input type="hidden"
                name="cart_data"
                id="cart_data">

            <div class="section-title">
                <i class="fa fa-user"></i>
                Data Pemesan
            </div>

            <div class="form-group">

                <label>Nama</label>

                <input
                    type="text"
                    name="nama"
                    id="nama"
                    placeholder="Masukkan nama"
                    pattern="^[A-Za-z ]+$"
                    title="Nama hanya boleh huruf dan spasi"
                    required>

            </div>

            <div class="form-group">

                <label>No HP</label>

                <input
                    type="text"
                    name="hp"
                    id="hp"
                    placeholder="Masukkan nomor HP"
                    pattern="^[0-9]+$"
                    title="Nomor HP hanya boleh angka"
                    required>

            </div>

            <div class="form-group">

                <label>Alamat</label>

                <textarea
                    id="alamat"
                    name="alamat"
                    placeholder="Masukkan alamat"
                    required></textarea>

            </div>

            <div class="form-group">

                <label>Catatan</label>

                <input
                    type="text"
                    id="catatan"
                    name="catatan"
                    placeholder="Contoh: pedas sedikit, kirim jam 10 pagi">

            </div>

            <div class="section-title">

                <i class="fa fa-file"></i>
                Total Pesanan

            </div>

            <div class="total-box">

                <span>Total</span>

                <span id="total"
                    style="font-weight:bold;">

                    Rp. 0

                </span>

            </div>

            <button
                type="submit"
                name="order"
                class="order-btn"
                onclick="return checkoutWA()">

                Order Sekarang

            </button>

        </form>

    </div>

</div>

<?php include 'partials/footer.php'; ?>

<script>
feather.replace();
</script>

<script src="cart.js"></script>

</body>
</html>