<?php
require_once 'admin/controller/koneksi.php';
include 'admin/controller/administrator-validation.php';

if (isset($_GET['delete'])) {
    $idDelete = $_GET['delete'];
    $query = mysqli_query($config, "DELETE FROM customer WHERE id='$idDelete'");
    header("Location: ?page=pelanggan&delete=success");
    die;
} else if (isset($_GET['edit'])) {
    $idEdit = $_GET['edit'];
    $queryEdit = mysqli_query($config, "SELECT * FROM customer WHERE id='$idEdit'");
    $rowEdit = mysqli_fetch_assoc($queryEdit);
    if (isset($_POST['edit'])) {
        $customer_name = $_POST['customer_name'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        $queryEdit = mysqli_query($config, "UPDATE customer SET customer_name='$customer_name', phone='$phone', address='$address' WHERE id='$idEdit'");
        header("Location: ?page=pelanggan&edit=success");
        die;
    }
} else if (isset($_POST['add'])) {
    $customer_name = $_POST['customer_name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $queryAdd = mysqli_query($config, "INSERT INTO customer (customer_name, phone, address) VALUES ('$customer_name', '$phone', '$address')");
    header("Location: ?page=pelanggan&add=success");
    die;
}
?>

<div class="card shadow">
    <div class="card-header">
        <h5><?= isset($_GET['edit']) ? 'Ubah' : 'Tambah' ?> Data Pelanggan</h5>
    </div>
    <div class="card-body">
        <form action="" method="post">
            <div class="row">
                <div class="col-sm-6 mb-3">
                    <label for="" class="form-label">Nama Pelanggan</label>
                    <input type="text" class="form-control" id="" name="customer_name" placeholder="Masukkan Nama Pelanggan"
                        value="<?= isset($_GET['edit']) ? $rowEdit['customer_name'] : '' ?>" required>
                </div>
                <div class="col-sm-6 mb-3">
                    <label for="" class="form-label">No. Telepon</label>
                    <input type="number" class="form-control" id="" name="phone" placeholder="Masukkan Nomor Telepon"
                        value="<?= isset($_GET['edit']) ? $rowEdit['phone'] : '' ?>" required>
                </div>
                <div class="col-sm-6 mb-3">
                    <label for="" class="form-label">Alamat</label>
                    <textarea name="address" id="" class="form-control"
                        placeholder="Masukkan Alamat"><?= isset($_GET['edit']) ? $rowEdit['address'] : '' ?></textarea>
                </div>
            </div>
            <div class="">
                <button type="submit" class="btn btn-primary btn-sm"
                    name="<?php echo isset($_GET['edit']) ? 'edit' : 'add' ?>">
                    <?php echo isset($_GET['edit']) ? 'Simpan' : 'Simpan' ?>
                </button>
            </div>
        </form>
    </div>
</div>