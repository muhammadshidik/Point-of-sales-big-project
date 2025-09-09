<?php
require_once './admin/controller/koneksi.php';
require_once 'admin/controller/functions.php';

// Ambil semua data menu
$query = "SELECT * FROM banner ORDER BY id DESC";
$result = mysqli_query($config, $query);
?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header">
            <h4>Data Banner</h4>
        </div>
        <div class="card-body">
            <?php include 'admin/controller/alert-data-crud.php'; // Semicolon added 
            ?>
            <a href="?page=add-slider" class="btn btn-primary mb-3">+ Tambah slide</a>

            <table class="table table-borderless table-hover  mt-3 datatable">
                <thead class="table-dark">
                    <tr>
                        <td>No</td>
                        <th>Judul</th>
                        <th>Deskripsi</th>
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
                                <td><?= htmlspecialchars($row['judul']) ?></td>
                                <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                                <td>
                                    <?php
                                    // Construct the image path
                                    $imagePath = 'admin/content/uploads/Foto/' . htmlspecialchars($row['gambar']);
                                    // Check if the image file exists, otherwise use a default placeholder
                                    if (!file_exists($imagePath) || empty($row['gambar'])) {
                                        $imagePath = 'admin/content/uploads/Foto/default-food.jpg'; // Path to a default image
                                    }
                                    ?>
                                    <img src="<?= $imagePath ?>" width="80" alt="<?= htmlspecialchars($row['judul']) ?>">
                                </td>
                                <td>
                                    <a href="?page=add-slider&edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="?page=add-slider&delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus menu ini?')">Hapus</a>
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