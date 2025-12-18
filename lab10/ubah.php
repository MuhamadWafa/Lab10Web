<?php
error_reporting (E_ALL);
include_once("database.php");
include_once("form.php"); 

$db = new Database(); 

// 1. Logika Pemrosesan Form UPDATE saat di-submit
if (isset($_POST['submit']))
{
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $harga_jual = $_POST['harga_jual'];
    $harga_beli = $_POST['harga_beli'];
    $stok = $_POST['stok'];
    $file_gambar = $_FILES['file_gambar'];
    $gambar_lama = $_POST['gambar_lama'];
    $gambar = $gambar_lama;

    // Proses upload gambar baru (jika ada)
    if ($file_gambar ['error'] == 0)
    {
        $filename = str_replace(' ', '_', $file_gambar['name']);
        $destination = dirname(__FILE__) . '/gambar/' . $filename;
        
        if(move_uploaded_file($file_gambar ['tmp_name'], $destination)) {
            $gambar = $filename;
            // Hapus gambar lama jika ada
            if ($gambar_lama && file_exists(dirname(__FILE__) . '/gambar/' . $gambar_lama)) {
                unlink(dirname(__FILE__) . '/gambar/' . $gambar_lama);
            }
        }
    }

    $data_update = [
        'nama' => $nama, 
        'kategori' => $kategori, 
        'harga_jual' => $harga_jual, 
        'harga_beli' => $harga_beli, 
        'stok' => $stok, 
        'gambar' => $gambar 
    ];

    // Query UPDATE menggunakan method update() Class Database
    $result = $db->update('data_barang', $data_update, "id_barang='{$id}'");

    if ($result) {
        header('location: index.php');
        exit;
    } else {
        $error = "Gagal mengubah data.";
    }
} 

// 2. Logika Pengambilan Data Barang
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Menggunakan method getOne() dari Class Database
    $data = $db->getOne('data_barang', "id_barang='{$id}'");

    if (!$data) {
        header('location: index.php');
        exit;
    }
} else {
    header('location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <title>Ubah Barang</title>
</head>
<body>
    <div class="container">
        <h1>Ubah Barang</h1>
        <div class="main">
            <?php 
                if (isset($error)) {
                    echo "<p style='color: red;'>$error</p>";
                }
                
                $form = new Form("ubah.php", "Simpan Perubahan"); 
                
                // Fields diisi dengan data lama
                $form->addField("id", "", "hidden", $data['id_barang'], false); 
                $form->addField("gambar_lama", "", "hidden", $data['gambar'], false); 

                $form->addField("nama", "Nama Barang", "text", $data['nama']);
                $form->addSelect("kategori", "Kategori", ['Komputer', 'Elektronik', 'Hand Phone'], $data['kategori']);
                $form->addField("harga_jual", "Harga Jual", "number", $data['harga_jual']);
                $form->addField("harga_beli", "Harga Beli", "number", $data['harga_beli']);
                $form->addField("stok", "Stok", "number", $data['stok']);
                $form->addField("file_gambar", "File Gambar (Kosongkan jika tidak diubah)", "file", "", false);
                
                $form->displayForm();
            ?>
            <?php if ($data['gambar']): ?>
                <p>Gambar Saat Ini: 
                    <img src="gambar/<?php echo htmlspecialchars($data['gambar']);?>" style="max-width: 100px; max-height: 100px; display: block; margin-top: 10px;">
                </p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>