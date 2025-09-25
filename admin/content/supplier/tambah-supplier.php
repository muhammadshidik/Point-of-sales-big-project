<?php
require_once 'admin/controller/koneksi.php';
if (isset($_GET['delete'])) {
    $idDelete = $_GET['delete'];
    $query = mysqli_query($config, "DELETE FROM supplier WHERE id='$idDelete'");
    header("Location: ?page=supplier/supplier&delete=success");
    die;
} else if (isset($_GET['edit'])) {
    $idEdit = $_GET['edit'];
    $queryEdit = mysqli_query($config, "SELECT * FROM supplier WHERE id='$idEdit'");
    $rowEdit = mysqli_fetch_assoc($queryEdit);
    if (isset($_POST['edit'])) {
        $nama_supplier = $_POST['nama_supplier'];
        $kontak = $_POST['kontak'];
        $alamat = $_POST['alamat'];
        $email = $_POST['email'];
        $queryEdit = mysqli_query($config, "UPDATE supplier SET nama_supplier='$nama_supplier', kontak='$kontak',alamat='$alamat', email='$email'  WHERE id='$idEdit'");
        header("Location: ?page=supplier/supplier&edit=success");
        die;
    }
} else if (isset($_POST['add'])) {
    $nama_supplier = $_POST['nama_supplier'];
    $kontak = $_POST['kontak'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    mysqli_query($config, "INSERT INTO supplier (nama_supplier, alamat, kontak, email) VALUES ('$nama_supplier', '$alamat', '$kontak', '$email')");
    header("Location: ?page=supplier/supplier&add=success");
    die;
}
$result = mysqli_query($config, "SELECT * FROM supplier");
?>
<div class="container">
    <div class="card shadow">
        <div class="card-header">
            <h5><?= isset($_GET['edit']) ? 'Edit' : 'Add' ?> supplier Barang</h5>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Nama Supplier</label>
                    <input type="text" name="nama_supplier" class="form-control" placeholder="Masukkan Nama Supplier" value="<?= isset($rowEdit['nama_supplier']) ? $rowEdit['nama_supplier'] : '' ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">No. Telepon</label>
                    <input type="number" name="kontak" class="form-control" placeholder="Masukkan No. Telepon" value="<?= isset($rowEdit['kontak']) ? $rowEdit['kontak'] : '' ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" placeholder="Masukkan Alamat" required><?= $rowEdit['alamat'] ?? '' ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="text" name="email" class="form-control" value="<?= isset($rowEdit['email']) ? $rowEdit['email'] : '' ?>" placeholder="Masukkan Email" required>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary btn-sm"
                        name="<?php echo isset($_GET['edit']) ? 'edit' : 'add' ?>">
                        <?php echo isset($_GET['edit']) ? '' : '' ?> <i class="fe fe-save fe-16"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>