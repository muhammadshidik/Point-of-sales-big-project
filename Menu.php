<?php
// Memulai session agar bisa menggunakan $_SESSION
session_start();

// Membuat session ID baru dan menghapus session ID lama untuk meningkatkan keamanan (mencegah session fixation)
session_regenerate_id();

// Mengaktifkan output buffering (penyimpanan output sementara sebelum dikirim ke browser)
ob_start();

// Membersihkan output buffer, menghapus semua isi buffer (jika ada output sebelumnya)
ob_clean();

// Memanggil file koneksi ke database
require_once 'admin/controller/koneksi.php';

// Memanggil file yang berisi fungsi-fungsi tambahan


// Mengecek apakah session 'id' kosong (belum login atau session habis)
if (empty($_SESSION['id'])) {
  // Jika belum login, arahkan pengguna ke halaman logout (biasanya akan diarahkan ke login page lagi)
  header('Location: ?page=keluar');
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="favicon.ico">
  <title>Beranda</title>
  <?php include 'admin/inc/css.php' ?>
</head>

<body class="vertical  dark  ">
  <div class="wrapper">
    <?php include 'admin/inc/navbar.php' ?>
    <?php include 'admin/inc/sidebar.php' ?>
    <main role="main" class="main-content">

      <!-- start konten utama  -->
      <?php
      // Memeriksa apakah parameter 'page' ada di URL.
      if (isset($_GET['page'])) {
        // Bersihkan input supaya aman
        $page = str_replace(['..', './', '\\'], '', $_GET['page']);

        if (file_exists("admin/content/" . $page . ".php")) {
          include('admin/content/' . $page . ".php");
        } else {
          include "admin/content/notfound/notfound.php";
        }
      } else {
        include 'admin/content/dashboard/dashboard.php';
      }

      ?>
      <!-- end konten utama -->
      <!-- .container-fluid -->
      <?php include 'admin/inc/container.php' ?>
    </main>
    <!-- main -->
  </div>
  <!-- .wrapper -->
  <?php include 'admin/inc/js.php' ?>
</body>

</html>