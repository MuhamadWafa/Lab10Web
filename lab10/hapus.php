<?php
include_once 'database.php';

$db = new Database(); 

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Ambil nama file gambar lama sebelum dihapus
    $data = $db->getOne('data_barang', "id_barang='{$id}'");
    $gambar_lama = $data['gambar'] ?? null;

    // Query DELETE menggunakan method delete() Class Database
    $result = $db->delete('data_barang', "id_barang = '{$id}'");

    if ($result) {
        // Hapus file gambar dari server jika ada
        if ($gambar_lama && file_exists(dirname(__FILE__) . '/gambar/' . $gambar_lama)) {
            unlink(dirname(__FILE__) . '/gambar/' . $gambar_lama);
        }
    } else {
        die("Gagal menghapus data.");
    }
}

header('location: index.php');
exit;
?>