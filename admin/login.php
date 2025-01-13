<?php
session_start();
include '../koneksi/koneksi.php';

if(isset($_POST['login'])) {
    $user = $_POST['user'];
    $pass = sha1($_POST['pass']);

    $stmt = $koneksi->prepare("SELECT * FROM admin WHERE username=? AND password=?");
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows === 1) {
        $_SESSION['admin'] = $result->fetch_assoc();
        echo "<script>alert('Login Berhasil');</script>";
        echo "<script>location='index.php';</script>";
    } else {
        echo "<script>alert('Login Gagal');</script>";
        echo "<script>location='login.php';</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Mom's Cemara Login</title>

    <!-- Custom fonts for this template-->
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon">
    <!-- Jika menggunakan PNG, sesuaikan dengan kode ini -->
    <link rel="icon" href="../assets/foto/logo.jpg" type="image/png"> 
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            height: 100vh;
            background-color: #e1f5fe; /* Light blue background */
        }

        .container {
            display: flex;
            height: 100%;
            width: 100%;
        }

        .bg-left {
            background-color: #B6EADD; /* Pink color */
            height: 100%;
            width: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            border-top-left-radius: 20px;
            border-bottom-left-radius: 20px;
        }

        .bg-right {
            background-color: #B6EADD; /* Tosca Green color */
            height: 100%;
            width: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
        }

        .card {
            width: 100%;
            max-width: 380px;
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background-color:rgb(168, 236, 219);
        }

        .text-center img {
            width: 300px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control-user {
            border-radius: 15px;
            padding: 12px;
            font-size: 16px;
            background-color: #f1f1f1;
            border: 1px solid #ddd;
            width: 100%;
        }

        .form-control-user:focus {
            border-color:rgb(107, 218, 195);
            box-shadow: 0 0 8px rgba(140, 240, 220, 0.5);
        }

        .btn-user {
            background-color: #ff80bf;
            color: white;
            padding: 14px;
            font-size: 16px;
            border-radius: 15px;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .btn-user:hover {
            background-color: #ff3366; /* Darker pink */
        }

        .card-body {
            padding: 30px;
        }

        .text-center h1 {
            font-size: 2rem;
            color: black;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .form-group input {
            transition: transform 0.3s ease;
        }

        .form-group input:focus {
            transform: scale(1.02);
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Left side (Pink) with Logo -->
        <div class="bg-left">
            <div class="text-center">
                <img src="../assets/foto/logo.png" alt="Zafer Parfume Logo">
            </div>
        </div>

        <!-- Right side (Tosca Green) with Login Form -->
        <div class="bg-right">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="p-5">
                        <div class="text-center">
                            <h1>Zafer Parfume</h1>
                        </div>
                        <form method="post" class="user">
                            <div class="form-group">
                                <input type="text" name="user" class="form-control form-control-user" placeholder="Enter Your Username" required>
                            </div>
                            <div class="form-group">
                                <input type="password" name="pass" class="form-control form-control-user" placeholder="Enter Your Password" required>
                            </div>
                            <div class="form-group">
                                <label>
                                    <input type="checkbox" name="remember" style="margin-right: 10px;">
                                    Remember me
                                </label>
                            </div>
                            <button name="login" class="btn btn-user">
                                Login
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../assets/js/sb-admin-2.min.js"></script>
</body>

</html>
