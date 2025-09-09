<?php
include 'admin/controller/koneksi.php';
$result = mysqli_query($config, "SELECT * FROM produk");
?>
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h4>Laporan Stok</h4>
        </div>
        <div class="card-body mt-4">
            <div align="left" >
                <a href="?page=tambah-stok" class="btn btn-primary btn-sm">Tambah Barang</a>
            </div>
            <table class="table table-borderless table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) :
                        $status = ($row['stok'] <= 5)
                            ? "<span class='badge bg-danger'><i class='bi bi-exclamation-triangle-fill'></i> Menipis</span>"
                            : "<span class='badge bg-success'><i class='bi bi-check-circle-fill'></i> Cukup</span>";
                    ?>
                        <tr>
                            <td><?= $row['nama_produk']; ?></td>
                            <td><?= $row['stok']; ?></td>
                            <td><?= $status; ?></td>
                            <td>
                                <a href="?page=tambah-stok&edit=<?php echo $row['id'] ?>">
                                    <button class="btn btn-secondary btn-sm">Edit
                                    </button>
                                </a>
                                <a onclick="return confirm ('Apakah anda yakin akan menghapus data ini?')"
                                    href="?page=tambah-stok&delete=<?php echo $row['id'] ?>">
                                    <button class="btn btn-danger btn-sm">Hapus
                                    </button>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>