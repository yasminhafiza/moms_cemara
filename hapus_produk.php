<?php
include '../koneksi/koneksi.php'; // Sertakan koneksi ke database

if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];

    // Hapus data terkait di tabel pesanan_detail
    $koneksi->query("DELETE FROM pesanan_detail WHERE id_produk='$id_produk'");

    // Hapus data di tabel produk
    $ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
    $data = $ambil->fetch_assoc();

    if ($data) {
        $koneksi->query("DELETE FROM produk WHERE id_produk='$id_produk'");
        echo "<script>alert('Produk berhasil dihapus.');</script>";
        echo "<script>location='index.php?halaman=produk';</script>";
    } else {
        echo "<script>alert('Produk tidak ditemukan');</script>";
        echo "<script>location='index.php?halaman=produk';</script>";
    }
}
?>
