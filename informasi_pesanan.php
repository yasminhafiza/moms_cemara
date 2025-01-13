<?php
session_start();
include 'koneksi/koneksi.php';

// Pastikan session id_user ada dan valid
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Anda harus login terlebih dahulu.'); window.location.href='login.php';</script>";
    exit;
}

$id_user = $_SESSION['user_id']; // Mengambil ID pengguna yang login

// Cek apakah keranjang belanja ada
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<script>alert('Keranjang belanja Anda kosong.'); window.location.href='index.php';</script>";
    exit;
}

// Hitung total harga produk
$total_harga_produk = 0;
foreach ($_SESSION['cart'] as $cart_item) {
    $total_harga_produk += $cart_item['harga'] * $cart_item['quantity'];
}

// Inisialisasi variabel
$shipping_cost = 0;
$payment_method = '';
$catatan = '';
$alamat_pengiriman = '';
$ekspedisi = '';

// Cek apakah form sudah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validasi metode pengiriman
    if (isset($_POST['shipping'])) {
        $ekspedisi = $_POST['shipping'];
        switch ($ekspedisi) {
            case 'gosend-sameday':
                $shipping_cost = 20000;
                break;
            case 'gosend-instan':
                $shipping_cost = 19000;
                break;
            case 'grab-instan':
                $shipping_cost = 17000;
                break;
            default:
                $shipping_cost = 0;
                break;
        }
    }

    if (empty($ekspedisi) || $shipping_cost <= 0) {
        echo "<script>alert('Metode pengiriman tidak valid.'); window.location.href='checkout.php';</script>";
        exit;
    }

    // Mengambil metode pembayaran
    if (isset($_POST['payment'])) {
        $payment_method = $_POST['payment'];
    }

    // Validasi metode pembayaran
    if (empty($payment_method)) {
        echo "<script>alert('Metode pembayaran tidak valid.'); window.location.href='checkout.php';</script>";
        exit;
    }

    // Mengambil catatan dan alamat pengiriman
    $catatan = isset($_POST['catatan']) ? mysqli_real_escape_string($koneksi, $_POST['catatan']) : '';
    $alamat_pengiriman = isset($_POST['alamat_pengiriman']) ? mysqli_real_escape_string($koneksi, $_POST['alamat_pengiriman']) : '';

    // Hitung total pembayaran
    $total_bayar = $total_harga_produk + $shipping_cost;

    if ($total_bayar <= 0) {
        echo "<script>alert('Total pembayaran tidak valid.'); window.location.href='checkout.php';</script>";
        exit;
    }

    // Mulai transaksi
    mysqli_begin_transaction($koneksi);

    try {
        // Insert data pesanan
        $query = "INSERT INTO pesanan (id_user, alamat_pengiriman, catatan, tanggal_pesanan, status, total, ekspedisi, shipping, payment_method) 
                  VALUES ($id_user, '$alamat_pengiriman', '$catatan', NOW(), 'pending', $total_bayar, '$ekspedisi', $shipping_cost, '$payment_method')";
        if (!mysqli_query($koneksi, $query)) {
            throw new Exception('Error inserting pesanan: ' . mysqli_error($koneksi));
        }

        $id_pesanan = mysqli_insert_id($koneksi);

        // Insert detail pesanan
        foreach ($_SESSION['cart'] as $cart_item) {
            $id_produk = $cart_item['id_produk'];
            $quantity = $cart_item['quantity'];
            $subtotal = $cart_item['harga'] * $quantity;

            $query_detail = "INSERT INTO pesanan_detail (id_pesanan, id_produk, quantity, subtotal) 
                             VALUES ($id_pesanan, $id_produk, $quantity, $subtotal)";
            if (!mysqli_query($koneksi, $query_detail)) {
                throw new Exception('Error inserting pesanan detail: ' . mysqli_error($koneksi));
            }
        }

        // Insert pembayaran
        $query_pembayaran = "INSERT INTO pembayaran (id_pesanan, metode_pembayaran, total_bayar, tanggal_bayar) 
                             VALUES ($id_pesanan, '$payment_method', $total_bayar, NOW())";
        if (!mysqli_query($koneksi, $query_pembayaran)) {
            throw new Exception('Error inserting pembayaran: ' . mysqli_error($koneksi));
        }

        // Insert status pesanan
        $query_status = "INSERT INTO status_pesanan (id_pesanan, status, waktu_status) 
                         VALUES ($id_pesanan, 'pending', NOW())";
        if (!mysqli_query($koneksi, $query_status)) {
            throw new Exception('Error inserting status pesanan: ' . mysqli_error($koneksi));
        }

        // Commit transaksi
        mysqli_commit($koneksi);

        // Kosongkan keranjang belanja
        unset($_SESSION['cart']);

        echo "<script>alert('Pemesanan berhasil!'); window.location.href='pembayaran.php?id_pesanan=$id_pesanan';</script>";
    } catch (Exception $e) {
        // Rollback transaksi jika terjadi kesalahan
        mysqli_rollback($koneksi);
        echo "<script>alert('Terjadi kesalahan: " . $e->getMessage() . "'); window.location.href='checkout.php';</script>";
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
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">
    <!-- Jika menggunakan PNG, sesuaikan dengan kode ini -->
    <link rel="icon" href="assets/foto/logo.jpg" type="image/png">

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />
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
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="1440" height="600" viewBox="0 0 1440 600" fill="none"><path d="M1440 600H0.124157C0.124157 544.093 0.124059 202.017 0 143.434C198.57 167.744 357.089 186.04 591.833 143.434C1010.19 67.503 1440 0 1440 0V600Z" fill="%23FFC9DB"/></svg>') no-repeat center;
            background-size: cover;
        }

        .wave-bg-2 {
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="1440" height="146" viewBox="0 0 1440 146" fill="none"><path d="M0 20.8938L48.4195 10.7718C124.756 -5.18625 203.768 -3.04866 279.13 17.0134L316.327 26.9154C383.493 44.7958 454.358 43.2253 520.666 22.3868V22.3868C587.959 1.23882 659.923 -0.0582481 727.934 18.651L777.877 32.3898C830.591 46.8909 885.327 52.6482 939.905 49.4324L1027.47 44.2732C1058.75 42.4298 1089.8 37.649 1120.19 29.994L1154.68 21.3058C1236.24 0.761541 1321.67 1.12426 1403.05 22.3604L1440 32.002V141.016L0 145.502V20.8938Z" fill="%23FFB9D1"/></svg>') no-repeat center;
            background-size: cover;
        }

        .wave-bg-3 {
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="1440" height="149" viewBox="0 0 1440 149" fill="none"><defs><linearGradient id="paint0_linear_283_1184" x1="720" y1="0" x2="720" y2="149" gradientUnits="userSpaceOnUse"><stop stop-color="%23FFE0EB"/><stop offset="1" stop-color="%23FFB9D1"/></linearGradient></defs><path d="M0 0.501953L98.0261 20.8944C159.266 33.6343 222.553 32.8175 283.444 18.5013V18.5013C334.059 6.60103 386.417 4.00843 437.96 10.8501L476.714 15.9942C521.366 21.9213 566.615 21.7873 611.232 15.5958L637.298 11.9786C692.011 4.38604 747.63 6.42342 801.641 17.9986V17.9986C867.779 32.1729 936.187 32.0156 1002.26 17.5372L1004.18 17.1172C1054.4 6.11109 1106.07 3.20159 1157.21 8.49877L1208.13 13.7728C1242.29 17.3103 1276.71 17.32 1310.87 13.802L1440 0.501953V148.502H0V0.501953Z" fill="url(%23paint0_linear_283_1184)"/></svg>') no-repeat center;
            background-size: cover;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document
                .getElementById("btn-selengkapnya")
                .addEventListener("click", function() {
                    Swal.fire({
                        title: '<h2 class="text-xl font-bold">Tentang <span class="text-pink-500">Mom&#39;s Cemara</span></h2>',
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
                            confirmButton: "bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded-xl",
                        },
                    });
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
                    confirmButton: "bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded-xl",
                },
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            const mobileMenuButton = document.querySelector("button.md\\:hidden");
            const mobileMenu = document.getElementById("mobile-menu");

            mobileMenuButton.addEventListener("click", function() {
                const isHidden = mobileMenu.classList.contains("hidden");
                if (isHidden) {
                    mobileMenu.classList.remove("hidden");
                } else {
                    mobileMenu.classList.add("hidden");
                }
            });

            // Close menu when clicking outside
            document.addEventListener("click", function(event) {
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

<body>
    <!-- Navbar -->
    <!-- Navbar -->
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
                    href="keranjang.php"
                    class="flex justify-center hover:text-black">
                    <img
                        src="assets/foto/Shopping Bag.png"
                        alt="Shopping Bag"
                        class="w-6 h-6" />
                </a>
                <a href="index.php" class="hover:text-black text-center">Beranda</a>
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

    <!-- Hero Section -->
    <section
        class="bg-[#B6EADD] min-h-screen flex flex-col justify-center items-center pt-20 pb-20 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md md:max-w-3xl mb-6 flex flex-row items-center">
            <img src="assets/foto/tombol_balik.png" alt="backing" class="mr-2 mt-2" />
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">
                Informasi Pemesanan, Selamat Berbelanja <?php echo $_SESSION['user_name']; ?>
            </h1>
        </div>
        <div
            class="bg-pink-100 w-full max-w-md md:max-w-3xl rounded-lg shadow-lg p-4 sm:p-6">
            <!-- Shopping Cart Items -->
            <div class="space-y-4">

                <!-- Item 3 -->
                <div class="container mx-auto px-4 py-8">
                    <h1 class="text-2xl font-bold text-center mb-6">Informasi Pesanan Anda</h1>

                    <!-- Shopping Cart Items -->
                    <div class="space-y-4">
                        <?php foreach ($_SESSION['cart'] as $cart_item): ?>
                            <div class="flex flex-row items-center border-b-2 border-black pb-4">
                                <img src="assets/foto_produk/<?= $cart_item['gambar'] ?>" alt="<?= $cart_item['nama_produk'] ?>" class="w-22 h-20 sm:w-18 h-20 rounded-md object-cover mb-4">
                                <div class="ml-4 flex-1">
                                    <h2 class="text-lg font-semibold"><?= $cart_item['nama_produk'] ?></h2>
                                    <p class="text-sm text-gray-600">Harga: Rp <?= number_format($cart_item['harga'], 0, ',', '.') ?></p>
                                    <p class="text-sm text-gray-600">Jumlah: <?= $cart_item['quantity'] ?></p>
                                    <p class="text-sm font-bold">Subtotal: Rp <?= number_format($cart_item['harga'] * $cart_item['quantity'], 0, ',', '.') ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <form action="informasi_pesanan.php" method="POST">

                    <!-- Notes Section -->
                    <div class="mt-4">
                        <textarea name="catatan" id="catatan" rows="3"
                            class="w-full p-2 border rounded-md focus:ring focus:ring-pink-300 text-sm sm:text-base"
                            placeholder="Catatan (maksimal 150 kata)"></textarea>
                    </div>

                    <!-- Alamat Penerima -->
                    <div>
                        <p class="text-base sm:text-lg font-bold text-gray-700 mt-4 -mb-2">Alamat Penerima</p>
                    </div>
                    <div class="mt-4">
                        <textarea name="alamat_pengiriman" id="alamat_pengiriman" rows="3"
                            class="w-full p-2 border rounded-md focus:ring focus:ring-pink-300 text-sm sm:text-base"
                            placeholder="Masukkan alamat" required>
                          </textarea>
                    </div>


                    <!-- Shipping Method Dropdown -->
                    <div class="mb-4">
                        <label for="shipping" class="block text-base sm:text-lg font-bold text-gray-700 mb-2">Metode Pengiriman</label>
                        <select name="shipping" id="shipping" class="w-full p-3 border rounded-md" required onchange="updateShippingCost()">
                            <option value="" disabled selected>Pilih metode pengiriman</option>
                            <option value="gosend-sameday" data-cost="20000">GoSend Same Day - Rp. 20.000</option>
                            <option value="gosend-instan" data-cost="19000">GoSend Instan - Rp. 19.000</option>
                            <option value="grab-instan" data-cost="17000">Grab Instan - Rp. 17.000</option>
                        </select>
                        <!-- Input hidden untuk mengirim nilai shipping cost -->
                        <input type="hidden" name="shipping_cost" id="shipping_cost" value="0">
                    </div>


                    <!-- Payment Method Dropdown -->
                    <div class="mb-4">
                        <label for="payment" class="block text-base sm:text-lg font-bold text-gray-700 mb-2">Metode Pembayaran</label>
                        <select name="payment" id="payment" class="w-full p-2 border rounded-md focus:ring focus:ring-pink-300 text-sm sm:text-base">
                            <option value="" disabled selected>Pilih metode pembayaran</option>
                            <option value="BI">Bank Indonesia (BI)</option>
                            <option value="Mandiri">Bank Mandiri</option>
                            <option value="BRI">Bank Rakyat Indonesia (BRI)</option>
                            <option value="BCA">Bank Central Asia (BCA)</option>
                            <option value="BNI">Bank Negara Indonesia (BNI)</option>
                            <option value="BTN">Bank Tabungan Negara (BTN)</option>
                            <option value="CIMB Niaga">Bank CIMB Niaga</option>
                        </select>
                    </div>

                    <!-- Subtotal and Button -->
                    <div class="flex flex-col space-y-3 mt-6" id="order-summary" style="display:none;">
                        <div class="flex flex-row justify-between items-center">
                            <p class="text-md sm:text-md font-semibold text-gray-700">Subtotal Produk</p>
                            <p class="text-md sm:text-md font-semibold text-gray-800" id="product-subtotal">Rp <?= number_format($total_harga_produk, 0, ',', '.') ?></p>
                        </div>

                        <div class="flex flex-row justify-between items-center">
                            <p class="text-md sm:text-md font-semibold text-gray-700">Subtotal Pengiriman</p>
                            <p class="text-md sm:text-md font-semibold text-gray-800" id="shipping-subtotal">Rp 0</p>
                        </div>

                        <div class="flex flex-row justify-between items-center">
                            <p class="text-md sm:text-md font-semibold text-gray-700">Metode Pembayaran</p>
                            <p class="text-md sm:text-md font-semibold text-gray-800" id="payment-method">-</p>
                        </div>

                        <div class="flex flex-row justify-between items-center pt-2 border-t border-gray-200">
                            <p class="text-base sm:text-lg font-bold text-gray-700">Total Pembayaran</p>
                            <p class="text-base sm:text-lg font-bold text-gray-800" id="total-payment">Rp 0</p>
                        </div>
                        <input type="hidden" name="total_bayar" id="total_bayar" value="<?= $total_pembayaran ?>">
                    </div>

                    <!-- Pemesanan and Lanjutkan Pemesanan Buttons -->
                    <button type="button" id="order-button" class="w-auto sm:w-auto mt-4 py-2 px-3 bg-pink-500 hover:bg-pink-600 text-white rounded-md font-semibold shadow-lg text-sm sm:text-base max-w-md md:max-w-3xl">
                        Pemesanan
                    </button>

                    <button type="submit" id="submit-button" class="w-auto sm:w-auto mt-4 py-2 px-3 bg-teal-500 hover:bg-teal-600 text-white rounded-md font-semibold shadow-lg text-sm sm:text-base max-w-md md:max-w-3xl" style="display:none;">
                        Lanjutkan Pemesanan
                    </button>

                    <script>
                        // Fungsi untuk memperbarui biaya pengiriman
                        function updateShippingCost() {
                            const shippingSelect = document.getElementById('shipping');
                            const selectedOption = shippingSelect.options[shippingSelect.selectedIndex];
                            const shippingCost = parseInt(selectedOption.getAttribute('data-cost')) || 0;

                            // Set nilai shipping_cost ke dalam input hidden
                            document.getElementById('shipping_cost').value = shippingCost;
                        }

                        // Event listener untuk tombol "Order"
                        document.getElementById('order-button').addEventListener('click', function() {
                            const shippingSelect = document.getElementById('shipping');
                            const paymentSelect = document.getElementById('payment');

                            const shippingValue = shippingSelect.value;
                            const shippingCost = parseInt(shippingSelect.options[shippingSelect.selectedIndex].getAttribute('data-cost')) || 0;
                            const paymentValue = paymentSelect.value;

                            // Cek apakah metode pengiriman dan metode pembayaran sudah dipilih
                            if (!shippingValue) {
                                alert("Harap pilih metode pengiriman!");
                                return;
                            } else if (!paymentValue) {
                                alert("Harap pilih metode pembayaran!");
                                return;
                            }

                            // Subtotal Produk (dari PHP)
                            const productSubtotal = <?= $total_harga_produk ?>;

                            // Subtotal Pengiriman berdasarkan pilihan pengguna
                            const shippingSubtotal = shippingCost;

                            // Hitung Total Pembayaran (Subtotal Produk + Subtotal Pengiriman)
                            const totalPayment = productSubtotal + shippingSubtotal;

                            // Tampilkan informasi subtotal dan metode pembayaran
                            document.getElementById('product-subtotal').textContent = "Rp " + productSubtotal.toLocaleString();
                            document.getElementById('shipping-subtotal').textContent = "Rp " + shippingSubtotal.toLocaleString();
                            document.getElementById('payment-method').textContent = paymentSelect.options[paymentSelect.selectedIndex].text;

                            // Tampilkan Total Pembayaran
                            document.getElementById('total-payment').textContent = "Rp " + totalPayment.toLocaleString();
                            document.getElementById('total_bayar').value = totalPayment; // Update nilai total_bayar

                            // Tampilkan ringkasan pemesanan
                            document.getElementById('order-summary').style.display = 'block';

                            // Tampilkan tombol Lanjutkan Pemesanan
                            document.getElementById('submit-button').style.display = 'inline-block';
                        });
                    </script>


                </form>
            </div>

    </section>



    <div class="wave-bg-3 relative bg-[#FFE0EB]">
        <div class="absolute w-full h-36 top-0"></div>
        <div
            class="max-w-screen-2xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 p-8 relative z-10">
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
                    class="flex flex-col sm:flex-row gap-2 sm:gap-4 justify-start items-center">
                    <input
                        type="email"
                        placeholder="Enter your email Address"
                        class="px-4 py-2 w-2/3 shadow-xl md:w-1/2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-pink-500" />
                    <button onclick="aboutus()"
                        class="px-4 py-2 bg-teal-500 text-white rounded-lg shadow-xl hover:bg-teal-600">
                        Subscribe
                    </button>
                </div>
            </div>

            <!-- Section Logo dan Sosial Media -->
            <div class="text-center md:text-right p-10">
                <img
                    src="assets/foto/logo.png"
                    alt="Mom's Cemara Logo"
                    class="w-24 h-24 mx-auto rounded-lg shadow-lg md:ml-auto mb-4" />
                <div
                    class="flex justify-center md:justify-center space-x-4 text-pink-600">
                    <a href="#" class="hover:text-pink-800">
                        <img
                            class="h-10 w-10"
                            src="assets/foto/instagram.png"
                            alt="instagram" />
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
                class="wave-bg-2 absolute w-full h-20 top-0 flex items-center justify-center">
                <span class="text-gray-600 text-sm">© 2024 All Rights Reserved</span>
            </div>
            <div
                class="max-w-screen-xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 p-8 relative z-10"></div>
        </div>
    </div>
</body>

</html>