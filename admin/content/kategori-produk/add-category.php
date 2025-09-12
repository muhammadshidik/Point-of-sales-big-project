<?php
require_once 'admin/controller/koneksi.php';
include 'admin/controller/administrator-validation.php';

if (isset($_GET['delete'])) {
    $idDelete = $_GET['delete'];
    $query = mysqli_query($config, "DELETE FROM kategori WHERE id='$idDelete'");
    header("Location: ?page=kategori-produk/category&delete=success");
    die;
} else if (isset($_GET['edit'])) {
    $idEdit = $_GET['edit'];
    $queryEdit = mysqli_query($config, "SELECT * FROM kategori WHERE id='$idEdit'");
    $rowEdit = mysqli_fetch_assoc($queryEdit);
    if (isset($_POST['edit'])) {
        $nama_kategori = $_POST['nama_kategori'];
        $queryEdit = mysqli_query($config, "UPDATE kategori SET nama_kategori='$nama_kategori' WHERE id='$idEdit'");
        header("Location: ?page=kategori-produk/category&edit=success");
        die;
    }
} else if (isset($_POST['add'])) {
    $nama_kategori = $_POST['nama_kategori'];
    $queryAdd = mysqli_query($config, "INSERT INTO kategori (nama_kategori) VALUES ('$nama_kategori')");
    header("Location: ?page=kategori-produk/category&add=success");
    die;
}
?>
<div class="container">
   <div class="card shadow">
    <div class="card-header">
        <h3><?= isset($_GET['edit']) ? 'Edit' : 'Add' ?> Kategori</h3>
    </div>
    <div class="card-body">
        <form action="" method="post">
            <div class="row">
                <div class="col-sm-6 mb-3">
                    <label for="" class="form-label">Nama Kategori Produk</label>
                    <input type="text" class="form-control" id="" name="nama_kategori" placeholder="Masukkan kategori Produk"
                        value="" required>
                </div>
            </div>
            <div class="">
                <button type="submit" class="btn btn-primary btn-sm"
                    name="<?php echo isset($_GET['edit']) ? 'edit' : 'add' ?>">
                    <?php echo isset($_GET['edit']) ? 'Simpan Perubahan' : 'Simpan' ?>
                </button>
            </div>
        </form>
    </div>
</div> 
</div>
