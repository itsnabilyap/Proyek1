<?php
// beli.php
// Pastikan file ini disimpan di folder yang sama dengan barang.txt dan hapus.php
// Ganti nomor WA sesuai kebutuhan
$nohp = "6281284076324";

function read_items(){
    if(!file_exists("barang.txt")) return [];
    // Baca tanpa newline di akhir, abaikan baris kosong
    $lines = file("barang.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $items = [];
    foreach($lines as $line){
        $parts = explode("|", $line);
        // pastikan ada minimal 2 bagian
        if(count($parts) >= 2){
            $items[] = [
                'nama' => trim($parts[0]),
                'harga' => trim($parts[1])
            ];
        }
    }
    return $items;
}

$items = read_items();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Daftar Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="navbar">
   <a href="index.php">HOME</a>
   <a href="jual.php">TAMBAH BARANG</a>
</div>

<div class="container">
<h1>Daftar Barang Dijual</h1>

<?php if(count($items) === 0): ?>
    <p><i>Belum ada barang yang dijual.</i></p>
<?php else: ?>
    <table border="1" cellpadding="8">
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Beli</th>
            <th>Hapus</th>
        </tr>
    <?php foreach($items as $index => $it): 
        $pesan = urlencode("Halo, saya ingin membeli barang: {$it['nama']} dengan harga Rp {$it['harga']}");
    ?>
        <tr>
            <td><?php echo $index + 1; ?></td>
            <td><?php echo htmlspecialchars($it['nama']); ?></td>
            <td>Rp <?php echo htmlspecialchars($it['harga']); ?></td>
            <td><a href="https://wa.me/<?php echo $nohp; ?>?text=<?php echo $pesan; ?>" target="_blank">BELI VIA WA</a></td>
            <td>
                <!-- Form POST untuk hapus (lebih aman dan tidak sensitif ke caching) -->
                <form method="post" action="hapus.php" style="margin:0;">
                    <input type="hidden" name="id" value="<?php echo $index; ?>">
                    <button type="submit" onclick="return confirm('Yakin ingin hapus barang ini?')">HAPUS</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </table>
<?php endif; ?>

<hr>

<pre style="background:#f7f7f7;padding:10px;border:1px solid #ddd;">
<?php 
echo htmlspecialchars(is_file("barang.txt") ? file_get_contents("barang.txt") : "(file barang.txt tidak ada)");
?>
</pre>

</div>
</body>
</html>
