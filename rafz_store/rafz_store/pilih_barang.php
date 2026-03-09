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
    ],
    6 => [
        "No" => 6,
        "NamaBarang" => "Iphone 13",
        "Merk" => "Apple/Iphone",
        "Kategori" => "Gadget",
        "KondisiBarang" => "90%",
        "HargaJual" => 7200000,
        "Ukuran" => "Kecil",
        "Toko" => "RAFZ STORE",
        "Deskripsi" => "HP dengan gengsi tinggi untuk memenuhi kebutuhan sosmed."
    ],
    7 => [
        "No" => 7,
        "NamaBarang" => "Sepatu Puma",
        "Merk" => "Puma",
        "Kategori" => "Fashion",
        "KondisiBarang" => "preloved",
        "HargaJual" => 1200000,
        "Ukuran" => "42",
        "Toko" => "RAFZ STORE",
        "Deskripsi" => "Sepatu yang cocok digunakan untuk pergi ke kampus, jalan-jalan atau running."
    ],
    8 => [
    "No" => 8,
    "NamaBarang" => "Kemeja Flanel",
    "Merk"=>  "UrbanWear",
    "Kategori"=>  "Fashion",
    "KondisiBarang"=>  "90%",
    "HargaJual"=>  175000,
    "Ukuran"=>  "L",
    "Toko" =>  "RAFZ STORE",
    "Deskripsi"=>  "Kemeja flanel hangat dengan motif kotak klasik."
    ],
    9 => [
    "No"=>  9,
    "NamaBarang"=>  "Sneakers Putih",
    "Merk"=>  "AirBoost",
    "Kategori"=>  "Fashion",
    "KondisiBarang"=>  "85%",
    "HargaJual"=>  320000,
    "Ukuran"=>  "42",
    "Toko"=>  "RAFZ STORE",
    "Deskripsi"=>  "Sneakers putih minimalis cocok untuk daily wear."
    ],
    10 => [
    "No"=>  10,
    "NamaBarang"=>  "Smartphone Android",
    "Merk"=>  "RealPlus",
    "Kategori"=>  "Gadget",
    "KondisiBarang"=>  "92%",
    "HargaJual"=>  2100000,
    "Ukuran"=>  "6.5 inch",
    "Toko"=>  "RAFZ STORE",
    "Deskripsi"=>  "Smartphone cepat dengan baterai tahan lama."
    ],
    11 => [
    "No"=>  11,
    "NamaBarang"=>  "Laptop Ultrabook",
    "Merk"=>  "LiteBook",
    "Kategori"=>  "Gadget",
    "KondisiBarang"=>  "88%",
    "HargaJual"=>  5900000,
    "Ukuran"=>  "14 inch",
    "Toko"=>  "RAFZ STORE",
    "Deskripsi"=>  "Ultrabook ringan dan elegan untuk produktivitas."
    ],
    12 => [
    "No"=>  12,
    "NamaBarang"=>  "Helm Full Face",
    "Merk"=>  "RiderMax",
    "Kategori"=>  "Otomotif",
    "KondisiBarang"=>  "90%",
    "HargaJual"=>  450000,
    "Ukuran"=>  "L",
    "Toko"=>  "RAFZ STORE",
    "Deskripsi"=>  "Helm full face dengan ventilasi optimal."
    ],
    13 => [
    "No"=>  13,
    "NamaBarang"=>  "Ban Motor Tubeless",
    "Merk"=>  "RoadGrip",
    "Kategori"=>  "Otomotif",
    "KondisiBarang"=>  "95%",
    "HargaJual"=>  230000,
    "Ukuran"=>  "14 inch",
    "Toko"=>  "RAFZ STORE",
    "Deskripsi"=>  "Ban tubeless kuat dan aman untuk perjalanan jauh."
    ],
    14 => [
    "No"=>  14,
    "NamaBarang"=>  "Smartwatch Series X",
    "Merk"=>  "WristPro",
    "Kategori"=>  "Gadget",
    "KondisiBarang"=>  "89%",
    "HargaJual"=>  780000,
    "Ukuran"=>  "Universal",
    "Toko"=>  "RAFZ STORE",
    "Deskripsi"=>  "Smartwatch lengkap dengan sensor kesehatan."
    ],
    15 => [
    "No"=>  15,
    "NamaBarang"=> "Mesin Cuci Mini",
    "Merk"=>  "WashNow",
    "Kategori"=>  "Elektronik",
    "KondisiBarang"=>  "87%",
    "HargaJual"=>  550000,
    "Ukuran"=>  "Kecil",
    "Toko"=>  "RAFZ STORE",
    "Deskripsi"=>  "Mesin cuci portable cocok untuk kos."
    ],   
    16 => [
    "No"=>  15,
    "NamaBarang"=>  "Kipas Angin Meja",
    "Merk"=>  "BreezeX",
    "Kategori"=>  "Elektronik",
    "KondisiBarang"=>  "93%",
    "HargaJual"=>  120000,
    "Ukuran"=>  "Sedang",
    "Toko"=> "RAFZ STORE",
    "Deskripsi"=> "Kipas angin meja hemat energi dan senyap."
    ],
    17 => [ 
    "No"=> 17,
    "NamaBarang"=> "Set Panci Stainless",
    "Merk"=> "CookMaster",
    "Kategori"=> "Rumah Tangga",
    "KondisiBarang"=> "90%",
    "HargaJual"=> 300000,
    "Ukuran"=> "Sedang",
    "Toko"=> "RAFZ STORE",
    "Deskripsi"=> "Set panci tahan lama untuk kebutuhan dapur."
    ],
    18 => [
    "No"=> 18,
    "NamaBarang"=> "Tas Ransel Kulit",
    "Merk"=> "LeatherMan",
    "Kategori"=> "Fashion",
    "KondisiBarang"=> "88%",
    "HargaJual"=> 450000,
    "Ukuran"=> "Medium",
    "Toko"=> "BagHouse",
    "Deskripsi"=> "Ransel kulit elegan untuk kerja maupun kuliah."
    ],
    19 => [
    "No"=> 19,
    "NamaBarang"=> "Drone Mini",
    "Merk"=> "SkyLite",
    "Kategori"=> "Hobi",
    "KondisiBarang"=> "85%",
    "HargaJual"=> 790000,
    "Ukuran"=> "Kecil",
    "Toko"=> "RAFZ STORE",
    "Deskripsi"=> "Drone mini mudah dikendalikan untuk pemula."
    ],
    20 => [
    "No"=> 20,
    "NamaBarang"=> "Keyboard Mechanical",
    "Merk"=> "TypePro",
    "Kategori"=> "Elektronik",
    "KondisiBarang"=> "92%",
    "HargaJual"=> 680000,
    "Ukuran"=> "TKL",
    "Toko"=> "RAFZ STORE",
    "Deskripsi"=> "Keyboard mechanical dengan switchtactile."
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
