<?php
include '../koneksi/koneksi.php'; // Menghubungkan ke database

// Mendapatkan ID pesanan dari query parameter
$id_pesanan = $_GET['id_pesanan'];

// Query untuk mengambil detail pesanan berdasarkan ID
$query = "
    SELECT 
        p.id_pesanan,
        p.id_user,
        p.alamat_pengiriman,
        p.catatan,
        p.tanggal_pesanan,
        p.status AS pesanan_status,
        p.resi,
        p.total AS pesanan_total,
        p.ekspedisi,
        p.shipping,
        p.payment_method,
        pd.id_produk,
        pd.quantity,
        pd.subtotal AS detail_subtotal,
        py.metode_pembayaran,
        py.total_bayar,
        py.tanggal_bayar,
        pk.metode_pengiriman,
        pk.waktu_pengiriman,
        pk.status_pengiriman,
        pk.nama_kurir,
        pk.nomor_telepon_kurir,
        pf.nama_produk_foto
    FROM pesanan p
    LEFT JOIN pesanan_detail pd ON p.id_pesanan = pd.id_pesanan
    LEFT JOIN pembayaran py ON p.id_pesanan = py.id_pesanan
    LEFT JOIN pengiriman pk ON p.id_pesanan = pk.id_pesanan
    LEFT JOIN produk_foto pf ON pd.id_produk = pf.id_produk
    WHERE p.id_pesanan = ?
";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $id_pesanan);
$stmt->execute();
$result = $stmt->get_result();

// Mengecek apakah pesanan ditemukan
if ($result->num_rows > 0) {
    $order = $result->fetch_assoc(); // Mengambil detail pesanan
} else {
    echo "Order not found.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">
    <link rel="icon" href="../assets/foto/logo.jpg" type="image/png">
    <title>Order Details</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .gradient-bg {
            background: #B6EADD;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .card {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            width: 100%;
            max-width: 700px;
            overflow: hidden;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 0.5rem;
        }

        .detail-title {
            color: #6b7280;
            font-weight: 500;
        }

        .detail-value {
            color: #1f2937;
            font-weight: 600;
        }

        .button-back {
            background:rgb(240, 170, 182);
            color: white;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            font-weight: 700;
            text-align: center;
            display: inline-block;
            width: 100%;
            margin-top: 2rem;
            transition: all 0.3s;
        }

        .button-back:hover {
            background: #d81b60;
            transform: scale(1.05);
        }

        .icon {
            width: 24px;
            height: 24px;
            color: #f43f5e;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="fixed top-0 left-0 h-full w-80 lg:w-60 bg-pink-300/90 backdrop-blur-md flex flex-col items-center py-7 z-70">
        <div class="flex flex-col items-center space-y-6">
            <img src="../assets/foto/logo.png" alt="logo" class="w-10 h-10 lg:w-12 lg:h-12 rounded-full" />
            <span class="text-sm md:text-base lg:text-lg font-bold text-white text-center">MOM'S CEMARA</span>
        </div>
        <div class="mt-8 flex flex-col space-y-4 lg:space-y-6 text-white">
            <a href="../keranjang.php" class="flex flex-col items-center hover:text-gray-300">
                <img src="../assets/foto/Shopping Bag.png" alt="Shopping Bag" class="w-6 h-6 lg:w-7 lg:h-7" />
                <span class="text-xs lg:text-sm">Keranjang</span>
            </a>
            <a href="../index.php" class="flex flex-col items-center hover:text-gray-300">
                <svg class="w-6 h-6 lg:w-7 lg:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-9 6v10m6-10l2 2m-2-2v10"></path>
                </svg>
                <span class="text-xs lg:text-sm">Beranda</span>
            </a>
            <a href="../index.php#menu-section" class="flex flex-col items-center hover:text-gray-300">
                <svg class="w-6 h-6 lg:w-7 lg:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m4 6H8"></path>
                </svg>
                <span class="text-xs lg:text-sm">Menu</span>
            </a>
            
            <a href="../pelanggan/profile_user.php" class="flex flex-col items-center hover:text-gray-300">
                <img src="../assets/foto/avatar.png" alt="avatar" class="w-8 h-8 lg:w-10 lg:h-10 rounded-full object-cover" />
                <span class="text-xs lg:text-sm">Profil</span>
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="ml-100 lg:ml-20">
        <div class="gradient-bg">
            <div class="card">
                <h1 class="card-title">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Detail Pemesanan
                </h1>
                <!-- General Order Details -->
                <div class="detail-row">
                    <p class="detail-title"><strong>ID PEMESANAN</strong></p>
                    <p class="detail-value">#<?= htmlspecialchars($order['id_pesanan']) ?></p>
                </div>
                <div class="detail-row">
                    <p class="detail-title">Tanggal Pemesanan</p>
                    <p class="detail-value"><?= htmlspecialchars($order['tanggal_pesanan']) ?></p>
                </div>
                <div class="detail-row">
                    <p class="detail-title">Status Pemesanan</p>
                    <p class="detail-value"><?= htmlspecialchars($order['pesanan_status']) ?></p>
                </div>

                <!-- Shipping Details -->
                <h2 class="card-title">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h11m-4 4h4m-9 4h11m-2-4h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v8a2 2 0 002 2h2z" />
                    </svg>
                    Detail Pengiriman
                </h2>
                <div class="detail-row">
                <p class="detail-title mr-5"><strong>Alamat Pengiriman</strong></p>
                <p class="detail-value"><?= htmlspecialchars($order['alamat_pengiriman']) ?></p>
                </div>
                <div class="detail-row">
                    <p class="detail-title">Metode Pengirim</p>
                    <p class="detail-value"><?= htmlspecialchars($order['ekspedisi']) ?></p>
                </div>
                <div class="detail-row">
                    <p class="detail-title"><strong>Nomor Resi ( Tracking number )</strong></p>
                    <p class="detail-value"><?= htmlspecialchars($order['resi']) ?></p>
                </div>
                <div class="detail-row">
                    <p class="detail-title">Nama Pengirim</p>
                    <p class="detail-value"><?= htmlspecialchars($order['nama_kurir']) ?></p>
                </div>
                <div class="detail-row">
                    <p class="detail-title">Nomor Telepon Pengirim</p>
                    <p class="detail-value"><?= htmlspecialchars($order['nomor_telepon_kurir']) ?></p>
                </div>


                <!-- Payment Details -->
                <h2 class="card-title">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l2-2m0 0l2-2m-2 2h6m-6 0H5m6-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Informasi Pembayaran
                </h2>
                <div class="detail-row">
                    <p class="detail-title">Metode Pembayaran</p>
                    <p class="detail-value"><?= htmlspecialchars($order['payment_method']) ?></p>
                </div>
                <div class="detail-row">
                    <p class="detail-title">Tanggal Pembayaran</p>
                    <p class="detail-value"><?= htmlspecialchars($order['tanggal_bayar']) ?></p>
                </div>
                <div class="detail-row">
                    <p class="detail-title">Total Pembayaran</p>
                    <p class="detail-value">Rp<?= number_format($order['pesanan_total'], 0, ',', '.') ?></p>
                </div>

                <a href="../pelanggan/pesanan.php" class="button-back">Halaman Pesanan</a>

            </div>
        </div>
    </div>
    </div>
    </div>
    </div>





</body>

</html>