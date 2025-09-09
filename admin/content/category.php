<?php
require_once './admin/controller/koneksi.php';
require_once 'admin/controller/functions.php';

// Ambil semua data menu
$query = "SELECT * FROM kategori ORDER BY id DESC";
$result = mysqli_query($config, $query);
?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header">
            <h4>Data Kategori</h4>
        </div>
        <div class="card-body">
            <?php include 'admin/controller/alert-data-crud.php'; // Semicolon added 
            ?>
            <a href="?page=add-category" class="btn btn-primary mb-3 btn-sm">+ Tambah Kategori</a>

            <table class="table table-borderless table-hover mt-3 datatable">
                <thead class="table-dark">
                    <tr>
                        <td>No</td>
                        <td>Nama</td>
                        <td>Aksi</td>
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
                                <td><?= htmlspecialchars($row['nama_kategori']) ?></td>
                                <td>
                                    <a href="?page=add-category&edit=<?= $row['id'] ?>" class="btn btn-outline-warning btn-sm">Edit</a>
                                    <a href="?page=add-category&delete=<?= $row['id'] ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Yakin hapus menu ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile;
                    else : ?>
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data menu.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>