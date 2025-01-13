
<?php
session_start();
include 'koneksi/koneksi.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {  // Gunakan 'user_id' yang sudah benar
    // Jika belum login, arahkan ke halaman login
    header("Location: landing.php");
    exit();
}

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
        document
          .getElementById("btn-selengkapnya")
          .addEventListener("click", function () {
            Swal.fire({
              title:
                '<h2 class="text-xl font-bold">Tentang <span class="text-pink-500">Mom&#39;s Cemara</span></h2>',
              html: `<div class="text-left bg-[#B6EADD]">
                        <p class="mb-4">Moms Cemara adalah sebuah toko kue yang berdedikasi untuk menghadirkan kue-kue berkualitas tinggi dengan cita rasa rumahan yang autentik. Didirikan dengan cinta dan semangat untuk menciptakan kelezatan yang dapat dinikmati oleh seluruh keluarga, Moms Cemara memastikan bahwa setiap produk dibuat dari bahan-bahan terbaik dan resep yang telah teruji, sehingga semua produk yang diproduksi sudah teruji halal.</p>
                        <p>Moms Cemara percaya bahwa kue bukan hanya sekedar makanan, tetapi juga sebuah sarana untuk menyebarkan kebahagiaan dan kehangatan. Oleh karena itu, setiap kue yang dihasilkan tidak hanya enak, tetapi juga dibuat dengan penuh perhatian dan kasih sayang, sehingga setiap gigitan membawa kebahagiaan tersendiri.</p>
                    </div>`,
              showCloseButton: true,
              showConfirmButton: false,
              customClass: {
                popup: "bg-[#B6EADD]",
                title: "text-black",
                htmlContainer: "text-white",
                confirmButton:
                  "bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded-xl",
              },
            });
          });
      });

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

      function aboutus() {
        Swal.fire({
          position: "top-mid",
          icon: "success",
          title: "Nantikan Info Promo Menarik Lainnya",
          showConfirmButton: false,
          timer: 1500,
          customClass: {
            popup: "bg-[#FFE0EB]",
            title: "text-black",
            htmlContainer: "text-white",
            confirmButton:
              "bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded-xl",
          },
        });
      }
    </script>

<script>
      // Example login status (this could be set after a user logs in)
      let isLoggedIn = false; // Change this based on the user's authentication status

      // Function to show login alert
      function showLoginAlert() {
        Swal.fire({
          title: "You must be logged in to access the dashboard!",
          icon: "warning",
          confirmButtonText: "Login"
        }).then((result) => {
          if (result.isConfirmed) {
            // Redirect to login page or show login form
            window.location.href = "login.html"; // Update this to your login page
          }
        });
      }

      // Button click event listener for accessing the dashboard
      document.getElementById('dashboardBtn').addEventListener('click', function() {
        if (!isLoggedIn) {
          showLoginAlert();
        } else {
          // Redirect to dashboard if logged in
          window.location.href = "login.php"; // Update with your dashboard page
        }
      });
    </script>

    
  </head>
  <body>
    <!-- Navbar -->
    <nav
      class="flex items-center justify-between px-4 md:px-8 lg:px-12 py-4 bg-gray-300/50 backdrop-blur-md fixed w-full z-50"
    >
      <div class="flex items-center">
        <img
          src="assets/foto/logo.png"
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
        <a href="keranjang.php"
          ><button>
            <img
              src="assets/foto/Shopping Bag.png"
              alt="Shopping Bag"
              class="w-6 h-6 lg:w-7 lg:h-7"
            /></button
        ></a>
        <a
          href="index.php"
          class="hover:text-gray-300 text-sm lg:text-base"
          >Beranda</a
        >
        <a
        onclick="document.getElementById('menu-section').scrollIntoView({ behavior: 'smooth' });"
          class="hover:text-gray-300 text-sm lg:text-base"
          >Menu</a
        >
        <a
        onclick="document.getElementById('promo-section').scrollIntoView({ behavior: 'smooth' }); return false;"
        class="hover:text-gray-300 text-sm lg:text-base"
          >
              Promo
          </a>

        <!-- Tombol Profile dengan Dropdown -->
<div class="relative">
  <button
    id="profileMenuButton"
    class="flex items-center px-3 py-1.5 lg:px-4 lg:py-2 rounded-lg hover:bg-white hover:text-gray-800 transition text-sm lg:text-base"
  >
    <img
      src="assets/foto/avatar.png"
      alt="User Avatar"
      class="w-8 h-8 sm:w-9 sm:h-9 md:w-10 md:h-10 rounded-full object-cover"
    />
  </button>
  <!-- Dropdown Menu -->
  <div
    id="profileDropdown"
    class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50" style="margin-bottom: 10px;"
  >
    <a
      href="pelanggan/profile_user.php"
      class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
    >
      Profile
    </a>
    <a
      href="logout.php"
      class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
    >
     Keluar 
    </a>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const profileMenuButton = document.getElementById("profileMenuButton");
    const profileDropdown = document.getElementById("profileDropdown");

    // Toggle dropdown visibility
    profileMenuButton.addEventListener("click", function () {
      profileDropdown.classList.toggle("hidden");
    });

    // Close dropdown when clicking outside
    document.addEventListener("click", function (event) {
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
          <a
            href="keranjang_belanja.html"
            class="flex justify-center hover:text-black"
          >
            <img
              src="assets/foto/Shopping Bag.png"
              alt="Shopping Bag"
              class="w-6 h-6"
            />
          </a>
          <a href="index_after.html" class="hover:text-black text-center"
            >Beranda</a
          >
          <a  class="hover:text-black text-center"
            >Menu</a
          >
          <a  class="hover:text-black text-center"
            >Promo</a
          >
          <a
      href="logout.php"
     class="hover:text-black text-center"
    >
      Logout
    </a>
          <a href="pelanggan/profile_user.php" class="hover:text-black text-center">
            <div class="flex justify-center items-center gap-2">
              <a href="pelanggan/profile_user.php" class="flex items-center gap-2"
                ><img
                  src="assets/foto/avatar.png"
                  alt=""
                  class="w-8 h-8 rounded-full object-cover"
                />
                <span class="text-sm">Lihat Profil</span></a
              >
            </div>
          </a>
        </div>
      </div>
    </nav>




    <!-- Hero Section -->
    <div
      id="hero"
      class="flex flex-col items-start justify-center w-full min-h-screen bg-[url('assets/foto/kuepiebuah1.png')] bg-cover bg-center text-white px-4 sm:px-8 md:px-12 lg:px-20"
    >
      <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-6xl font-bold mb-4">
      Selamat datang, <?php echo $_SESSION['user_name']; ?> di <br> Mom's Cemara
      </h1>
      <p class="text-base sm:text-lg md:text-xl mb-6">
        Di mana Setiap Gigitan Terasa Nikmat!
      </p>
      <button
    class="px-4 py-2 md:px-6 md:py-3 bg-transparent border border-white rounded-lg hover:bg-white hover:text-black transition text-sm md:text-base"
    onclick="document.getElementById('menu-section').scrollIntoView({ behavior: 'smooth' });"
>
    Order Sekarang
</button>

    </div>




    <!-- Menu Section -->
    <div id="menu-section" class="bg-[#B6EADD] px-4 sm:px-6 md:px-8 lg:px-12 py-8 md:py-12">
      <div class="max-w-7xl mx-auto">
        <h2
          class="text-xl sm:text-2xl md:text-3xl lg:text-6xl font-bold text-center mb-4"
        >
          Menu <span class="text-[#FF5791]">Mom's Cemara</span>
        </h2>
        <p
          class="text-center text-sm sm:text-base md:text-lg text-gray-700 max-w-2xl mx-auto mb-8"
        >
          Setiap kue yang diproduksi mencerminkan dedikasi untuk memberikan yang
          terbaik bagi pelanggan.
        </p>

        <div class="relative">
          <div
            class="flex overflow-x-auto gap-4 md:gap-6 lg:gap-8 snap-x snap-mandatory no-scrollbar"
          >



            <!-- Menu Cards -->
            <div
              class="flex-none w-60 sm:w-64 md:w-72 bg-white rounded-lg shadow-lg overflow-hidden snap-start"
            >
              <a href="pasta.php">
                <img
                  src="assets/foto/pasta/pasta.png"
                  alt="Pasta"
                  class="w-full h-40 md:h-48 object-cover"
                />
                <div class="p-4">
                  <h3 class="text-lg md:text-xl font-semibold mb-2">Pasta</h3>
                  <p class="text-gray-600 text-sm md:text-base">
                    Nikmati kelezatan pasta dengan cita rasa autentik yang
                    memanjakan lidah setiap suapan.
                  </p>
                </div>
              </a>
            </div>
            <div
              class="flex-none w-60 sm:w-64 md:w-72 bg-white rounded-lg shadow-lg overflow-hidden snap-start"
            >
              <a href="kue_kering.php">
                <img
                  src="assets/foto/kue_kering/kue_kering.png"
                  alt="kue kering"
                  class="w-full h-40 md:h-48 object-cover"
                />
                <div class="p-4">
                  <h3 class="text-lg md:text-xl font-semibold mb-2">
                    Kue Kering
                  </h3>
                  <p class="text-gray-600 text-sm md:text-base">
                    Nikmati kelezatan pasta dengan cita rasa autentik yang
                    memanjakan lidah setiap suapan.
                  </p>
                </div>
              </a>
            </div>
            <div
              class="flex-none w-60 sm:w-64 md:w-72 bg-white rounded-lg shadow-lg overflow-hidden snap-start"
            >
              <a href="jajanan.php">
                <img
                  src="assets/foto/jajanan_pasar/jajanan_pasar.png"
                  alt="jajanan pasar"
                  class="w-full h-40 md:h-48 object-cover"
                />
                <div class="p-4">
                  <h3 class="text-lg md:text-xl font-semibold mb-2">
                    Jajanan Pasar
                  </h3>
                  <p class="text-gray-600 text-sm md:text-base">
                    Nikmati kelezatan pasta dengan cita rasa autentik yang
                    memanjakan lidah setiap suapan.
                  </p>
                </div>
              </a>
            </div>
            <div
              class="flex-none w-60 sm:w-64 md:w-72 bg-white rounded-lg shadow-lg overflow-hidden snap-start"
            >
              <a href="brownies.php">
                <img
                  src="assets/foto/brownies/brownies.png"
                  alt="brownies"
                  class="w-full h-40 md:h-48 object-cover"
                />
                <div class="p-4">
                  <h3 class="text-lg md:text-xl font-semibold mb-2">
                    Brownies
                  </h3>
                  <p class="text-gray-600 text-sm md:text-base">
                    Nikmati kelezatan pasta dengan cita rasa autentik yang
                    memanjakan lidah setiap suapan.
                  </p>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Promo Section -->
    <div id="promo-section" class="bg-[#FFE0EB] px-4 sm:px-6 md:px-8 lg:px-12 py-8 md:py-12">
      <div class="text-center mb-8">
        <h1
          class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-black"
        >
          Promo <span class="text-pink-500">Mom's Cemara</span>
        </h1>
      </div>

      <!-- Promo Cards -->
      <div id="promo-section" class="max-w-5xl mx-auto">
        <!-- Promo Akhir Tahun -->
        <div class="bg-[#BFE7E0] rounded-lg shadow-md p-4 sm:p-6 md:p-8 mb-6">
          <div class="flex flex-col">
            <div class="flex justify-between items-center flex-wrap gap-4">
              <div class="flex-1 text-center">
                <h2
                  class="text-xl sm:text-2xl md:text-3xl font-bold text-black"
                >
                  Promo Akhir Tahun
                </h2>
                <p class="text-black text-sm sm:text-base md:text-lg mt-2">
                  Diskon <span class="text-pink-500 font-bold">25%</span> untuk
                  pembelian
                  <span class="font-semibold">minimal 3 item</span> dan
                  <span class="font-semibold">boleh di mix</span>
                </p>
              </div>
              <button     onclick="document.getElementById('menu-section').scrollIntoView({ behavior: 'smooth' });"

                class="w-full sm:w-auto px-4 py-2 border border-black text-black rounded-lg hover:bg-white hover:text-pink-500 font-semibold"
              >
                Order Sekarang
              </button>
            </div>
          </div>

          <!-- Promo Items -->
          <div id="promo-section"
            class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-6"
          >
            <ul class="text-black font-bold space-y-2 text-sm md:text-base">
              <li>&#10003; Macaroni Panggang</li>
              <li>&#10003; Lasagna Panggang</li>
              <li>&#10003; Spaghetti Panggang</li>
            </ul>
            <ul class="text-black font-bold space-y-2 text-sm md:text-base">
              <li>&#10003; Risoles Mayo</li>
              <li>&#10003; Sosis Solo</li>
              <li>&#10003; Fudgy Brownies 20x20</li>
            </ul>
            <div
              class="text-black font-bold flex flex-col items-center text-sm md:text-base"
            >
              <span class="text-pink-500 font-bold w-full text-center"
                >FREE!</span
              >
              <span class="w-4/5 text-center"
                >1 Jar Strawberry Short Cake (100ml)</span
              >
              <span class="w-3/5 text-center">Khusus Pemesanan tanggal</span>
              <span class="w-2/5 text-center font-semibold"
                >22-25 Desember</span
              >
            </div>
          </div>
        </div>

        <!-- Promo Idul Fitri -->
        <div class="bg-[#BFE7E0] rounded-lg shadow-md p-4 sm:p-6 md:p-8">
          <div class="flex justify-between items-center flex-wrap gap-4">
            <h2
              class="text-xl sm:text-2xl md:text-3xl font-bold text-black text-center flex-1"
            >
              Promo Idul Fitri
            </h2>
            <button     onclick="document.getElementById('menu-section').scrollIntoView({ behavior: 'smooth' });"

              class="w-full sm:w-auto px-4 py-2 border border-black text-black rounded-lg hover:bg-white hover:text-pink-500 font-semibold"
            >
              Order Sekarang
            </button>
          </div>

          <div class="relative overflow-x-auto mt-6">
            <div class="flex space-x-4 overflow-x-auto pb-4 no-scrollbar">
              <div
                class="flex-none w-60 sm:w-64 bg-white rounded-lg shadow-md overflow-hidden relative"
              >
                <img
                  src="assets/foto/kue_kering/nastar.png"
                  alt="Nastar"
                  class="w-full h-32 object-cover"
                />
                <div
                  class="absolute inset-0 flex flex-col justify-between bg-black bg-opacity-30"
                >
                  <h3 class="font-semibold text-white p-2">NASTAR</h3>
                  <p class="text-white font-bold text-center pb-2">Rp.70.000</p>
                </div>
              </div>
              <div
                class="flex-none w-60 sm:w-64 bg-white rounded-lg shadow-md overflow-hidden relative"
              >
                <img
                  src="assets/foto/kue_kering/lidah_kucing.png"
                  alt="lidah kucing"
                  class="w-full h-32 object-cover"
                />
                <div
                  class="absolute inset-0 flex flex-col justify-between bg-black bg-opacity-30"
                >
                  <h3 class="font-semibold text-white p-2">LIDAH KUCING</h3>
                  <p class="text-white font-bold text-center pb-2">Rp.63.000</p>
                </div>
              </div>
              <div
                class="flex-none w-60 sm:w-64 bg-white rounded-lg shadow-md overflow-hidden relative"
              >
                <img
                  src="assets/foto/kue_kering/kastangel.png"
                  alt="kastangel"
                  class="w-full h-32 object-cover"
                />
                <div
                  class="absolute inset-0 flex flex-col justify-between bg-black bg-opacity-30"
                >
                  <h3 class="font-semibold text-white p-2">KASTANGEL</h3>
                  <p class="text-white font-bold text-center pb-2">Rp.70.000</p>
                </div>
              </div>
              <div
                class="flex-none w-60 sm:w-64 bg-white rounded-lg shadow-md overflow-hidden relative"
              >
                <img
                  src="assets/foto/kue_kering/nastar.png"
                  alt="Nastar"
                  class="w-full h-32 object-cover"
                />
                <div
                  class="absolute inset-0 flex flex-col justify-between bg-black bg-opacity-30"
                >
                  <h3 class="font-semibold text-white p-2">NASTAR</h3>
                  <p class="text-white font-bold text-center pb-2">Rp.70.000</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!--Tentang Mom's Cemara-->
    <div class="bg-[#FFE0EB]">
      <div class="max-w-5xl mx-auto p-6">
        <h2 class="text-6xl font-bold text-black text-center mb-14">
          Tentang <span class="text-green-600">Mom's Cemara</span>
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <p class="text-black text-2xl leading-relaxed">
            Moms Cemara adalah sebuah toko kue yang berdedikasi untuk
            menghadirkan kue-kue berkualitas tinggi dengan cita rasa rumahan
            yang otentik. Didirikan dengan cinta dan semangat untuk menciptakan
            kelezatan yang dapat dinikmati oleh seluruh keluarga, Moms Cemara
            memastikan bahwa setiap produk dibuat dari bahan-bahan terbaik dan
            resep yang telah teruji.
          </p>
          <div>
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.3287155855337!2d106.86498467586968!3d-6.351471462140132!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ed16e102fd27%3A0x96e7f3fe98af7bd7!2sMom&#39;s%20Cemara!5e0!3m2!1sid!2sid!4v1734029243238!5m2!1sid!2sid"
              width="600"
              height="450"
              style="border: 0"
              allowfullscreen=""
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"
              class="w-full rounded-md"
            ></iframe>
          </div>
        </div>
        <div class="text-center my-24">
          <button
            class="bg-green-500 text-white font-semibold px-6 py-2 rounded-lg shadow hover:bg-green-600"
            id="btn-selengkapnya"
          >
            Selengkapnya
          </button>
        </div>
      </div>
    </div>

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
            <button onclick="aboutus()"
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
