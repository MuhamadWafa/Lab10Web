<?php
include_once("database.php");

$db = new Database();

// Mengambil data menggunakan method Class Database
$result  = $db->getAll('data_barang', 'id_barang DESC');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <title>Data Barang</title>
</head>
<body>
    <div class="container">
        <h1>Data Barang</h1>
        <a href="tambah.php" class="btn-tambah">Tambah Barang</a> 
        <div class="main">
            <table>
                <tr>
                    <th>Gambar</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Harga Jual</th>
                    <th>Harga Beli</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
                <?php if($result && $result->num_rows > 0): ?> 
                <?php while($row = $result->fetch_array()): ?> 
                <tr>
                    <td>
                        <?php if ($row['gambar']): ?>
                            <img src="gambar/<?= htmlspecialchars($row['gambar']);?>" alt="<?= htmlspecialchars($row['nama']);?>" style="max-width: 100px; max-height: 100px;">
                        <?php else: ?>
                            Tidak Ada Gambar
                        <?php endif; ?>
                    </td> 
                    
                    <td><?= htmlspecialchars($row['nama']);?></td>
                    <td><?= htmlspecialchars($row['kategori']);?></td>
                    <td><?= htmlspecialchars($row['harga_jual']);?></td>
                    <td><?= htmlspecialchars($row['harga_beli']);?></td>
                    <td><?= htmlspecialchars($row['stok']);?></td>
                    <td>
                        <a href="ubah.php?id=<?= $row['id_barang'];?>">Ubah</a> 
                        <a href="hapus.php?id=<?= $row['id_barang'];?>" onclick="return confirm('Yakin akan menghapus data ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; else: ?>
                <tr>
                    <td colspan="7">Belum ada data di database.</td>
                </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</body>
</html>