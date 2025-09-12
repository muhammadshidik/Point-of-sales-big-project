<?php
include 'admin/controller/koneksi.php';

$queryUnit = mysqli_query($config, "SELECT * FROM unit");
$rowUnit = mysqli_fetch_all($queryUnit, MYSQLI_ASSOC, );

?>
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h5>Unit Produk</h5>
        </div>
        <div class="card-body ">
            <div class='mb-3' align="left" >
                <a href="?page=unit/tambah-unit" class="btn btn-primary btn-sm"> Tambah Unit</a>
            </div>
            <table class="table table-borderless table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Unit</th>
                        <th>Deskripsi</th>
                        <th>aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($rowUnit as $index => $row): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $row['nama_unit'] ?></td>
                            <td><?= $row['deskripsi'] ?></td>
                            <td>
                                <a  href="?page=unit/tambah-unit&edit=<?= $row['id'] ?>"
                                    class="btn btn-secondary btn-sm">Ubah</a>
                                <a onclick="return confirm('Are you sure wanna delete this data??')"
                                   href="?page=unit/unit&delete=<?= $row['id'] ?>"
                                    class="btn btn-danger btn-sm">Hapus</a>

                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>