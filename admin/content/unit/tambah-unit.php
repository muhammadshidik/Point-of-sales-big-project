<?php
require_once 'admin/controller/koneksi.php';
if (isset($_GET['delete'])) {
    $idDelete = $_GET['delete'];
    $query = mysqli_query($config, "DELETE FROM unit WHERE id='$idDelete'");
    header("Location: ?page=unit/unit&delete=success");
    die;
} else if (isset($_GET['edit'])) {
    $idEdit = $_GET['edit'];
    $queryEdit = mysqli_query($config, "SELECT * FROM unit WHERE id='$idEdit'");
    $rowEdit = mysqli_fetch_assoc($queryEdit);
    if (isset($_POST['edit'])) {
        $nama_unit = $_POST['nama_unit'];
        $deskripsi = $_POST['deskripsi'];
        $queryEdit = mysqli_query($config, "UPDATE unit SET nama_unit ='$nama_unit', deskripsi = '$deskripsi' WHERE id='$idEdit'");
        header("Location: ?page=unit/unit&edit=success");
        die;
    }
} else if (isset($_POST['add'])) {
     $nama_unit = $_POST['nama_unit'];
      $deskripsi = $_POST['deskripsi'];
    mysqli_query($config, "INSERT INTO unit (nama_unit, deskripsi) VALUES ('$nama_unit', '$deskripsi' )");
    header("Location: ?page=unit/unit&add=success");
    die;
}
$result = mysqli_query($config, "SELECT * FROM unit");
?>

<div class="container">
   <div class="card shadow">
    <div class="card-header">
        <h5><?= isset($_GET['edit']) ? 'Edit' : 'Add' ?> Unit </h5>
    </div>
    <div class="card-body">
        <form action="" method="post">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="" class="form-label">Nama Unit</label>
                    <input type="text" class="form-control" id="" name="nama_unit" placeholder="Masukkan Unit"
                        value="<?= isset($rowEdit['nama_unit']) ? $rowEdit['nama_unit'] : '' ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="" class="form-label">Deskripsi</label>
                   <textarea class="form-control" name="deskripsi" id=""><?= isset($rowEdit['deskripsi']) ? $rowEdit['deskripsi'] : '' ?></textarea>
                </div>
            </div>
            <div class="">
                <button type="submit" class="btn btn-primary btn-sm"
                    name="<?php echo isset($_GET['edit']) ? 'edit' : 'add' ?>">
                    <?php echo isset($_GET['edit']) ? '' : '' ?><i class="fe fe-save fe-16"></i>
                </button>
            </div>
        </form>
    </div>
</div> 
</div>