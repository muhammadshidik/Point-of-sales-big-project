<?php
require_once 'admin/controller/koneksi.php';

if (isset($_GET['delete'])) {
    $idDelete = $_GET['delete'];
    $query = mysqli_query($config, "DELETE FROM karyawan WHERE id='$idDelete'");
    header("Location: ?page=karyawan/karyawan&delete=success");
    die;
} else if (isset($_GET['edit'])) {
    $idEdit = $_GET['edit'];
    $queryEdit = mysqli_query($config, "SELECT * FROM karyawan WHERE id='$idEdit'");
    $rowEdit = mysqli_fetch_assoc($queryEdit);
    if (isset($_POST['edit'])) {
        $nama = $_POST['nama'];
        $no_hp = $_POST['no_hp'];
        $alamat = $_POST['alamat'];
        $tgl_masuk = $_POST['tgl_masuk'];
        $status = $_POST['status'];
        $queryEdit = mysqli_query($config, "UPDATE karyawan SET nama='$nama',no_hp='$no_hp',alamat='$alamat',tgl_masuk='$tgl_masuk',status='$status'  WHERE id='$idEdit'");
        header("Location: ?page=karyawan/karyawan&edit=success");
        die;
    }
} else if (isset($_POST['add'])) {
    $nama = $_POST['nama'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];
    $tgl_masuk = $_POST['tgl_masuk'];
    $status = $_POST['status'];
    $queryAdd = mysqli_query($config, "INSERT INTO karyawan (nama, no_hp, alamat, tgl_masuk, status ) VALUES ('$nama','$no_hp','$alamat','$tgl_masuk','$status')");
    header("Location: ?page=karyawan/karyawan&add=succes");
    die;
}

$queryKaryawan = mysqli_query($config, "SELECT * FROM karyawan ORDER BY id DESC");
$rowKaryawan = mysqli_fetch_assoc($queryKaryawan);

?>
<div class="container">
    <div class="card shadow">
        <div class="card-header">
            <h5><?= isset($_GET['edit']) ? 'Edit' : 'Add' ?> karyawan</h5>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <label for="" class="form-label">Nama Karyawan</label>
                        <input type="text" class="form-control" id="" name="nama" placeholder="Nama Karyawan"
                            value="<?= isset($rowEdit['nama']) ? $rowEdit['nama'] :  '' ?>" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="" class="form-label">No.Hp *</label>
                        <input type="number" class="form-control" id="" name="no_hp" placeholder="Nomor Handphone"
                            value="<?= isset($rowEdit['no_hp']) ? $rowEdit['no_hp'] :  '' ?>" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="" class="form-label">Alamat</label>
                        <textarea name="alamat" id="" class="form-control" placeholder="Alamat Tinggal .."><?= isset($rowEdit['alamat']) ? $rowEdit['alamat'] :  '' ?></textarea>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="" class="form-label">Tanggal Masuk *</label>
                        <input type="date" class="form-control" id="" name="tgl_masuk" placeholder="Tanggal Bergabung.."
                            value="<?= isset($rowEdit['tgl_masuk']) ? $rowEdit['tgl_masuk'] :  '' ?>" required >
                            
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="simple-select2">Status</label>
                        <select name="status" class="form-control select2" id="simple-select2" required>
                            <optgroup label="Pilih status">
                                <?php $no = 1; ?>
                                <option value="0" <?= (isset($rowEdit['status']) && $rowEdit['status'] == 0) ? ' selected' : '' ?>>
                                    <?= $no++ . '. ' . karyawan(0) ?>
                                </option>
                                <option value="1" <?= (isset($rowEdit['status']) && $rowEdit['status'] == 1) ? ' selected' : '' ?>>
                                    <?= $no++ . '. ' . karyawan(1) ?>
                                </option>

                            </optgroup>
                        </select>
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