<?php
include '../koneksi/koneksi.php'; // Sesuaikan path dengan lokasi file koneksi Anda
$id_pesanan = $_GET['id'];
$ambil = $koneksi->query("SELECT * FROM pesanan JOIN pelanggan ON pesanan.id_user=pelanggan.id_user WHERE pesanan.id_pesanan='$id_pesanan'");
$detail = $ambil->fetch_assoc();

if (isset($_POST['update_pesanan'])) {
    $resi = $_POST['resi'];
    $status = $_POST['status'];

    // Query untuk update data
    $query = "UPDATE pesanan SET resi = '$resi', status = '$status' WHERE id_pesanan = '$id_pesanan'";
    if (mysqli_query($koneksi, $query)) {
        echo "<div class='alert alert-success'>Data pesanan berhasil diperbarui!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($koneksi) . "</div>";
    }
}

if (isset($_POST['insert_pengiriman'])) {
    $nama_kurir = $_POST['nama_kurir'];
    $nomor_telepon_kurir = $_POST['nomor_telepon_kurir'];
    $waktu_pengiriman = $_POST['waktu_pengiriman'];
    $status_pengiriman = $_POST['status_pengiriman'];

    // Query untuk insert data pengiriman
    $query = "INSERT INTO pengiriman (id_pesanan, nama_kurir, nomor_telepon_kurir, waktu_pengiriman, status_pengiriman) 
              VALUES ('$id_pesanan', '$nama_kurir', '$nomor_telepon_kurir', '$waktu_pengiriman', '$status_pengiriman')";
    if (mysqli_query($koneksi, $query)) {
        echo "<div class='alert alert-success'>Data pengiriman berhasil disimpan!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($koneksi) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    <title>Detail Pesanan</title>
</head>
<body>
    <div class="container mt-4">
        <h3>Detail Pesanan</h3>
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow bg-white">
                    <div class="card-header">
                        <strong>Data Pelanggan</strong>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>Nama:</th>
                                <td><?php echo $detail['nama']; ?></td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td><?php echo $detail['email']; ?></td>
                            </tr>
                            <tr>
                                <th>Telepon:</th>
                                <td><?php echo $detail['phone_number']; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow bg-white">
                    <div class="card-header">
                        <strong>Data Pembelian</strong>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>No. Pembelian:</th>
                                <td><?php echo $detail['id_pesanan']; ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal:</th>
                                <td><?php echo $detail['tanggal_pesanan']; ?></td>
                            </tr>
                            <tr>
                                <th>Total:</th>
                                <td>Rp. <?php echo number_format($detail['total']); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card shadow bg-white">
                    <div class="card-header">
                        <strong>Data Pengiriman</strong>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>Alamat:</th>
                                <td><?php echo $detail['alamat_pengiriman']; ?></td>
                            </tr>
                            <tr>
                                <th>Ekspedisi:</th>
                                <td><?php echo $detail['ekspedisi']; ?></td>
                            </tr>
                            <tr>
                                <th>Catatan:</th>
                                <td><?php echo $detail['catatan']; ?></td>
                            </tr>
                            <tr>
                                <th>Biaya Pengiriman:</th>
                                <td>Rp. <?php echo number_format($detail['shipping']); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Update Status dan Resi -->
        <div class="card shadow bg-white mt-4">
            <div class="card-header">
                <h6>Update Status dan Resi Pesanan</h6>
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="form-group">
                        <label>Nomor Resi Pengiriman:</label>
                        <input type="text" name="resi" class="form-control" placeholder="Masukkan Resi" required>
                    </div>
                    <div class="form-group">
                        <label>Status:</label>
                        <select name="status" class="form-control" required>
                            <option selected disabled>Pilih Status</option>
                            <option value="Diproses">Diproses</option>
                            <option value="Dikirim">Dikirim</option>
                            <option value="Diterima">Diterima</option>
                        </select>
                    </div>
                    <button type="submit" name="update_pesanan" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>

        <!-- Form Input Data Pengiriman -->
<div class="card shadow bg-white mt-4">
    <div class="card-header">
        <h6>Input Data Pengiriman</h6>
    </div>
    <div class="card-body">
        <form method="post">
            <div class="form-group">
                <label>Nama Kurir:</label>
                <input type="text" name="nama_kurir" class="form-control" placeholder="Masukkan Nama Kurir" required>
            </div>
            <div class="form-group">
                <label>Nomor Telepon Kurir:</label>
                <input type="text" name="nomor_telepon_kurir" class="form-control" placeholder="Masukkan Nomor Telepon Kurir" required>
            </div>
            <div class="form-group">
                <label>Waktu Pengiriman:</label>
                <input type="datetime-local" name="waktu_pengiriman" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Status Pengiriman:</label>
                <select name="status_pengiriman" class="form-control" required>
                    <option selected disabled>Pilih Status</option>
                    <option value="Diproses">Diproses</option>
                    <option value="Dikirim">Dikirim</option>
                    <option value="Diterima">Diterima</option>
                </select>
            </div>
            <button type="submit" name="insert_pengiriman" class="btn btn-success">Simpan</button>
        </form>
    </div>
</div>
    </div>
</body>
</html>
