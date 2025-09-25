<?php
require_once 'admin/controller/koneksi.php';
if (isset($_GET['delete'])) {
    $idDelete = $_GET['delete'];
    $query = mysqli_query($config, "DELETE FROM produk WHERE id='$idDelete'");
    header("Location: ?page=stok/stok&delete=success");
    die;
} else if (isset($_GET['edit'])) {
    $idEdit = $_GET['edit'];
    $queryEdit = mysqli_query($config, "SELECT * FROM produk WHERE id='$idEdit'");
    $rowEdit = mysqli_fetch_assoc($queryEdit);
    if (isset($_POST['edit'])) {
        $nama_produk = $_POST['nama_produk'];
        $queryEdit = mysqli_query($config, "UPDATE produk SET nama_produk='$nama_produk' WHERE id='$idEdit'");
        header("Location: ?page=stok/stok&edit=success");
        die;
    }
} else if (isset($_POST['add'])) {
    $nama_produk = $_POST['nama_produk'];
    $jumlah    = $_POST['jumlah'];
    mysqli_query($config, "INSERT INTO produk (nama_produk, jumlah) VALUES ('$nama_produk', '$jumlah')");
    header("Location: ?page=stok/stok&add=success");
    die;
}
$result = mysqli_query($config, "SELECT * FROM produk");
?>
<div class="container">
    <div class="card shadow">
        <div class="card-header">
            <h5><?= isset($_GET['edit']) ? 'Edit' : 'Add' ?> Stok Barang</h5>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label for="nama_produk" class="form-label">Pilih Produk</label>
                    <select name="nama_produk" id="nama_produk" class="form-control select2" id="simple-select2" required>
                        <optgroup label="Pilih Kategori">
                            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                <option value="<?= $row['id']; ?>">
                                    <?= $row['nama_produk']; ?> (Stok: <?= $row['stok']; ?>)
                                </option>
                            <?php endwhile; ?>
                        </optgroup>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah Masuk</label>
                    <input type="number" name="jumlah" id="jumlah" class="form-control" placeholder="Masukkan jumlah" required>
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