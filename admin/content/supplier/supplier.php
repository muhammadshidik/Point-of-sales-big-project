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
            <table class="table table-borderless table-hover">
                <div class="button-action">
                    <a href="?page=supplier/tambah-supplier" class="btn btn-success btn-sm"> <i class="fe fe-plus fe-16"></i></a>
                </div>
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
                            <td><?php echo $row['kontak']; ?></td>
                            <td><?php echo $row['alamat']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td>
                                <div class="button-action">
                                    <!-- Tombol Ubah -->
                                    <a href="?page=supplier/tambah-supplier&edit=<?php echo $row['id']; ?>">
                                        <button class="btn btn-info btn-sm">
                                            <i class="fe fe-edit fe-16"></i>
                                        </button>
                                    </a>
                                    <!-- Tombol Hapus -->
                                    <a onclick="return confirm('Apakah anda yakin akan menghapus data ini?')"
                                        href="?page=supplier/tambah-supplier&delete=<?php echo $row['id']; ?>">
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fe fe-trash fe-16"></i>
                                        </button>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>