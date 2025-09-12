  <?php
  include 'admin/controller/koneksi.php';
  // Memanggil file yang berisi fungsi-fungsi tambahan
  include 'admin/controller/functions.php';
  $navbarID = $_SESSION['id'];
  $queryNavbar = mysqli_query($config, "SELECT * FROM user WHERE id = '$navbarID'");
  $dataNavbar = mysqli_fetch_assoc($queryNavbar);
  ?>

  <nav class="topnav navbar navbar-light">
    <button type="button" class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar">
      <i class="fe fe-menu navbar-toggler-icon"></i>
    </button>
    <form class="form-inline mr-auto searchform text-muted">
      <input class="form-control mr-sm-2 bg-transparent border-0 pl-4 text-muted" type="search" placeholder="Ketik Sesuatu..." aria-label="Search">
    </form>

    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link text-muted my-2" href="#" id="modeSwitcher" data-mode="dark">
          <i class="fe fe-sun fe-16"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-muted my-2" href="./#" data-toggle="modal" data-target=".modal-shortcut">
          <span class="fe fe-grid fe-16"></span>
        </a>
      </li>
      <li class="nav-item nav-notif">
        <a class="nav-link text-muted my-2" href="./#" data-toggle="modal" data-target=".modal-notif">
          <span class="fe fe-bell fe-16"></span>
          <span class="dot dot-md bg-success"></span>
        </a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-muted pr-0" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="avatar avatar-sm mt-2">
            <img style=" width: 40px; height: 40px;" src="<?= !empty($dataNavbar['profile_picture']) && file_exists('admin/content/uploads/Foto/' . $dataNavbar['profile_picture'])
                        ? 'admin/content/uploads/Foto/' . $dataNavbar['profile_picture']
                        : 'https://placehold.co/100' ?>"
              alt="..." class="avatar-img rounded-circle">

          </span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="?page=profil-saya/my-profile">Profil</a>
          <a class="dropdown-item" href="#">Aktivitas</a>
          <button class="dropdown-item btn btn-danger" onclick="confirmLogout()">Keluar</button>

          <script>
            function confirmLogout() {
              if (confirm("Apakah Anda yakin ingin keluar?")) {
                window.location.href = "?page=keluar";
              }
            }
          </script>

        </div>
      </li>
    </ul>
  </nav>