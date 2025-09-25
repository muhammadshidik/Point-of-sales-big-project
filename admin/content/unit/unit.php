<?php
include 'admin/controller/koneksi.php';

$queryUnit = mysqli_query($config, "SELECT * FROM unit");
$rowUnit = mysqli_fetch_all($queryUnit, MYSQLI_ASSOC,);

?>
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h5>Unit Produk</h5>
        </div>
        <div class="card-body ">

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
                                <div class='button-action'>
                                    <a href="?page=unit/tambah-unit" class="btn btn-success btn-sm"><i class="fe fe-plus fe-16"></i></a>
                                    <a href="?page=unit/tambah-unit&edit=<?= $row['id'] ?>"
                                        class="btn btn-info btn-sm"><i class="fe fe-edit fe-16"></i></a>
                                    <a onclick="return confirm('Are you sure wanna delete this data??')"
                                        href="?page=unit/unit&delete=<?= $row['id'] ?>"
                                        class="btn btn-danger btn-sm"><i class="fe fe-trash fe-16"></i></a>
                                </div>


                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>