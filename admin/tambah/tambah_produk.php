<?php
include '../koneksi/koneksi.php'; // Menyertakan file koneksi

$kategori = array();
$ambil = $koneksi->query("SELECT * FROM kategori"); // Query untuk mengambil kategori

if ($ambil) {
    while ($pecah = $ambil->fetch_assoc()) {
        $kategori[] = $pecah;
    }
} else {
    // Jika query gagal, tampilkan pesan kesalahan
    echo "Error: " . $koneksi->error;
}
?>

<main class="container mt-4">
    <div class="shadow p-3 mb-3 bg-white rounded">
        <h5><b>Tambah Produk</b></h5>
    </div>

    <form method="post" enctype="multipart/form-data">
        <div class="card shadow bg-white">
            <div class="card-body">
                <div class="form-group row mb-3">
                    <label class="col-sm-3 col-form-label">Nama Kategori :</label>
                    <div class="col-sm-9">
                        <select name="id_kategori" class="form-control" required>
                            <option selected disabled>Pilih Nama Kategori</option>
                            <?php foreach ($kategori as $key => $value): ?>
                            <option value="<?php echo $value['id_kategori']; ?>">
                                <?php echo $value['nama_kategori']; ?>
                            </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label class="col-sm-3 col-form-label">Nama Produk :</label>
                    <div class="col-sm-9">
                        <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama Produk" required>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label class="col-sm-3 col-form-label">Harga Produk :</label>
                    <div class="col-sm-9">
                        <input type="number" name="harga" class="form-control" placeholder="Masukkan Harga" required>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label class="col-sm-3 col-form-label">Foto Produk :</label>
                    <div class="col-sm-9">
                        <div class="input-foto">
                            <input type="file" name="foto[]" class="form-control" multiple required>
                        </div>
                        <span class="btn btn-sm btn-success mt-4 btn-tambah">
                            <i class="fas fa-plus"></i>
                        </span>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label class="col-sm-3 col-form-label">Deskripsi :</label>
                    <div class="col-sm-9">
                        <input type="text" name="deskripsi" class="form-control" placeholder="Deskripsi Produk" required>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label class="col-sm-3 col-form-label">Stok Produk :</label>
                    <div class="col-sm-9">
                        <input type="number" name="stok" class="form-control" placeholder="Stok Produk" required>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-11">
                        <button name="simpan" class="btn btn-sm btn-success">Simpan</button>
                    </div>
                    <div class="col-md-1 text-right">
                        <a href="index.php?halaman=produk" class="btn btn-sm btn-danger">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</main>

<?php 
if (isset($_POST['simpan'])) {
    $id_kategori = $_POST['id_kategori'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $berat = $_POST['berat'];
    $deskripsi = $_POST['deskripsi'];
    $stok = $_POST['stok'];

    // Upload foto produk pertama
    $nama_foto = $_FILES['foto']['name'];
    $lokasi_foto = $_FILES['foto']['tmp_name'];

    // Menyimpan gambar pertama
    $upload_folder = "../assets/foto_produk/";

    // Simpan gambar pertama
    if (!empty($nama_foto[0])) {
        move_uploaded_file($lokasi_foto[0], $upload_folder . $nama_foto[0]);
    }

    // Menyimpan data produk ke tabel produk
    $koneksi->query("INSERT INTO produk (id_kategori, nama_produk, harga, gambar, deskripsi, stok) 
    VALUES ('$id_kategori', '$nama', '$harga', '$nama_foto[0]', '$deskripsi', '$stok')");


    // Ambil ID produk yang baru saja dimasukkan
    $id_baru = $koneksi->insert_id;

    // Menyimpan foto produk tambahan
    foreach ($nama_foto as $key => $tiap_nama) {
        $tiap_lokasi = $lokasi_foto[$key];
        if (!empty($tiap_nama)) {
            move_uploaded_file($tiap_lokasi, $upload_folder . $tiap_nama);
            $koneksi->query("INSERT INTO produk_foto (id_produk, nama_produk_foto) VALUES ('$id_baru', '$tiap_nama')");
        }
    }

    // Menampilkan pesan sukses
    echo "<script>alert('Data berhasil disimpan');</script>";
    echo "<script>location='index.php?halaman=produk';</script>";
}
?>
