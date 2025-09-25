<?php
require_once 'admin/controller/koneksi.php';
include 'admin/controller/administrator-validation.php';

if (isset($_GET['delete'])) {
    $idDelete = $_GET['delete'];
    $query = mysqli_query($config, "DELETE FROM level WHERE id='$idDelete'");
    header("Location: ?page=level/level&delete=success");
    die;
} else if (isset($_GET['edit'])) {
    $idEdit = $_GET['edit'];
    $queryEdit = mysqli_query($config, "SELECT * FROM level WHERE id='$idEdit'");
    $rowEdit = mysqli_fetch_assoc($queryEdit);
    if (isset($_POST['edit'])) {
        $level_name = $_POST['level_name'];
        $queryEdit = mysqli_query($config, "UPDATE level SET level_name='$level_name' WHERE id='$idEdit'");
        header("Location: ?page=level/level&edit=success");
        die;
    }
} else if (isset($_POST['add'])) {
    $level_name = $_POST['level_name'];
    $queryAdd = mysqli_query($config, "INSERT INTO level (level_name) VALUES ('$level_name')");
    header("Location: ?page=level/level&add=success");
    die;
}
?>
<div class="container">
   <div class="card shadow">
    <div class="card-header">
        <h5><?= isset($_GET['edit']) ? 'Edit' : 'Add' ?> Level</h5>
    </div>
    <div class="card-body">
        <form action="" method="post">
            <div class="row">
                <div class="col-sm-6 mb-3">
                    <label for="" class="form-label">Level Name</label>
                    <input type="text" class="form-control" id="" name="level_name" placeholder="Enter level name"
                        value="" required>
                </div>
            </div>
            <div class="">
                <button type="submit" class="btn btn-primary btn-sm"
                    name="<?php echo isset($_GET['edit']) ? 'edit' : 'add' ?>">
                    <?php echo isset($_GET['edit']) ? '' : '' ?>
                    <i class="fe fe-save fe-16"></i>
                </button>
            </div>
        </form>
    </div>
</div> 
</div>
