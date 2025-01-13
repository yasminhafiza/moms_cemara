<?php
session_start();
include 'koneksi/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (!empty($email) && !empty($new_password) && !empty($confirm_password)) {
        if ($new_password !== $confirm_password) {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Kata sandi baru dan konfirmasi kata sandi tidak cocok.',
                            confirmButtonColor: '#EF4444'
                        });
                    });
                </script>";
        } else {
            $sql = "SELECT * FROM pelanggan WHERE email = '$email'";
            $result = $koneksi->query($sql);

            if ($result->num_rows > 0) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_sql = "UPDATE pelanggan SET password = '$hashed_password' WHERE email = '$email'";

                if ($koneksi->query($update_sql) === TRUE) {
                    echo "<script>
                            document.addEventListener('DOMContentLoaded', function() {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Kata sandi telah diperbarui. Silakan login menggunakan kata sandi baru.',
                                    confirmButtonColor: '#10B981'
                                }).then(function() {
                                    window.location.href = 'login.php';
                                });
                            });
                        </script>";
                } else {
                    echo "<script>
                            document.addEventListener('DOMContentLoaded', function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: 'Terjadi kesalahan saat memperbarui kata sandi.',
                                    confirmButtonColor: '#EF4444'
                                });
                            });
                        </script>";
                }
            } else {
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Email tidak ditemukan.',
                                confirmButtonColor: '#EF4444'
                            });
                        });
                    </script>";
            }
        }
    } else {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Semua kolom harus diisi.',
                        confirmButtonColor: '#EF4444'
                    });
                });
            </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />
    <!-- Add Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <title>Reset Kata Sandi</title>
</head>

<body class="bg-green-100">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-pink-50 p-6 rounded-lg shadow-lg w-full max-w-md mx-auto">
            <h2 class="text-2xl font-bold text-center text-black mb-6">Reset Kata Sandi</h2>
            <form method="POST" action="" class="space-y-4">
                <div class="relative">
                    <input type="email" name="email" id="email" placeholder="Masukkan Email" class="w-full p-3 pl-10 border rounded-md" required />
                    <i class="fas fa-envelope absolute left-3 top-4 text-gray-400"></i> <!-- Email Icon -->
                </div>
                <div class="relative">
                    <input type="password" name="new_password" id="new_password" placeholder="Kata Sandi Baru" class="w-full p-3 pl-10 border rounded-md" required />
                    <i class="fas fa-lock absolute left-3 top-4 text-gray-400"></i> <!-- Password Icon -->
                </div>
                <div class="relative">
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Konfirmasi Kata Sandi" class="w-full p-3 pl-10 border rounded-md" required />
                    <i class="fas fa-lock absolute left-3 top-4 text-gray-400"></i> <!-- Confirm Password Icon -->
                </div>
                <button type="submit" class="w-full bg-green-700 text-white font-semibold py-2 rounded-md hover:bg-green-600">Simpan Perubahan</button>
            </form>

        </div>
    </div>
</body>

</html>