<?php
include '../koneksi/koneksi.php'; // Pastikan file koneksi disertakan

// Ambil data kategori dari database
$kategori = array();
$ambil = $koneksi->query("SELECT * FROM kategori");
while ($pecah = $ambil->fetch_assoc()) {
    $kategori[] = $pecah;
}
?>

<main class="container mt-4">
    <div class="shadow p-3 mb-3 bg-white rounded">
        <h5><b>Kategori</b></h5>
    </div>

    <a href="index.php?halaman=tambah_kategori" class="btn btn-sm btn-success">Tambah</a>

    <div class="card shadow bg-white mt-4">
        <div class="card-body">
            <table class="table table-bordered table-hover table-striped" id="tables">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($kategori as $key => $value): ?>
                        <tr>
                            <td width="50"><?php echo $key + 1; ?></td>
                            <td><?php echo $value['nama_kategori']; ?></td>
                            <td class="text-center" width="150">
                            <a href="index.php?halaman=edit_kategori&id=<?php echo $value['id_kategori']; ?>" class="btn btn-sm btn-primary">Edit</a>

                                <button class="btn btn-sm btn-danger" onclick="hapusKategori(<?php echo $value['id_kategori']; ?>)">Hapus</button>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Sertakan SweetAlert 2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Fungsi untuk menampilkan SweetAlert konfirmasi hapus
    function hapusKategori(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Kategori ini akan dihapus secara permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika pengguna mengonfirmasi, arahkan untuk menghapus kategori
                window.location.href = 'index.php?halaman=hapus_kategori&id=' + id;
            }
        });
    }
</script>
