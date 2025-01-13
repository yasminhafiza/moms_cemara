<?php
// api/get_stats.php
include '../koneksi/koneksi.php';

$response = [];

// Total Penjualan Bulanan
$stmt = $conn->prepare("SELECT SUM(total) as total_sales FROM orders WHERE MONTH(created_at) = MONTH(CURRENT_DATE())");
$stmt->execute();
$response['total_sales'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_sales'] ?? 0;

// Total Produk Tersedia
$stmt = $conn->prepare("SELECT COUNT(*) as total_products FROM products");
$stmt->execute();
$response['total_products'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_products'] ?? 0;

// Total Pesanan Baru
$stmt = $conn->prepare("SELECT COUNT(*) as total_orders FROM orders WHERE DATE(created_at) = CURDATE()");
$stmt->execute();
$response['total_orders'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_orders'] ?? 0;

// Jumlah Pengguna Baru
$stmt = $conn->prepare("SELECT COUNT(*) as new_users FROM users WHERE DATE(created_at) = CURDATE()");
$stmt->execute();
$response['new_users'] = $stmt->fetch(PDO::FETCH_ASSOC)['new_users'] ?? 0;

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
