<?php
// Include koneksi database
include '../koneksi/koneksi.php'; // Sesuaikan path file koneksi
?>

<main class="container mt-4">
    <div class="shadow p-3 mb-3 bg-white rounded">
        <h5><b>Tambah Kategori</b></h5>
    </div>

    <form method="post">
        <div class="card shadow bg-white">
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nama Kategori</label>
                    <div class="col-sm-9">
                        <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama Kategori" required>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="row">
                    <div class="col-md-11">
                        <button name="simpan" class="btn btn-sm btn-success">Simpan</button>
                    </div>
                    <div class="col-md-1 text-right">
                        <a href="index.php?halaman=kategori" class="btn btn-sm btn-danger">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php 
    if (isset($_POST['simpan'])) {
        // Ambil input dari form
        $nama = $_POST['nama'];

        // Jalankan query untuk menambahkan data
        if ($koneksi->query("INSERT INTO kategori (nama_kategori) VALUES ('$nama')")) {
            echo "<script>alert('Data berhasil disimpan');</script>";
            echo "<script>location='index.php?halaman=kategori';</script>";
        } else {
            echo "<script>alert('Data gagal disimpan: " . $koneksi->error . "');</script>";
        }
    }
    ?>
</main>
