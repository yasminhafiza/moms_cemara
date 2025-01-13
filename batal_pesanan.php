<?php
include 'koneksi/koneksi.php';

if (isset($_GET['id_pesanan'])) {
    $id_pesanan = $_GET['id_pesanan'];

    // Mulai transaksi untuk memastikan data konsisten
    $koneksi->begin_transaction();

    try {
        // Hapus data dari tabel status_pesanan (jika perlu)
        $sql_delete_status = "DELETE FROM status_pesanan WHERE id_pesanan = ?";
        $stmt_status = $koneksi->prepare($sql_delete_status);
        $stmt_status->bind_param("s", $id_pesanan);
        $stmt_status->execute();

        // Hapus data dari tabel pesanan_detail
        $sql_delete_detail = "DELETE FROM pesanan_detail WHERE id_pesanan = ?";
        $stmt_detail = $koneksi->prepare($sql_delete_detail);
        $stmt_detail->bind_param("s", $id_pesanan);
        $stmt_detail->execute();

        // Hapus data dari tabel pesanan
        $sql_delete_pesanan = "DELETE FROM pesanan WHERE id_pesanan = ?";
        $stmt_pesanan = $koneksi->prepare($sql_delete_pesanan);
        $stmt_pesanan->bind_param("s", $id_pesanan);
        $stmt_pesanan->execute();

        // Commit transaksi
        $koneksi->commit();

        // Menampilkan alert dan mengarahkan ke halaman index.php
        echo "<script>
                alert('Pesanan berhasil dibatalkan.');
                window.location.href = 'index.php';
              </script>";
    } catch (Exception $e) {
        // Rollback transaksi jika terjadi error
        $koneksi->rollback();
        echo "<script>
                alert('Gagal membatalkan pesanan: " . $e->getMessage() . "');
              </script>";
    }
} else {
    echo "<script>
            alert('ID Pesanan tidak diberikan.');
            window.location.href = 'index.php';
          </script>";
}

$koneksi->close();
?>
