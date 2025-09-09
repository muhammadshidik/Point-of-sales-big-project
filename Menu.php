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
          // Memeriksa apakah file PHP dengan nama yang sesuai dengan parameter 'page'
          // ada di dalam folder 'content'.
          if (file_exists("admin/content/" . $_GET['page'] . ".php")) {
            // Jika file ada, include file tersebut. Ini berfungsi untuk memuat konten dinamis
            // berdasarkan halaman yang diminta.
            include('admin/content/' . $_GET['page'] . ".php");
          } else {
            // Jika file tidak ditemukan, include halaman 'notfound.php'.
            include "notfound.php";
          }
        } else {
          // Jika parameter 'page' tidak ada di URL, secara default include halaman 'home.php'.
          include 'admin/content/dashboard.php';
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