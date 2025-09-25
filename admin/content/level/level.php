<?php
include 'admin/controller/administrator-validation.php';
$queryData = mysqli_query($config, "SELECT * FROM level ORDER BY id ASC");
?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header">
            <h5>Data Level</h5>
        </div>
        <div class="card-body">
            <?php include 'admin/controller/alert-data-crud.php' ?>
            <table class="table table-borderless table-hover mt-3">
                <thead>
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
                                <div class="button-action my-3">
                                    <a href="?page=level/tambah-level" class="btn btn-success btn-sm me-2"> <i class="fe fe-plus fe-16"></i></a>
                                    <a href="?page=level/tambah-level&edit=<?php echo $rowData['id'] ?>">
                                        <button class="btn btn-info btn-sm ">
                                             <i class="fe fe-edit fe-16"></i>
                                        </button>
                                    </a>
                                    <a onclick="return confirm ('Apakah anda yakin akan menghapus data ini?')"
                                        href="?page=level/tambah-level&delete=<?php echo $rowData['id'] ?>">
                                        <button class="btn btn-danger btn-sm">
                                             <i class="fe fe-trash fe-16"></i>
                                        </button>
                                    </a>
                                </div>

                            </td>
                        </tr>
                    <?php endwhile; // End While 
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>