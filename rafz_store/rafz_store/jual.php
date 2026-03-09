<!DOCTYPE html>
<html>
<head>
    <title>Jual Barang</title>
</head>
<body>

<h2>Form Jual Barang</h2>

<form method="post">
    Nama Barang : <input type="text" name="nama" required><br><br>
    Harga Barang : <input type="number" name="harga" required><br><br>
    <input type="submit" name="jual" value="Jual Barang">
</form>

<?php
if(isset($_POST['jual'])){
    $nama = trim($_POST['nama']);
    $harga = trim($_POST['harga']);

    // Format: Nama|Harga per baris
    $data = $nama . "|" . $harga . "\n";

    // Pastikan file bisa ditulis
    file_put_contents("barang.txt", $data, FILE_APPEND | LOCK_EX);

    echo "<br><b>Barang berhasil ditambahkan!</b><br>";
}
?>

<br><a href="index.php">Kembali ke Menu</a>

</body>
</html>
