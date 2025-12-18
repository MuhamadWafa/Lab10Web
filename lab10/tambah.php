<?php
error_reporting(E_ALL);
include_once("database.php");
include_once("form.php"); 

$db = new Database(); 

if (isset($_POST['submit']))
{
    $nama       = $_POST['nama'];
    $kategori   = $_POST['kategori'];
    $harga_jual = $_POST['harga_jual'];
    $harga_beli = $_POST['harga_beli'];
    $stok       = $_POST['stok'];
    $file_gambar = $_FILES['file_gambar'];
    $gambar     = null;

    // Proses upload gambar
    if ($file_gambar ['error'] == 0) 
    {
        $filename    = str_replace(' ', '_', $file_gambar ['name']);
        $destination = dirname(__FILE__) . '/gambar/'. $filename; 
        if(move_uploaded_file($file_gambar ['tmp_name'], $destination)) 
        {
            $gambar = $filename; 
        }
    }
    
    $data_insert = [
        'nama' => $nama, 
        'kategori' => $kategori, 
        'harga_jual' => $harga_jual, 
        'harga_beli' => $harga_beli, 
        'stok' => $stok, 
        'gambar' => $gambar 
    ];

    // Menggunakan method insert() Class Database
    $result = $db->insert('data_barang', $data_insert);

    if ($result) {
        header('location: index.php');
        exit;
    } else {
        $error = "Gagal menyimpan data ke database.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <title>Tambah Barang</title>
</head>
<body>
    <div class="container">
        <h1>Tambah Barang</h1>
        <div class="main">
            <?php 
                if (isset($error)) {
                    echo "<p style='color: red;'>$error</p>";
                } 
                
                $form = new Form("tambah.php", "Simpan"); 
                
                // Fields dibuat secara modular
                $form->addField("nama", "Nama Barang");
                $form->addSelect("kategori", "Kategori", ['Komputer', 'Elektronik', 'Hand Phone']);
                $form->addField("harga_jual", "Harga Jual", "number");
                $form->addField("harga_beli", "Harga Beli", "number");
                $form->addField("stok", "Stok", "number");
                $form->addField("file_gambar", "File Gambar (Kosongkan jika tidak diubah)", "file", "", false);
                
                $form->displayForm(); 
            ?>
        </div>
    </div>
</body>
</html>