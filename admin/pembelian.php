<?php
include '../koneksi/koneksi.php'; // Menyertakan file koneksi
$ambil = $koneksi->query("SELECT * FROM pesanan JOIN pelanggan ON pesanan.id_user=pelanggan.id_user");
$pesanan = array(); // Inisialisasi variabel pesanan sebagai array kosong

while ($pecah = $ambil->fetch_assoc()) {
    $pesanan[] = $pecah; // Mengisi array pesanan dengan hasil dari query
}
?>

<main class="container mt-4">
    <div class="shadow p-3 mb-3 bg-white rounded">
        <h5><b>Pembelian</b></h5>
    </div>

    <div class="card shadow bg-white">
        <div class="card-body">
            <table class="table table-bordered table-hover table-striped" id="tables">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th width="150">Tanggal</th>
                        <th width="150">Total</th>
                        <th width="2000">Status</th>
                        <th>Resi</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pesanan as $key => $value): ?>
                    <tr>
                        <td width="50"><?php echo $key+1; ?></td>
                        <td><?php echo $value['nama']; ?></td>
                        <td><?php echo $value['email']; ?></td>
                        <td width="150"><?php echo date("D, d M Y", strtotime($value['tanggal_pesanan'])); ?></td>
                        <td width="150">Rp <?php echo number_format($value['total']); ?></td>
                        <td><?php echo $value['status']; ?></td>
                        <td><?php echo $value['payment_method']; ?></td>
                        <td class="text-center" width="400">
                            <!-- Trigger Modal -->
                            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#detailModal<?php echo $value['id_pesanan']; ?>">Detail</button>

                            <?php if($value['status'] !== 'pending'): ?>
                                <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#paymentModal<?php echo $value['id_pesanan']; ?>">Lihat Pembayaran</button>
                                <a href="index.php?halaman=hapus_pembelian&id=<?php echo $value['id_pesanan']; ?>" class="btn btn-sm btn-danger mt-2">Hapus</a>
                            <?php else: ?>
                                <a href="index.php?halaman=hapus_pembelian&id=<?php echo $value['id_pesanan']; ?>" class="btn btn-sm btn-danger">Hapus</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Modal start -->
<?php foreach ($pesanan as $value): ?>
<div class="modal fade" id="detailModal<?php echo $value['id_pesanan']; ?>" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel<?php echo $value['id_pesanan']; ?>" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel<?php echo $value['id_pesanan']; ?>">Detail Pesanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Detail Content -->
                <?php
                    $id_pesanan = $value['id_pesanan'];
                    $ambil = $koneksi->query("
                        SELECT pesanan.*, pembayaran.*
                        FROM pesanan
                        LEFT JOIN pembayaran ON pesanan.id_pesanan = pembayaran.id_pesanan
                        WHERE pesanan.id_pesanan = '$id_pesanan'
                    ");
                    $detail = $ambil->fetch_assoc();
                ?>
                <div class="table-responsive">
                    <table class="table">
                        <!-- Pesanan Details -->
                        <tr>
                            <th>No. Pesanan:</th>
                            <td><?php echo $detail['id_pesanan']; ?></td>
                        </tr>
                        <tr>
                            <th>ID User:</th>
                            <td><?php echo $detail['id_user']; ?></td>
                        </tr>
                        <tr>
                            <th>Payment Method:</th>
                            <td><?php echo $detail['payment_method']; ?></td>
                        </tr>
                        <tr>
                            <th>Alamat Pengiriman:</th>
                            <td><?php echo $detail['alamat_pengiriman']; ?></td>
                        </tr>
                        <tr>
                            <th>Catatan:</th>
                            <td><?php echo $detail['catatan']; ?></td>
                        </tr>
                        <tr>
                            <th>Tanggal Pesanan:</th>
                            <td><?php echo $detail['tanggal_pesanan']; ?></td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td><?php echo $detail['status']; ?></td>
                        </tr>
                        <tr>
                            <th>Total:</th>
                            <td>Rp. <?php echo number_format($detail['total']); ?></td>
                        </tr>
                        <tr>
                            <th>Ekspedisi:</th>
                            <td><?php echo $detail['ekspedisi']; ?></td>
                        </tr>
                        <tr>
                            <th>Shipping:</th>
                            <td>Rp. <?php echo number_format($detail['shipping']); ?></td>
                        </tr>

                        <!-- Pembayaran Details -->
                        <tr>
                            <th>ID Pembayaran:</th>
                            <td><?php echo $detail['id_pembayaran'] ?: 'Belum ada pembayaran'; ?></td>
                        </tr>
                        <tr>
                            <th>Metode Pembayaran:</th>
                            <td><?php echo $detail['metode_pembayaran'] ?: '-'; ?></td>
                        </tr>
                        <tr>
                            <th>Total Bayar:</th>
                            <td>Rp. <?php echo $detail['total_bayar'] ? number_format($detail['total_bayar']) : '-'; ?></td>
                        </tr>
                        <tr>
                            <th>Tanggal Bayar:</th>
                            <td><?php echo $detail['tanggal_bayar'] ?: '-'; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
<!-- Modal end -->


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
