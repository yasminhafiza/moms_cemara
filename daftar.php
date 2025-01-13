<?php
include 'koneksi/koneksi.php';

// Cek apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $username = $_POST['username'];
    $phone = $_POST['no_hp'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validasi input
    if (empty($username) || empty($phone) || empty($email) || empty($password)) {
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
    } else {
        // Mengecek apakah email sudah ada di database
        $email_check_query = "SELECT * FROM pelanggan WHERE email = '$email'";
        $result = $koneksi->query($email_check_query);

        if ($result->num_rows > 0) {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Email Sudah Terdaftar',
                        text: 'Alamat email ini sudah terdaftar. Silakan gunakan email lain.',
                        confirmButtonColor: '#EF4444'
                    });
                });
            </script>";
        } else {
            // Hash password sebelum disimpan
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Query untuk menyimpan data ke dalam database
            $sql = "INSERT INTO pelanggan (nama, email, phone_number, password) VALUES ('$username', '$email', '$phone', '$hashed_password')";

            if ($koneksi->query($sql) === TRUE) {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Akun Berhasil Dibuat',
                            text: 'Akun Berhasil Dibuat.',
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
                            text: 'Terjadi kesalahan, coba lagi.',
                            confirmButtonColor: '#EF4444'
                        });
                    });
                </script>";
            }
        }
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

    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">
    <!-- Jika menggunakan PNG, sesuaikan dengan kode ini -->
    <link rel="icon" href="assets/foto/logo.jpg" type="image/png"> 

    <title>Login User</title>
</head>

  <body>
    <style>
      .swal2-popup {
        background-color: #ffddef !important; /* pink-50 */
      }
    </style>

    <div class="flex flex-col lg:flex-row min-h-screen">
      <!-- Bagian Kiri -->
      <div
        class="hidden lg:flex flex-col items-center justify-center w-full lg:w-1/2 bg-pink-50 p-4 sm:p-6 lg:p-12 transition-all duration-700 transform opacity-0 lg:opacity-100 translate-x-[-100%] lg:translate-x-0"
      >
        <div class="transform transition-transform hover:scale-105">
          <img
            src="assets/foto/logo.png"
            alt="Logo"
            class="w-32 h-32 sm:w-40 sm:h-40 md:w-48 md:h-48 mx-auto rounded-[20%] shadow-lg"
          />
        </div>
        <p
          class="mt-4 sm:mt-6 text-lg sm:text-xl md:text-2xl font-bold text-black text-center leading-relaxed"
        >
          Rasakan Cinta di
          <span class="text-pink-500 animate-pulse">Setiap Gigitan</span>
        </p>
      </div>

      <!-- Bagian Kanan -->
      <div
        class="flex items-center justify-center w-full min-h-screen lg:w-1/2 bg-green-100 p-4 sm:p-6 lg:p-12"
      >
        <div
          class="bg-pink-50 p-6 sm:p-8 rounded-lg shadow-lg w-full max-w-md mx-auto transform transition-all duration-300 hover:shadow-xl"
        >
          <h2
            class="text-xl sm:text-2xl md:text-3xl font-bold text-center text-black mb-6"
          >
            Daftar
          </h2>

          <!-- Form -->
          <form method="POST" action="" class="space-y-4 md:space-y-6">
            <div class="mb-4">
              <div
                class="flex items-center border border-gray-300 rounded-md bg-white hover:border-pink-500 transition-colors duration-300"
              >
                <span class="p-2 text-gray-500">
                  <img
                    src="assets/foto/username.png"
                    alt="username"
                    class="w-9 h-9"
                  />
                </span>
                <input
                  type="text"
                  id="username"
                  name="username"
                  placeholder="Masukkan Nama"
                  class="w-full p-2 md:p-3 text-sm md:text-base border-none focus:ring-0 focus:outline-none rounded-md"
                />
              </div>
            </div>

            <div class="mb-4">
              <div
                class="flex items-center border border-gray-300 rounded-md bg-white hover:border-pink-500 transition-colors duration-300"
              >
                <span class="p-2 text-gray-500">
                  <img src="assets/foto/call.png" alt="Telepon" class="w-9 h-9" />
                </span>
                <input
                  type="text"
                  id="no_hp"
                  name="no_hp"
                  placeholder="Masukkan Nomor Telepon"
                  class="w-full p-2 md:p-3 text-sm md:text-base border-none focus:ring-0 focus:outline-none rounded-md"
                />
              </div>
            </div>

            <div class="mb-4">
              <div
                class="flex items-center border border-gray-300 rounded-md bg-white hover:border-pink-500 transition-colors duration-300"
              >
                <span class="p-2 text-gray-500">
                  <img src="assets/foto/email.png" alt="email" class="w-9 h-9" />
                </span>
                <input
                  type="email"
                  id="email"
                  name="email"
                  placeholder="Masukkan Email"
                  class="w-full p-2 md:p-3 text-sm md:text-base border-none focus:ring-0 focus:outline-none rounded-md"
                />
              </div>
            </div>

            <div class="mb-4">
              <div
                class="flex items-center border border-gray-300 rounded-md bg-white hover:border-pink-500 transition-colors duration-300"
              >
                <span class="p-2 text-gray-500">
                  <img
                    src="assets/foto/password.png"
                    alt="password"
                    class="w-9 h-9"
                  />
                </span>
                <input
                  type="password"
                  id="password"
                  name="password"
                  placeholder="Masukkan Kata Sandi"
                  class="w-full p-2 md:p-3 text-sm md:text-base border-none focus:ring-0 focus:outline-none rounded-md"
                />
              </div>
            </div>

            <button
              type="submit"
              class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 md:py-3 md:text-lg rounded-md transform transition-all duration-300 hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50"
            >
              Daftar
            </button>
          </form>

          <p class="mt-6 text-center text-sm md:text-base text-gray-600">
            Sudah Punya Akun?
            <a
              href="login.php"
              class="text-pink-500 font-semibold hover:text-pink-600 hover:underline transition-colors duration-300"
              >Masuk Disini</a
            >
          </p>
        </div>
      </div>
    </div>

   


  </body>
</html>





