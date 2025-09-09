<?php
include 'admin/controller/administrator-validation.php';
$queryData = mysqli_query($config, "SELECT * FROM level ORDER BY id ASC");
?>

<div class="container">
    <div class="card shadow">
        <div class="card-header">
            <h3>Data Level</h3>
        </div>
        <div class="card-body">
            <?php include 'admin/controller/alert-data-crud.php' ?>
            <div class="button-action">
                <a href="?page=tambah-level" class="btn btn-primary btn-sm">Tambah Akses</a>
            </div>
            <table class="table table-borderless table-hover mt-3">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Pemegang Akses</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($rowData = mysqli_fetch_assoc($queryData)) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= isset($rowData['level_name']) ? $rowData['level_name'] : '-' ?></td>
                            <td>
                                <a href="?page=tambah-level&edit=<?php echo $rowData['id'] ?>">
                                    <button class="btn btn-secondary btn-sm">
                                        Ubah
                                    </button>
                                </a>
                                <a onclick="return confirm ('Apakah anda yakin akan menghapus data ini?')"
                                    href="?page=tambah-level&delete=<?php echo $rowData['id'] ?>">
                                    <button class="btn btn-danger btn-sm">
                                      Hapus
                                    </button>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; // End While 
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>