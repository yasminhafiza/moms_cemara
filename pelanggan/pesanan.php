<?php
include '../koneksi/koneksi.php'; 

// Removed the redundant query variable $query and using $ambil directly
$ambil = $koneksi->query("SELECT * FROM pesanan JOIN pelanggan ON pesanan.id_user=pelanggan.id_user");

// Mengecek apakah query berhasil
if ($ambil->num_rows > 0) {
    $orders = $ambil->fetch_all(MYSQLI_ASSOC); // Mengambil semua data pesanan
} else {
    $orders = []; // Jika tidak ada data
}

session_start();
include '../koneksi/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>
        alert('Silakan login terlebih dahulu!');
        window.location.href = 'login.php';
    </script>";
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM pelanggan WHERE id_user = '$user_id'";
$result = $koneksi->query($sql);

// Jika data pengguna ditemukan
if ($result->num_rows > 0)
    $user = $result->fetch_assoc();
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
    <link rel="icon" href="../assets/foto/logo.jpg" type="image/png">
    <title>Mom's Cemara</title>
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body>

    <!-- Menu Section -->
    <div class="bg-[#B6EADD] min-h-screen flex flex-col lg:flex-row">
        <!-- Sidebar -->
        <div class="hidden lg:block w-full lg:w-1/4 bg-pink-200 p-6 lg:pt-36 flex flex-col justify-between">
            <div>
                <div class="flex flex-col items-center">
                    <img src="../assets/foto/avatar.png" alt="Profil" class="rounded-full mb-4 w-24 h-24 lg:w-36 lg:h-36" />
                    <p class="text-lg font-medium"><?php echo htmlspecialchars($user['nama']); ?></p>
                </div>

                <nav class="mt-6 lg:mt-2">
                    <ul class="flex flex-wrap lg:flex-col justify-center lg:justify-start">
                        <li class="mb-3 w-full sm:w-auto">
                            <a href="../pelanggan/profile_user.php" class="block p-2 rounded-md hover:bg-[#B6EADD] active:bg-[#B6EADD] w-full text-black text-center lg:text-left">Profil</a>
                        </li>
                    </ul>
                </nav>
            </div>

            <button
                onclick="window.location.href='../logout.php';"
                class="p-2 mt-4 text-pink-600 border border-pink-600 rounded-md hover:bg-pink-300 w-full">
                Keluar
              </button>        </div>
        <!-- Orders Table -->
        <div class="flex-1 p-6">
            <h1 class="text-3xl font-bold mb-6 text-center">Pesanan Saya</h1>
            <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
                <table class="min-w-full table-auto text-gray-800">
                <thead class="bg-pink-200">
    <tr>
        <th class="px-4 py-2 text-center">No</th>
        <th class="px-4 py-2 text-center">Tanggal Pesanan</th>
        <th class="px-4 py-2 text-center">Status</th>
        <th class="px-4 py-2 text-center">Resi</th>
        <th class="px-4 py-2 text-center">Total</th>
        <th class="px-4 py-2 text-center">Ekspedisi</th>
        <th class="px-4 py-2 text-center">Metode Pembayaran</th>
        <th class="px-4 py-2 text-center">Aksi</th>
    </tr>
</thead>
<tbody>
    <?php $no = 1; ?>
    <?php foreach ($orders as $order): ?>
        <tr class="border-b hover:bg-gray-50">
            <td class="px-4 py-2 text-center"><?= $no++ ?></td>
            <td class="px-4 py-2 text-center"><?= htmlspecialchars($order['tanggal_pesanan']) ?></td>
            <td class="px-4 py-2 text-center"><?= htmlspecialchars($order['status']) ?></td>
            <td class="px-4 py-2 text-center"><?= htmlspecialchars($order['resi']) ?></td>
            <td class="px-4 py-2 text-center"><?= number_format($order['total'], 0, ',', '.') ?></td>
            <td class="px-4 py-2 text-center"><?= htmlspecialchars($order['ekspedisi']) ?></td>
            <td class="px-4 py-2 text-center"><?= htmlspecialchars($order['payment_method']) ?></td>
            <td class="px-4 py-2 text-center">
                <a href="../pelanggan/detail_pesanan.php?id_pesanan=<?= htmlspecialchars($order['id_pesanan']) ?>" class="bg-pink-400 text-white px-4 py-1 rounded-lg hover:bg-pink-200 focus:outline-none focus:ring-2 focus:ring-pink-400">Detail</a>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>

                </table>
            </div>
        </div>

</body>

</html>
