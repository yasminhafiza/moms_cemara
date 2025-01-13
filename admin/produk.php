<?php
// Include the database connection file
include('../koneksi/koneksi.php'); // Adjust the path to your actual 'koneksi.php' file

// Fetch the product data
$produk = array();
$ambil = $koneksi->query("SELECT p.id_produk, p.id_kategori, p.nama_produk, p.deskripsi, p.harga, p.stok, p.gambar, k.nama_kategori
                          FROM produk p
                          JOIN kategori k ON p.id_kategori = k.id_kategori");

while ($pecah = $ambil->fetch_assoc()) {
    $produk[] = $pecah;
}
?>

<main class="container mt-4">
    <div class="shadow p-3 mb-3 bg-white rounded">
        <h5><b>Produk</b></h5>
    </div>

    <a href="index.php?halaman=tambah_produk" class="btn btn-sm btn-success">Tambah</a>

    <div class="card shadow bg-white mt-4">
        <div class="card-body">
            <table class="table table-bordered table-hover table-striped" id="tables">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kategori</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Foto</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produk as $key => $value): ?>
                    <tr>
                        <td width="50"><?php echo $key+1; ?></td>
                        <td><?php echo $value['nama_kategori']; ?></td>
                        <td><?php echo $value['nama_produk']; ?></td>
                        <td><?php echo $value['deskripsi']; ?></td>
                        <td>Rp<?php echo number_format($value['harga'], 2, ',', '.'); ?></td>
                        <td><?php echo number_format($value['stok']); ?></td>
                        <td>
                            <img width="150" src="../assets/foto_produk/<?php echo $value['gambar']; ?>" alt="Foto Produk">
                        </td>
                        <td class="text-center" width="150">
                        <a href="index.php?halaman=hapus_produk&id=<?php echo $value['id_produk']; ?>" class="btn btn-sm btn-danger">Hapus</a>
                        <a href="index.php?halaman=edit_produk&id=<?php echo $value['id_produk']; ?>" class="btn btn-sm btn-info">Edit</a>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</main>


