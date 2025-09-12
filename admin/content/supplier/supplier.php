<?php
include 'admin/controller/koneksi.php';

// Query ambil semua data supplier
$querySupplier = mysqli_query($config, "SELECT * FROM supplier");

// Fetch semua data supplier dalam bentuk array asosiatif
$rowSupplier = mysqli_fetch_all($querySupplier, MYSQLI_ASSOC);
?>
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h5>Data Supplier</h5>
        </div>
        <div class="card-body">
            <div class="mb-3" align="left">
                <a href="?page=supplier/tambah-supplier" class="btn btn-primary btn-sm">Tambah Supplier</a>
            </div>
            <table class="table table-borderless table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>No. Telepon</th>
                        <th>Alamat</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($rowSupplier as $index => $row): ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $row['nama_supplier']; ?></td>
                            <td><?php echo $row['no_telp']; ?></td>
                            <td><?php echo $row['alamat']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td>
                                <!-- Tombol Ubah -->
                                <a href="?page=supplier/tambah-supplier&edit=<?php echo $row['id_supplier']; ?>">
                                    <button class="btn btn-secondary btn-sm">
                                        Ubah
                                    </button>
                                </a>
                                <!-- Tombol Hapus -->
                                <a onclick="return confirm('Apakah anda yakin akan menghapus data ini?')"
                                    href="?page=supplier/tambah-supplier&delete=<?php echo $row['id_supplier']; ?>">
                                    <button class="btn btn-danger btn-sm">
                                        Hapus
                                    </button>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
