<?php
// Data barang (seperti dari versi C++)
$barang = [
    1 => [
        "No" => 1,
        "NamaBarang" => "Hoodie Oversize",
        "Merk" => "Dobujack",
        "Kategori" => "Fashion",
        "KondisiBarang" => "90%",
        "HargaJual" => 152100,
        "Ukuran" => "L",
        "Toko" => "RAFZ STORE",
        "Deskripsi" => "Bahan adem dan nyaman buat gaya santai."
    ],
    2 => [
        "No" => 2,
        "NamaBarang" => "Jaket Varsity",
        "Merk" => "Dobujack",
        "Kategori" => "Fashion",
        "KondisiBarang" => "80%",
        "HargaJual" => 288500,
        "Ukuran" => "L",
        "Toko" => "RAFZ STORE",
        "Deskripsi" => "Sporty dan keren buat OOTD kasual."
    ],
    3 => [
        "No" => 3,
        "NamaBarang" => "Router WiFi",
        "Merk" => "ASUS",
        "Kategori" => "Elektronik",
        "KondisiBarang" => "Bekas Layak",
        "HargaJual" => 443700,
        "Ukuran" => "Sedang",
        "Toko" => "RAFZ STORE",
        "Deskripsi" => "Bekas layak, masih nyala normal dan stabil."
    ],
    4 => [
        "No" => 4,
        "NamaBarang" => "Sneakers Adidas",
        "Merk" => "Adidas Samba",
        "Kategori" => "Olahraga",
        "KondisiBarang" => "Bekas Layak",
        "HargaJual" => 256500,
        "Ukuran" => "42",
        "Toko" => "RAFZ STORE",
        "Deskripsi" => "Bekas layak, tetap nyaman dan keren dipakai."
    ],
    5 => [
        "No" => 5,
        "NamaBarang" => "Anting Emas",
        "Merk" => "UBS Gold",
        "Kategori" => "Aksesoris",
        "KondisiBarang" => "90%",
        "HargaJual" => 1937400,
        "Ukuran" => "Sedang",
        "Toko" => "RAFZ STORE",
        "Deskripsi" => "Berkilau elegan dan siap tampil mewah."
    ]
];

$pilihan = $_GET['pilihan'] ?? null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Barang - RAFZ STORE</title>
</head>
<body>
    <h1>Daftar Barang di RAFZ STORE</h1>

    <form method="get" action="">
        <label for="pilihan">Pilih Barang:</label>
        <select name="pilihan" id="pilihan">
            <option value="">-- Pilih --</option>
            <?php foreach ($barang as $key => $b): ?>
                <option value="<?= $key ?>" <?= ($pilihan == $key) ? 'selected' : '' ?>>
                    <?= $b['NamaBarang'] ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Lihat Detail</button>
    </form>

    <?php if ($pilihan && isset($barang[$pilihan])): ?>
        <?php $b = $barang[$pilihan]; ?>
        <hr>
        <h2>Detail Barang</h2>
        <p><strong>Nama Barang:</strong> <?= $b['NamaBarang'] ?></p>
        <p><strong>Merk:</strong> <?= $b['Merk'] ?></p>
        <p><strong>Kategori:</strong> <?= $b['Kategori'] ?></p>
        <p><strong>Kondisi:</strong> <?= $b['KondisiBarang'] ?></p>
        <p><strong>Harga:</strong> Rp <?= number_format($b['HargaJual'], 0, ',', '.') ?></p>
        <p><strong>Ukuran:</strong> <?= $b['Ukuran'] ?></p>
        <p><strong>Toko:</strong> <?= $b['Toko'] ?></p>
        <p><strong>Deskripsi:</strong> <?= $b['Deskripsi'] ?></p>
    <?php endif; ?>

    <hr>
    <a href="index.php">← Kembali ke Beranda</a>
</body>
</html>
