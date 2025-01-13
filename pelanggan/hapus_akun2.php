<?php
session_start();
include '../koneksi/koneksi.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    echo "<script>
        alert('Silakan login terlebih dahulu!');
        window.location.href = '../login.php';
    </script>";
    exit();
}

// Ambil ID pengguna dari session
$user_id = $_SESSION['user_id'];

// Jika ada parameter 'action' untuk konfirmasi penghapusan
if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    // Query untuk menghapus data pengguna
    $sql = "DELETE FROM pelanggan WHERE id_user = '$user_id'";

    if ($koneksi->query($sql) === TRUE) {
        // Hapus session dan redirect ke halaman login
        session_destroy();
        echo "<script>
            alert('Akun berhasil dihapus!');
            window.location.href = '../login.php';
        </script>";
    } else {
        echo "<script>
            alert('Gagal menghapus akun. Silakan coba lagi!');
            window.location.href = 'profile_user.php';
        </script>";
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Hapus Akun</title>
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">
    <!-- Jika menggunakan PNG, sesuaikan dengan kode ini -->
    <link rel="icon" href="../assets/foto/logo.jpg" type="image/png"> 
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
        Swal.fire({
            title: 'Apakah Anda yakin ingin menghapus akun?',
            text: "Proses ini tidak dapat dibatalkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#299076',
            cancelButtonColor: '#C40043',
            confirmButtonText: 'Hapus Akun',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Arahkan ke proses hapus akun
                window.location.href = '?action=delete';
            } else {
                // Kembali ke halaman profil
                window.location.href = 'profile_user.php';
            }
        });
    </script>
</body>
</html>
