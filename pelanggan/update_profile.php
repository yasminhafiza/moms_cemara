<?php
session_start();
include '../koneksi/koneksi.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    echo "<script>
        alert('Silakan login terlebih dahulu!');
        window.location.href = 'login.php';
    </script>";
    exit();
}

$user_id = $_SESSION['user_id'];
$nama = $_POST['nama'];
$telepon = $_POST['telepon'];
$email = $_POST['email'];
$password = $_POST['password'];

// Validasi input kosong
if (empty($nama) || empty($telepon) || empty($email)) {
    echo "<script>
        alert('Semua kolom wajib diisi!');
        window.location.href = 'profile_user.php';
    </script>";
    exit();
}

// Jika password diubah, hash password baru
$password_clause = '';
if (!empty($password)) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $password_clause = ", password = '$hashed_password'";
}

// Update data pengguna
$sql = "UPDATE pelanggan SET nama = '$nama', phone_number = '$telepon', email = '$email' $password_clause WHERE id_user = '$user_id'";

if ($koneksi->query($sql) === TRUE) {
    echo "<script>
        alert('Profil berhasil diperbarui!');
        window.location.href = 'profile_user.php';
    </script>";
} else {
    echo "<script>
        alert('Terjadi kesalahan. Coba lagi!');
        window.location.href = 'profile_user.php';
    </script>";
}
?>
