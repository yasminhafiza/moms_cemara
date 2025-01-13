<?php
session_start(); // Make sure the session is started for user identification

// Include your database connection file
include '../koneksi/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user typed 'HAPUS'
    if (isset($_POST['hapus_akun']) && strtoupper(trim($_POST['hapus_akun'])) == 'HAPUS') {
        
        // Get user data from session (make sure the user is logged in)
        $user_id = $_SESSION['user_id'];  // Assuming you store user ID in session

        // Prepare the SQL query to delete the user from the database
        $query = "DELETE FROM pelanggan WHERE id = ?";
        
        // Prepare the statement
        if ($stmt = $koneksi->prepare($query)) {
            // Bind parameters
            $stmt->bind_param("i", $user_id);

            // Execute the statement
            if ($stmt->execute()) {
                // If the deletion is successful, redirect or show success
                session_destroy(); // Optionally destroy the session if logged out
                header("Location: login_page.php");  // Redirect to login page after deletion
                exit;
            } else {
                // Handle errors if deletion fails
                echo "Error deleting account.";
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "Error preparing query.";
        }
    } else {
        // Handle invalid input
        echo "Input is invalid. Please type 'HAPUS' to confirm.";
    }
}

// Close the database connection
$koneksi->close();
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css"
    />
    <title>Mom's Cemara</title>
    <style>
      .no-scrollbar::-webkit-scrollbar {
        display: none;
      }
      .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
      }

      .wave-bg-1 {
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="1440" height="600" viewBox="0 0 1440 600" fill="none"><path d="M1440 600H0.124157C0.124157 544.093 0.124059 202.017 0 143.434C198.57 167.744 357.089 186.04 591.833 143.434C1010.19 67.503 1440 0 1440 0V600Z" fill="%23FFC9DB"/></svg>')
          no-repeat center;
        background-size: cover;
      }

      .wave-bg-2 {
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="1440" height="146" viewBox="0 0 1440 146" fill="none"><path d="M0 20.8938L48.4195 10.7718C124.756 -5.18625 203.768 -3.04866 279.13 17.0134L316.327 26.9154C383.493 44.7958 454.358 43.2253 520.666 22.3868V22.3868C587.959 1.23882 659.923 -0.0582481 727.934 18.651L777.877 32.3898C830.591 46.8909 885.327 52.6482 939.905 49.4324L1027.47 44.2732C1058.75 42.4298 1089.8 37.649 1120.19 29.994L1154.68 21.3058C1236.24 0.761541 1321.67 1.12426 1403.05 22.3604L1440 32.002V141.016L0 145.502V20.8938Z" fill="%23FFB9D1"/></svg>')
          no-repeat center;
        background-size: cover;
      }

      .wave-bg-3 {
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="1440" height="149" viewBox="0 0 1440 149" fill="none"><defs><linearGradient id="paint0_linear_283_1184" x1="720" y1="0" x2="720" y2="149" gradientUnits="userSpaceOnUse"><stop stop-color="%23FFE0EB"/><stop offset="1" stop-color="%23FFB9D1"/></linearGradient></defs><path d="M0 0.501953L98.0261 20.8944C159.266 33.6343 222.553 32.8175 283.444 18.5013V18.5013C334.059 6.60103 386.417 4.00843 437.96 10.8501L476.714 15.9942C521.366 21.9213 566.615 21.7873 611.232 15.5958L637.298 11.9786C692.011 4.38604 747.63 6.42342 801.641 17.9986V17.9986C867.779 32.1729 936.187 32.0156 1002.26 17.5372L1004.18 17.1172C1054.4 6.11109 1106.07 3.20159 1157.21 8.49877L1208.13 13.7728C1242.29 17.3103 1276.71 17.32 1310.87 13.802L1440 0.501953V148.502H0V0.501953Z" fill="url(%23paint0_linear_283_1184)"/></svg>')
          no-repeat center;
        background-size: cover;
      }
    </style>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const mobileMenuButton = document.querySelector("button.md\\:hidden");
        const mobileMenu = document.getElementById("mobile-menu");

        mobileMenuButton.addEventListener("click", function () {
          const isHidden = mobileMenu.classList.contains("hidden");
          if (isHidden) {
            mobileMenu.classList.remove("hidden");
          } else {
            mobileMenu.classList.add("hidden");
          }
        });

        // Close menu when clicking outside
        document.addEventListener("click", function (event) {
          if (
            !mobileMenu.contains(event.target) &&
            !mobileMenuButton.contains(event.target)
          ) {
            mobileMenu.classList.add("hidden");
          }
        });
      });

      function changeprofil() {
        Swal.fire({
          title: "Apakah Kamu Yakin?",
          showDenyButton: true,
          showCancelButton: false,
          confirmButtonText: "Simpan",
          denyButtonText: `Tidak`,
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            Swal.fire("Menghapus Akun!", "", "success");
          } else if (result.isDenied) {
            Swal.fire("Akun Gagal Dihapus", "", "info");
          }
        });
      }
    </script>
  </head>
  <body>
    <!-- Navbar -->
    <nav
      class="flex items-center justify-between px-4 md:px-8 lg:px-12 py-4 bg-gray-300/50 backdrop-blur-md fixed w-full z-50"
    >
      <div class="flex items-center">
        <img
          src="gambar/logo.png"
          alt="logo"
          class="w-8 h-8 md:w-10 md:h-10 lg:w-12 lg:h-12 rounded-full"
        />
        <span class="ml-2 text-sm md:text-base lg:text-lg font-bold text-white"
          >MOM'S CEMARA</span
        >
      </div>

      <!-- Desktop Menu -->
      <div
        class="hidden md:flex items-center space-x-4 lg:space-x-6 text-white"
      >
        <a href="keranjang_belanja.html"
          ><button>
            <img
              src="gambar/Shopping Bag.png"
              alt="Shopping Bag"
              class="w-6 h-6 lg:w-7 lg:h-7"
            /></button
        ></a>
        <a
          href="index_after.html"
          class="hover:text-gray-300 text-sm lg:text-base"
          >Beranda</a
        >
        <a
          href="index_after.html"
          class="hover:text-gray-300 text-sm lg:text-base"
          >Menu</a
        >
        <a
          href="index_after.html"
          class="hover:text-gray-300 text-sm lg:text-base"
          >Promo</a
        >
        <a href="profile_user.html">
          <button
            class="px-3 py-1.5 lg:px-4 lg:py-2 rounded-lg hover:bg-white hover:text-gray-800 transition text-sm lg:text-base"
          >
            <img
              src="gambar/avatar.png"
              alt=""
              class="w-8 h-8 sm:w-9 sm:h-9 md:w-10 md:h-10 rounded-full object-cover"
            />
          </button>
        </a>
      </div>

      <!-- Mobile Menu Button -->
      <button class="md:hidden text-white">
        <svg
          class="w-6 h-6"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M4 6h16M4 12h16M4 18h16"
          ></path>
        </svg>
      </button>

      <!-- Mobile Menu -->
      <div
        id="mobile-menu"
        class="hidden md:hidden fixed top-16 right-0 h-screen w-64 bg-gray-300/50 backdrop-blur-md p-4 z-40 transform transition-transform duration-300"
      >
        <div class="flex flex-col space-y-4 text-white">
          <!-- Profile section for mobile -->
          <div class="flex flex-col items-center mb-4">
            <img
              src="https://via.placeholder.com/80"
              alt="Profile Picture"
              class="rounded-full mb-4 w-24 h-24"
            />
            <p class="text-lg font-medium text-black">Maria Christin</p>
          </div>

          <!-- Navigation links -->
          <nav>
            <ul class="flex flex-col space-y-3">
              <li>
                <a
                  href="profile_user.html"
                  class="block p-2 rounded-md text-black text-center hover:bg-[#B6EADD]"
                  >Edit Profil</a
                >
              </li>
              <li>
                <a
                  href="pesanan_user.html"
                  class="block p-2 rounded-md text-black text-center hover:bg-[#B6EADD]"
                  >Pesanan Saya</a
                >
              </li>
              <li>
                <a
                  href="#"
                  class="block p-2 rounded-md text-black text-center hover:bg-[#B6EADD]"
                  >Hapus Akun</a
                >
              </li>
              <li>
                <a href="#" class="flex justify-center hover:text-black">
                  <img
                    src="gambar/Shopping Bag.png"
                    alt="Shopping Bag"
                    class="w-6 h-6"
                  />
                </a>
              </li>
              <li>
                <a
                  href="index_after.html"
                  class="block text-black text-center hover:text-black"
                  >Beranda</a
                >
              </li>
              <li>
                <a
                  href="index_after.html"
                  class="block text-black text-center hover:text-black"
                  >Menu</a
                >
              </li>
              <li>
                <a
                  href="index_after.html"
                  class="block text-black text-center hover:text-black"
                  >Promo</a
                >
              </li>
              <li>
                <button
                  class="p-2 mt-4 text-pink-600 border border-pink-600 rounded-md hover:bg-pink-300 w-full"
                >
                  Keluar
                </button>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </nav>

    <!-- Menu Section -->
    <div class="bg-[#B6EADD] min-h-screen flex flex-col lg:flex-row">
      <!-- Sidebar -->
      <div
        class="hidden lg:block w-full lg:w-1/4 bg-pink-200 p-6 lg:pt-36 flex flex-col justify-between"
      >
        <div>
          <div class="flex flex-col items-center">
            <img
              src="gambar/avatar.png"
              alt="Profile Picture"
              class="rounded-full mb-4 w-24 h-24 lg:w-36 lg:h-36"
            />
            <p class="text-lg font-medium">Maria Christin</p>
          </div>

          <nav class="mt-6 lg:mt-2">
            <ul
              class="flex flex-wrap lg:flex-col justify-center lg:justify-start"
            >
              <li class="mb-3 w-full sm:w-auto">
                <a
                  href="profile_user.html"
                  class="block p-2 rounded-md hover:bg-[#B6EADD] active:bg-[#B6EADD] w-full text-black text-center lg:text-left"
                  >Edit Profil</a
                >
              </li>
              <li class="mb-3 w-full sm:w-auto">
                <a
                  href="pesanan_user.html"
                  class="block p-2 rounded-md hover:bg-[#B6EADD] active:bg-[#B6EADD] w-full text-center lg:text-left"
                  >Pesanan Saya</a
                >
              </li>
              <li class="w-full sm:w-auto">
                <a
                  href="hapus_akun.html"
                  class="block p-2 rounded-md hover:bg-[#B6EADD] active:bg-[#B6EADD] w-full text-center lg:text-left"
                  >Hapus Akun</a
                >
              </li>
            </ul>
          </nav>
        </div>

        <button
          class="p-2 mt-4 text-pink-600 border border-pink-600 rounded-md hover:bg-pink-300 w-full"
        >
          Keluar
        </button>
      </div>

      <!-- Main Content -->
      <div
        class="w-full mt-32 sm:mt-32 md:mt-32 lg:w-3/4 p-4 lg:p-8 lg:mt-32 lg:ml-[5%]"
      >
        <div
          class="shadow rounded-md p-4 lg:p-6 bg-gray-300/50 backdrop-blur-md max-w-3xl"
        >
          <h1 class="text-xl font-bold mb-6 text-left">Hapus Akun</h1>

          <div class="flex flex-col lg:flex-row gap-8">
          <form action="hapus_akun2.php" method="POST" class="space-y-4 w-full lg:w-2/3">
    <div>
        <p class="text-left text-gray-700 mb-3">
            Menghapus akun Anda akan menghapus semua informasi Anda dari basis data kami. Hal ini tidak dapat dibatalkan.
        </p>
        <input
            type="text"
            placeholder="Untuk mengonfirmasi hal ini, ketik “HAPUS”"
            id="hapus_akun"
            name="hapus_akun"
            value=""
            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
    </div>

    <button
        type="submit"
        class="w-auto lg:w-auto p-2 bg-green-500 text-white rounded-md hover:bg-green-600 justify-start"
    >
        Simpan Perubahan
    </button>
</form>

          </div>
        </div>
      </div>
    </div>
  </body>
</html>
