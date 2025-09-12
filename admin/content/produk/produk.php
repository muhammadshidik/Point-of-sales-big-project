<?php
require_once './admin/controller/koneksi.php';
require_once 'admin/controller/functions.php';

// Mengambil data produk beserta nama kategorinya dengan JOIN
$query = "SELECT produk.*, 
                 kategori.nama_kategori, 
                 unit.nama_unit
          FROM produk
          JOIN kategori ON produk.kategori_id = kategori.id
          LEFT JOIN unit ON produk.id = unit.id
          ORDER BY produk.id DESC";

$result = mysqli_query($config, $query);

?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header">
            <h5>Data Daftar Produk</h5>
        </div>
        <div class="card-body">
                <?php include 'admin/controller/alert-data-crud.php'; // Semicolon added 
            ?>
            <a href="?page=produk/add-produk" class="btn btn-primary mb-3 btn-sm">Tambah produk</a>
            <!-- table -->
            <table class="table table-borderless table-hover  mt-3 datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Nama Kategori</th>
                        <th>Stok</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    // Check if there are any rows returned
                    if (mysqli_num_rows($result) > 0) :
                        while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row['nama_produk'] ?></td>
                                <td><?= $row['harga_jual'] ?></td>
                                <td><?= $row['nama_kategori'] ?></td>
                                <td><?= $row['stok'] ?></td>
                                <td>
                                    <?php
                                    // Construct the image path
                                    $imagePath = 'admin/content/uploads/Foto/' . $row['gambar'];
                                    // Check if the image file exists, otherwise use a default placeholder
                                    if (!file_exists($imagePath) || empty($row['gambar'])) {
                                        $imagePath = 'admin/content/uploads/Foto/default-food.jpg'; // Path to a default image
                                    }
                                    ?>
                                    <img src="<?= $imagePath ?>" width="80" alt="<?= $row['nama_produk'] ?>">
                                </td>
                                <td>
                                    <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="text-muted sr-only">Action</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="?page=produk/add-produk&edit=<?= $row['id'] ?>">Edit</a>
                                        <a class="dropdown-item" href="?page=produk/add-produk&delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus menu ini?')">Hapus</a>
                                        <a class="dropdown-item" href="#">Detail</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile;
                    else : ?>
                        <tr>
                            <td colspan="8" class="text-center">Data Tidak Ditemukan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <nav aria-label="Table Paging" class="mb-0 text-muted">
                <ul class="pagination justify-content-center mb-0">
                    <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item active"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>
  
    <script>
      $('#dataTable-1').DataTable(
      {
        autoWidth: true,
        "lengthMenu": [
          [16, 32, 64, -1],
          [16, 32, 64, "All"]
        ]
      });
    </script>
    <script src="tmp/js/apps.js"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];

      function gtag()
      {
        dataLayer.push(arguments);
      }
      gtag('js', new Date());
      gtag('config', 'UA-56159088-1');
    </script>