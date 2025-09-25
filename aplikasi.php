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

<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>Dashboard - Analytics | Sneat - Bootstrap 5 HTML Admin Template - Pro</title>

  <meta name="description" content="" />
  <?php include 'admin/include/css.php' ?>
</head>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Menu -->
      <?php include 'admin/include/sidebar.php' ?>
      <!-- / Menu -->
      <!-- Layout container -->
      <div class="layout-page">
        <!-- Navbar -->
        <?php include 'admin/include/navbar.php' ?>
        <!-- / Navbar -->
        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->
          <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
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
                </div>
             
            <!-- / Content -->
            <!-- Footer -->
            <?php include 'admin/include/footer.php' ?>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->
    <?php include 'admin/include/js.php' ?>
</body>

</html>