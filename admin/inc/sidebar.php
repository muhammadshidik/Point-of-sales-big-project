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
        <img src="admin/content/uploads/Foto/logo-dapur-mama-niar.png" id="logo" style="width: 50px" class="navbar-brand-img brand-sm">
      </a>
    </div>
    <ul class="navbar-nav flex-fill w-100 ">
      <li class="nav-item w-100">
        <a class="nav-link" href="?page=dashboard">
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
        <a class="nav-link" href="?page=user">
          <i class="fe fe-user fe-16"></i>
          <span class="ml-3 item-text">Menu User</span>
        </a>
      </li>
      <li class="nav-item w-100">
        <a class="nav-link" href="?page=level">
          <i class="fe fe-users fe-16"></i>
          <span class="ml-3 item-text">Menu Level</span>
        </a>
      </li>
      <li class="nav-item w-100">
        <a class="nav-link" href="?page=customer">
          <i class="fe fe-user-plus fe-16"></i>
          <span class="ml-3 item-text">Data Pelanggan</span>
        </a>
      </li>
      <li class="nav-item w-100">
        <a class="nav-link" href="?page=produk">
          <i class="fe fe-package fe-16"></i>
          <span class="ml-3 item-text">Manajemen Produk</span>
        </a>
      </li>
      <li class="nav-item w-100">
        <a class="nav-link" href="?page=category">
          <i class="fe fe-edit fe-16"></i>
          <span class="ml-3 item-text">Kategori Produk</span>
        </a>
      </li>
      <li class="nav-item w-100">
        <a class="nav-link" href="?page=slider">
          <i class="fe fe-airplay fe-16"></i>
          <span class="ml-3 item-text">Managemen banner</span>
        </a>
      </li>
      <li class="nav-item w-100">
        <a class="nav-link" href="?page=stok">
          <i class="fe fe-book-open fe-16"></i>
          <span class="ml-3 item-text">Manajemen Stok Barang</span>
        </a>
      </li>
         <li class="nav-item w-100">
        <a class="nav-link" href="?page=daftar-pembelian">
          <i class="fe fe-shopping-bag fe-16"></i>
          <span class="ml-3 item-text">Daftar Pembelian</span>
        </a>
      </li>
    </ul>
    <p class="text-muted nav-heading mt-4 mb-1">
      <span>Kasir</span>
    </p>
    <ul class="navbar-nav flex-fill w-100 mb-2">
      </li>
      <li class="nav-item w-100">
        <a class="nav-link" href="?page=pos">
          <i class="fe fe-user-plus fe-16"></i>
          <span class="ml-3 item-text">Transaksi</span>
        </a>
      </li>
      <li class="nav-item dropdown">
        <a href="#contact" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
          <i class="fe fe-book fe-16"></i>
          <span class="ml-3 item-text">Contacts</span>
        </a>
        <ul class="collapse list-unstyled pl-4 w-100" id="contact">
          <a class="nav-link pl-3" href="./contacts-list.html"><span class="ml-1">Contact List</span></a>
          <a class="nav-link pl-3" href="./contacts-grid.html"><span class="ml-1">Contact Grid</span></a>
          <a class="nav-link pl-3" href="./contacts-new.html"><span class="ml-1">New Contact</span></a>
        </ul>
      </li>
    </ul>
    <p class="text-muted nav-heading mt-4 mb-1">
      <span>Extra</span>
    </p>
    <ul class="navbar-nav flex-fill w-100 mb-2">
      <li class="nav-item dropdown">
        <a href="#pages" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
          <i class="fe fe-file fe-16"></i>
          <span class="ml-3 item-text">Pages</span>
        </a>
        <ul class="collapse list-unstyled pl-4 w-100 w-100" id="pages">
          <li class="nav-item">
            <a class="nav-link pl-3" href="./page-orders.html">
              <span class="ml-1 item-text">Orders</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link pl-3" href="./page-timeline.html">
              <span class="ml-1 item-text">Timeline</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link pl-3" href="./page-invoice.html">
              <span class="ml-1 item-text">Invoice</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link pl-3" href="./page-404.html">
              <span class="ml-1 item-text">Page 404</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link pl-3" href="./page-500.html">
              <span class="ml-1 item-text">Page 500</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link pl-3" href="./page-blank.html">
              <span class="ml-1 item-text">Blank</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item dropdown">
        <a href="#auth" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
          <i class="fe fe-shield fe-16"></i>
          <span class="ml-3 item-text">Authentication</span>
        </a>
        <ul class="collapse list-unstyled pl-4 w-100" id="auth">
          <a class="nav-link pl-3" href="./auth-login.html"><span class="ml-1">Login 1</span></a>
          <a class="nav-link pl-3" href="./auth-login-half.html"><span class="ml-1">Login 2</span></a>
          <a class="nav-link pl-3" href="./auth-register.html"><span class="ml-1">Register</span></a>
          <a class="nav-link pl-3" href="./auth-resetpw.html"><span class="ml-1">Reset Password</span></a>
          <a class="nav-link pl-3" href="./auth-confirm.html"><span class="ml-1">Confirm Password</span></a>
        </ul>
      </li>
      <li class="nav-item dropdown">
        <a href="#layouts" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
          <i class="fe fe-layout fe-16"></i>
          <span class="ml-3 item-text">Layout</span>
        </a>
        <ul class="collapse list-unstyled pl-4 w-100" id="layouts">
          <li class="nav-item">
            <a class="nav-link pl-3" href="./index.html"><span class="ml-1 item-text">Default</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link pl-3" href="./index-horizontal.html"><span class="ml-1 item-text">Top Navigation</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link pl-3" href="./index-boxed.html"><span class="ml-1 item-text">Boxed</span></a>
          </li>
        </ul>
      </li>
    </ul>
    <p class="text-muted nav-heading mt-4 mb-1">
      <span>Documentation</span>
    </p>
    <ul class="navbar-nav flex-fill w-100 mb-2">
      <li class="nav-item w-100">
        <a class="nav-link" href="../docs/index.html">
          <i class="fe fe-help-circle fe-16"></i>
          <span class="ml-3 item-text">Getting Start</span>
        </a>
      </li>
    </ul>
  </nav>
</aside>