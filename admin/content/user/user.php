<?php
include 'admin/controller/administrator-validation.php';
$queryData = mysqli_query($config, "SELECT user.id, user.username, user.email, level.level_name FROM user LEFT JOIN level ON user.id_level = level.id ORDER BY user.id_level ASC, user.updated_at DESC");

?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header">
            <h5>Data User</h5>
        </div>
        <div class="card-body">
            <?php include 'admin/controller/alert-data-crud.php' ?>
            <table class="table table-borderless table-hover  mt-3 datatable">
                <thead class="">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($rowData = mysqli_fetch_assoc($queryData)) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= isset($rowData['username']) ? $rowData['username'] : '-' ?></td>
                            <td><?= isset($rowData['email']) ? $rowData['email'] : '-' ?></td>
                            <td>
                                <div class="button-action">
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#defaultModal"> <i class="fe fe-plus fe-16"></i></button>
                                    <!-- Modal -->
                                    <a href="?page=user/tambah-user&edit=<?php echo $rowData['id'] ?>">
                                        <button class="btn btn-info btn-sm">
                                            <i class="fe fe-edit fe-16"></i>
                                        </button>
                                    </a>
                                    <a onclick="return confirm ('Apakah anda yakin akan menghapus data ini?')"
                                        href="?page=tuser/ambah-user&delete=<?php echo $rowData['id'] ?>">
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fe fe-trash-2 fe-16"></i>
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


<!-- Modal -->
<div class="modal fade" id="defaultModal" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="defaultModalLabel"><?= isset($_GET['edit']) ? 'Ubah' : 'Tambah' ?> User </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="">Nama Lengkap</label>
                        <input value="<?php echo isset($rowEdit['username']) ? $rowEdit['username'] : '' ?>" type="text" class="form-control" name="username" placeholder="Enter Your Name" required>
                    </div>
                    <div class="mb-3">
                        <label for="">Email</label>
                        <input value="<?php echo isset($rowEdit['email']) ? $rowEdit['email'] : '' ?>" type="email" class="form-control" name="email" placeholder="Enter Your Email" required>
                    </div>
                    <div class="mb-3">
                        <label for="">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter Your password" <?php echo empty($id_user) ? 'required' : '' ?>>
                        <small>
                            )* if you want to change your password, you can fill this field
                        </small>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-success btn-sm" name="save"> <i class="fe fe-save fe-16"></i></button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal"> <i class="fe fe-arrow-left fe-16"></i></button>
                <button type="button" class="btn mb-2 btn-primary"> <i class="fe fe-save fe-16"></i></i></button>
            </div>
        </div>
    </div>
</div>