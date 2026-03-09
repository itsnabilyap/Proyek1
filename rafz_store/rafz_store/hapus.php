<?php
// hapus.php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: beli.php');
    exit;
}

if (!isset($_POST['id'])) {
    header('Location: beli.php');
    exit;
}

$id = (int) $_POST['id'];

$file = "barang.txt";
if (!file_exists($file)) {
    header('Location: beli.php');
    exit;
}

// baca baris, abaikan baris kosong
$data = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// jika id valid, hapus
if (isset($data[$id])) {
    unset($data[$id]);
    // reindex array supaya tidak ada index kosong
    $data = array_values($data);
    // tulis ulang file dengan newline per baris
    $written = file_put_contents($file, implode("\n", $data) . (count($data) ? "\n" : ""));
    // jika gagal menulis, bisa tampilkan error sementara (untuk debugging). 
    // Namun untuk produksi, kita redirect saja.
    if ($written === false) {
        echo "Gagal menulis file. Periksa permission file barang.txt";
        exit;
    }
}

header('Location: beli.php');
exit;
?>
