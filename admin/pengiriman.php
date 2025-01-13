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
        <h5><b>Kontrol Pengiriman</b></h5>
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
                            <td width="50"><?php echo $key + 1; ?></td>
                            <td><?php echo $value['nama']; ?></td>
                            <td><?php echo $value['email']; ?></td>
                            <td width="150"><?php echo date("D, d M Y", strtotime($value['tanggal_pesanan'])); ?></td>
                            <td width="150">Rp <?php echo number_format($value['total']); ?></td>
                            <td><?php echo $value['status']; ?></td>
                            <td><?php echo $value['resi']; ?></td>
                            <td class="text-center" width="400">
                                <!-- Trigger Modal -->
                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#detailModal<?php echo $value['id_pesanan']; ?>">Detail</button>

                                    <a href="index.php?halaman=detail_pengiriman&id=<?php echo $value['id_pesanan']; ?>" class="btn btn-sm btn-success">Pengiriman</a>
                                    <a href="index.php?halaman=hapus_pembelian&id=<?php echo $value['id_pesanan']; ?>" class="btn btn-sm btn-danger mt-2">Hapus</a>

                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</main>




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>