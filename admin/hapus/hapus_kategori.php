<?php
include '../koneksi/koneksi.php'; // Sertakan koneksi ke database

// Pastikan ID kategori ada
if (isset($_GET['id'])) {
    $id_kategori = $_GET['id'];

    // Pastikan ID kategori valid dan ada di database
    $ambil = $koneksi->query("SELECT * FROM kategori WHERE id_kategori='$id_kategori'");
    $data = $ambil->fetch_assoc();

    if ($data) {
        // Menghapus kategori dari database
        $koneksi->query("DELETE FROM kategori WHERE id_kategori='$id_kategori'");

        // Redirect setelah berhasil dihapus
        echo "<script>alert('Kategori berhasil dihapus');</script>";
        echo "<script>location='index.php?halaman=kategori';</script>";
    } else {
        // Jika kategori tidak ditemukan
        echo "<script>alert('Kategori tidak ditemukan');</script>";
        echo "<script>location='index.php?halaman=kategori';</script>";
    }
}
?>
