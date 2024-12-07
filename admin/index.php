<?php
session_start();
include '../koneksi/koneksi.php';


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="../assets/css/admin.css">

  <!-- jQuery (optional, only if needed for other scripts) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    /* Menambahkan jarak pada dropdown */
    
  </style>
</head>

<body>
  <!-- Navbar Structure -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      
      <!-- Logo dan Judul di Kiri -->
      <a class="navbar-brand" href="#">
        <img src="../assets/foto/logo.jpg" alt="Logo" class="logo ">
        <span class="judul">Mom's Cemara</span>
      </a>

      <!-- Menu Navbar -->
      <div>
        <ul class="navbar-nav">
          <!-- Dashboard -->
          <li class="nav-item">
            <a class="nav-link" href="index.php">Dashboard</a>
          </li>

          <!-- Dropdown Master -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="masterDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Master
            </a>
            <ul class="dropdown-menu" aria-labelledby="masterDropdown">
              <li><a class="dropdown-item" href="index.php?halaman=kategori">Kategori</a></li>
              <li><a class="dropdown-item" href="master/jenisdoktrin">Laporan</a></li>
              <li><a class="dropdown-item" href="index.php?halaman=produk">Produk</a></li>
              <li><a class="dropdown-item" href="master/unitorganisasi">Pembelian</a></li>
              <li><a class="dropdown-item" href="master/jenisdoktrin">Pelanggan</a></li>
            </ul>
          </li>

          <!-- Admin Profile -->
          <li class="nav-item dropdown">
            <a class="nav-link  d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="../assets/foto/profile.png" alt="Profile" class="profile-img me-2">
              <span class="fw-bold" style="margin-left: 10px;">Administrator</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
              <li>
                <a class="dropdown-item" onclick="window.location.href='login'">
                  <i class="fas fa-sign-out-alt me-2"></i>Logout
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>


 

   <!-- Begin Page Content -->
   <div class="container-fluid">
                <!-- Page Heading -->
                <?php
                if(isset($_GET['halaman'])) {
                    if($_GET['halaman']=="kategori") {
                        include 'kategori.php';
                    } elseif($_GET['halaman']=="tambah_kategori") {
                        include 'tambah/tambah_kategori.php';
                    } elseif($_GET['halaman']=="edit_kategori") {
                        include 'edit/edit_kategori.php';
                    } elseif($_GET['halaman']=="hapus_kategori") {
                        include 'hapus/hapus_kategori.php';
                    } elseif($_GET['halaman']=="produk") {
                        include 'produk.php';
                    } elseif($_GET['halaman']=="tambah_produk") {
                        include 'tambah/tambah_produk.php';
                    } elseif($_GET['halaman']=="detail_produk") {
                        include 'detail/detail_produk.php';
                    } elseif($_GET['halaman']=="hapus_foto") {
                        include 'hapus/hapus_foto.php';
                    } elseif($_GET['halaman']=="edit_produk") {
                        include 'edit/edit_produk.php';
                    } elseif($_GET['halaman']=="hapus_produk") {
                        include 'hapus/hapus_produk.php';
                    } elseif($_GET['halaman']=="pembelian") {
                        include 'pembelian.php';
                    } elseif($_GET['halaman']=="detail_pembelian") {
                        include 'detail/detail_pembelian.php';
                    } elseif($_GET['halaman']=="hapus_pembelian") {
                        include 'hapus/hapus_pembelian.php';
                    }  elseif($_GET['halaman']=="pembayaran") {
                        include 'pembayaran.php';
                    }elseif($_GET['halaman']=="laporan") {
                        include 'laporan.php';
                    } elseif($_GET['halaman']=="logout") {
                        include 'logout.php';
                    } elseif($_GET['halaman']=="pelanggan") {
                        include 'pelanggan.php';
                    } elseif($_GET['halaman']=="hapus_pelanggan") {
                        include 'hapus/hapus_pelanggan.php';
                    }
                } else {
                    include 'dashboard.php';
                }
                ?>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->

       
    </div>
    <!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- jQuery Easing -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- Custom scripts (replace with hosted versions if necessary) -->
<script src="../assets/js/sb-admin-2.min.js"></script>
<script src="../assets/js/demo/datatables-demo.js"></script>


<script>
    $(document).ready(function(){
        $(".btn-tambah").on("click", function(){
            $(".input-foto").append("<input type='file' name='foto[]' class='form-control'>");
        })
    })
</script>
</body>
</html>

