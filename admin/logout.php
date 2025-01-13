<?php
session_start();
session_unset();  // Remove all session variables
session_destroy();  // Destroy the session
echo "<script>alert('Logout Berhasil');</script>";
echo "<script>location='login.php';</script>";
exit();
?>
