<?php
// Pastikan session dan koneksi database sudah ada dari file utama
$navbarID = $_SESSION['id'];
$queryNavbar = mysqli_query($config, "SELECT * FROM user WHERE id = '$navbarID'");
$dataNavbar = mysqli_fetch_assoc($queryNavbar);

?>
<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
  <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
    <i class="fe fe-x"><span class="sr-only"></span></i>
  </a>
  <nav class="vertnav navbar navbar-light">
    <!-- nav bar -->
    <div class="w-100 mb-4 d-flex">
      <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="./index.html">
        <img src="" id="logo" style="width: 50px" class="navbar-brand-img brand-sm">
      </a>
    </div>
    <ul class="navbar-nav flex-fill w-100 ">
      <li class="nav-item w-100">
        <a class="nav-link" href="?page=dashboard/dashboard">
          <i class="fe fe-home fe-16"></i>
          <span class="ml-3 item-text">Dashboard</span>
        </a>
      </li>
    </ul>
    <p class="text-muted nav-heading mt-4 mb-1">
      <span>Master Data</span>
    </p>
    <ul class="navbar-nav flex-fill w-100 mb-2">
      <li class="nav-item w-100">
        <a class="nav-link" href="?page=user/user">
          <i class="fe fe-user fe-16"></i>
          <span class="ml-3 item-text">Menu User</span>
        </a>
      </li>
      <li class="nav-item w-100">
        <a class="nav-link" href="?page=level/level">
          <i class="fe fe-users fe-16"></i>
          <span class="ml-3 item-text">Menu Level</span>
        </a>
      </li>
      <li class="nav-item w-100">
        <a class="nav-link" href="?page=customer/customer">
          <i class="fe fe-user-plus fe-16"></i>
          <span class="ml-3 item-text">Data Pelanggan</span>
        </a>
      </li>
        <li class="nav-item w-100">
        <a class="nav-link" href="?page=unit/unit">
          <i class="fe fe-codepen fe-16"></i>
          <span class="ml-3 item-text">Units</span>
        </a>
      </li>
      <li class="nav-item w-100">
        <a class="nav-link" href="?page=produk/produk">
          <i class="fe fe-package fe-16"></i>
          <span class="ml-3 item-text">Manajemen Produk</span>
        </a>
      </li>
      <li class="nav-item w-100">
        <a class="nav-link" href="?page=kategori-produk/category">
          <i class="fe fe-edit fe-16"></i>
          <span class="ml-3 item-text">Kategori Produk</span>
        </a>
      </li>
      <li class="nav-item w-100">
        <a class="nav-link" href="?page=banner/slider">
          <i class="fe fe-airplay fe-16"></i>
          <span class="ml-3 item-text">Manajemen banner</span>
        </a>
      </li>
       <li class="nav-item w-100">
        <a class="nav-link" href="?page=karyawan/karyawan">
          <i class="fe fe-user-check fe-16"></i>
          <span class="ml-3 item-text">Manajemen Karyawan</span>
        </a>
      </li>
      <li class="nav-item w-100">
        <a class="nav-link" href="?page=stok/stok">
          <i class="fe fe-tag fe-16"></i>
          <span class="ml-3 item-text">Manajemen Stok Barang</span>
        </a>
      </li>
      <li class="nav-item w-100">
        <a class="nav-link" href="?page=pemberian-barang/daftar-pembelian">
          <i class="fe fe-shopping-bag fe-16"></i>
          <span class="ml-3 item-text">Purchases</span>
        </a>
      </li>
      <li class="nav-item w-100">
        <a class="nav-link" href="?page=supplier/supplier">
          <i class="fe fe-truck fe-16"></i>
          <span class="ml-3 item-text">Data Supplier</span>
        </a>
      </li>
            <li class="nav-item w-100">
        <a class="nav-link" href="?page=menu-produk/menu-list">
          <i class="fe fe-monitor fe-16"></i>
          <span class="ml-3 item-text">Mobile POS</span>
        </a>
      </li>
      <li class="nav-item w-100">
        <a class="nav-link" href="?page=POS/pos">
          <i class="fe fe-user-plus fe-16"></i>
          <span class="ml-3 item-text">Transaksi</span>
        </a>
      </li>
      <li class="nav-item w-100">
        <a class="nav-link" href="?page=piutang-dagang/piutang-dagang">
          <i class="fe fe-alert-circle fe-16"></i>
          <span class="ml-3 item-text">Piutang Dagang</span>
        </a>
      </li>
      <li class="nav-item w-100">
        <a class="nav-link" href="?page=report/report">
          <i class="fe fe-file-text fe-16"></i>
          <span class="ml-3 item-text">Laporan Keuangan</span>
        </a>
      </li>
       <li class="nav-item w-100">
        <a class="nav-link" href="?page=pengaturan/pengaturan">
          <i class="fe fe-settings fe-16"></i>
          <span class="ml-3 item-text">Pengaturan</span>
        </a>
      </li>
    
    </ul>
    <p class="text-muted nav-heading mt-4 mb-1">
      <span>Tindakan</span>
    </p>
    <ul class="navbar-nav flex-fill w-100 mb-2">
      </li>
       <li class="nav-item w-100">
        <a class="nav-link" href="?page=keluar">
          <i class="fe fe-log-out fe-16"></i>
          <span class="ml-3 item-text">Logout</span>
        </a>
      </li>
    </ul>
  </nav>
</aside>