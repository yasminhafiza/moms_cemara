<?php 
include 'koneksi/koneksi.php';
$_SESSION['user_name'] = $username; // Simpan username setelah login berhasil

$query = "SELECT * FROM kategori WHERE nama_kategori = 'Brownies'";

$result = mysqli_query($koneksi, $query);
$kategori = mysqli_fetch_assoc($result);

$query_produk = "SELECT * FROM produk WHERE id_kategori = " .$kategori['id_kategori'];
$produk_result = mysqli_query($koneksi, $query_produk);
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

    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">
    <!-- Jika menggunakan PNG, sesuaikan dengan kode ini -->
    <link rel="icon" href="assets/foto/logo.jpg" type="image/png"> 

    
    <title>Pasta</title>
    <style>
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

      .scrollbar-hide::-webkit-scrollbar {
        display: none;
      }
      .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
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

    
    </script>
   
  </head>
  <body class="bg-pink-100 font-sans antialiased">
     <!-- Navbar -->
     <nav
    class="flex items-center justify-between px-4 md:px-8 lg:px-12 py-4 bg-gray-300/50 backdrop-blur-md fixed w-full z-50">
    <div class="flex items-center">
      <img
        src="assets/foto/logo.png"
        alt="logo"
        class="w-8 h-8 md:w-10 md:h-10 lg:w-12 lg:h-12 rounded-full" />
      <span class="ml-2 text-sm md:text-base lg:text-lg font-bold text-white">MOM'S CEMARA</span>
    </div>

    <!-- Desktop Menu -->
    <div
      class="hidden md:flex items-center space-x-4 lg:space-x-6 text-white">
      <a href="keranjang.php"><button>
          <img
            src="assets/foto/Shopping Bag.png"
            alt="Shopping Bag"
            class="w-6 h-6 lg:w-7 lg:h-7" /></button></a>
      <a
        href="index.php"
        class="hover:text-gray-300 text-sm lg:text-base">Beranda</a>
      <a
        href="index.php#menu-section"
        class="hover:text-gray-300 text-sm lg:text-base">
        Menu
      </a>

      <a
        href="index.php#promo-section"
        class="hover:text-gray-300 text-sm lg:text-base">
        Promo
      </a>

      <!-- Tombol Profile dengan Dropdown -->
      <div class="relative">
        <button
          id="profileMenuButton"
          class="flex items-center px-3 py-1.5 lg:px-4 lg:py-2 rounded-lg hover:bg-white hover:text-gray-800 transition text-sm lg:text-base">
          <img
            src="assets/foto/avatar.png"
            alt="User Avatar"
            class="w-8 h-8 sm:w-9 sm:h-9 md:w-10 md:h-10 rounded-full object-cover" />
        </button>
        <!-- Dropdown Menu -->
        <div
          id="profileDropdown"
          class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
          <a
            href="pelanggan/profile_user.php"
            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
            Profile
          </a>
          <a
            href="logout.php"
            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
        Keluar
          </a>
        </div>
      </div>

      <script>
        document.addEventListener("DOMContentLoaded", function() {
          const profileMenuButton = document.getElementById("profileMenuButton");
          const profileDropdown = document.getElementById("profileDropdown");

          // Toggle dropdown visibility
          profileMenuButton.addEventListener("click", function() {
            profileDropdown.classList.toggle("hidden");
          });

          // Close dropdown when clicking outside
          document.addEventListener("click", function(event) {
            if (
              !profileDropdown.contains(event.target) &&
              !profileMenuButton.contains(event.target)
            ) {
              profileDropdown.classList.add("hidden");
            }
          });
        });
      </script>

    </div>

    <!-- Mobile Menu Button -->
    <button class="md:hidden text-white">
      <svg
        class="w-6 h-6"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24">
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M4 6h16M4 12h16M4 18h16"></path>
      </svg>
    </button>

    <!-- Mobile Menu -->
    <div
      id="mobile-menu"
      class="hidden md:hidden fixed top-16 right-0 h-screen w-64 bg-gray-300/50 backdrop-blur-md p-4 z-40 transform transition-transform duration-300">
      <div class="flex flex-col space-y-4 text-white">
        <a
          href="keranjang_belanja.html"
          class="flex justify-center hover:text-black">
          <img
            src="assets/foto/Shopping Bag.png"
            alt="Shopping Bag"
            class="w-6 h-6" />
        </a>
        <a href="index_after.html" class="hover:text-black text-center">Beranda</a>
        <a class="hover:text-black text-center">Menu</a>
        <a class="hover:text-black text-center">Promo</a>
        <a
          href="logout.php"
          class="hover:text-black text-center">
          Logout
        </a>
        <a href="pelanggan/profile_user.php" class="hover:text-black text-center">
          <div class="flex justify-center items-center gap-2">
            <a href="pelanggan/profile_user.php" class="flex items-center gap-2"><img
                src="assets/foto/avatar.png"
                alt=""
                class="w-8 h-8 rounded-full object-cover" />
              <span class="text-sm">Lihat Profil</span></a>
          </div>
        </a>
      </div>
    </div>
  </nav>


    <!-- Card section -->
    <div class="max-w-7xl mx-auto p-3 pt-24 pb-32">
    <div class="flex flex-row items-center mb-8">
  <a href="index.php">
    <img src="assets/foto/tombol_balik.png" alt="backing" class="mr-2" />
  </a>
  <h1 class="text-2xl font-bold text-gray-800">
    Menu Pilihan Pasta 
  </h1>
  
</div>


      <!-- Horizontal Scrollable Menu -->
      <div class="relative overflow-x-auto">
        <div class="flex flex-nowrap md:mx-auto md:flex-wrap gap-4 pb-4 overflow-x-scroll md:overflow-x-auto scrollbar-hide">
            <?php
            // Menampilkan produk pasta dalam card
            while ($produk = mysqli_fetch_assoc($produk_result)) {
            ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden min-w-[280px] md:w-[calc(25%-0.75rem)] flex flex-col">
                <h2 class="text-lg font-semibold text-center py-4 mt-2 h-[72px] flex items-center justify-center">
                    <?php echo $produk['nama_produk']; ?>
                </h2>
                <img src="assets/foto_produk/<?php echo $produk['gambar']; ?>" alt="<?php echo $produk['nama_produk']; ?>" class="w-full h-40 object-cover" />
                <div class="p-3 flex flex-col flex-grow">
                    <div class="flex justify-between items-start mb-4">
                        <p class="text-gray-600 text-sm w-2/3 h-auto">
                            <?php echo $produk['deskripsi']; ?>
                        </p>
                        <span class="text-lg font-bold text-gray-700 pl-4 whitespace-nowrap">
                            RP <?php echo number_format($produk['harga'], 0, ',', '.'); ?>
                        </span>
                    </div>
                    <div class="flex justify-end mt-auto">
                    <button class="bg-green-500 text-white px-4 py-2 mt-3 rounded add-to-cart" data-id="<?php echo $produk['id_produk']; ?>">Tambah</button>

                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    </div>

    <script>
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', async () => {
            const productId = button.dataset.id;

            try {
                const response = await fetch('keranjang.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id_produk: productId })
                });

                const result = await response.json();
                if (result.success) {
                    // Redirect ke halaman keranjang tanpa alert
                    window.location.href = 'keranjang.php';
                } else {
                    alert('Terjadi kesalahan, coba lagi.'); // Pesan error jika gagal
                }
            } catch (error) {
                alert('Tidak dapat terhubung ke server.'); // Pesan error koneksi
            }
        });
    });
</script>

    <div class="wave-bg-3 relative bg-[#FFE0EB]">
      <div class="absolute w-full h-36 top-0"></div>
      <div
        class="max-w-screen-2xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 p-8 relative z-10"
      >
        <!-- Section Tentang Kami -->
        <div class="text-left text-gray-800 py-10">
          <h2 class="text-lg font-semibold mb-2">Tentang Kami</h2>
          <p class="text-sm">
            Jl. Tipar<br />
            RT. 05 RW. 07 No. 15<br />
            Pekayon, Pasar Rebo, Jakarta Timur
          </p>
        </div>

        <!-- Section Subscribe -->
        <div class="text-left py-10">
          <p class="text-sm mb-4 font-bold">
            Subscribe untuk mendapatkan informasi <br />promo terbaru tentang
            produk Mom's Cemara
          </p>
          <div
            class="flex flex-col sm:flex-row gap-2 sm:gap-4 justify-start items-center"
          >
            <input
              type="email"
              placeholder="Enter your email Address"
              class="px-4 py-2 w-2/3 shadow-xl md:w-1/2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-pink-500"
            />
            <button
              class="px-4 py-2 bg-teal-500 text-white rounded-lg shadow-xl hover:bg-teal-600"
            >
              Subscribe
            </button>
          </div>
        </div>

        <!-- Section Logo dan Sosial Media -->
        <div class="text-center md:text-right p-10">
          <img
            src="assets/foto/logo.png"
            alt="Mom's Cemara Logo"
            class="w-24 h-24 mx-auto rounded-lg shadow-lg md:ml-auto mb-4"
          />
          <div
            class="flex justify-center md:justify-center space-x-4 text-pink-600"
          >
            <a href="#" class="hover:text-pink-800">
              <img
                class="h-10 w-10"
                src="assets/foto/instagram.png"
                alt="instagram"
              />
            </a>
            <a href="#" class="hover:text-pink-800">
              <img class="h-10 w-10" src="assets/foto/whatsapp.png" alt="whatsapp" />
            </a>
            <a href="#" class="hover:text-pink-800">
              <img class="h-10 w-10" src="assets/foto/mail.png" alt="mail" />
            </a>
          </div>
        </div>
      </div>
      <!-- Footer -->
      <div class="wave-bg-1 relative -mt-1">
        <div
          class="wave-bg-2 absolute w-full h-20 top-0 flex items-center justify-center"
        >
          <span class="text-gray-600 text-sm">© 2024 All Rights Reserved</span>
        </div>
        <div
          class="max-w-screen-xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 p-8 relative z-10"
        ></div>
      </div>
    </div>
  </body>
</html>
