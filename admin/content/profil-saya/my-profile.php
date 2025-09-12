<?php
require_once 'admin/controller/koneksi.php';

$idEdit = $_SESSION['id'];
$queryEdit = mysqli_query($config, "SELECT * FROM user WHERE id='$idEdit'");
$rowEdit = mysqli_fetch_assoc($queryEdit);
$queryLevel = mysqli_query($config, "SELECT * FROM level");
if (isset($_POST['edit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $company = $_POST['company'];
    $phone = $_POST['phone'];
    $deskripsi = $_POST['deskripsi'];

    if (!empty($_FILES['photo']['name'])) {
        $namaFotoLama = $_FILES['photo']['name'];

        $ext = array('jpg', 'jpeg', 'png', 'jfif', 'webp', 'heic');
        $img_ext = pathinfo($namaFotoLama, PATHINFO_EXTENSION);

        if (!in_array($img_ext, $ext)) {
            header("Location: ?page=profil-saya/my-profile&edit=errorExtension");
            die;
        } else {
            if (file_exists('admin/content/uploads/Foto/' . $rowEdit['profile_picture'])) {
                unlink('admin/content/uploads/Foto/' . $rowEdit['profile_picture']);
            }
            $new_image_name = "Gambar" . $idEdit . "." . $img_ext;
            move_uploaded_file($_FILES['photo']['tmp_name'], 'admin/content/uploads/Foto/' . $new_image_name);
            $queryEdit = mysqli_query($config, "UPDATE user SET username='$username', email='$email', profile_picture='$new_image_name' WHERE id='$idEdit'");
        }
    }
    $queryEdit = mysqli_query($config, "UPDATE user SET username='$username', email='$email', password='$password',address='$address', company='$company', phone='$phone', deskripsi='$deskripsi' WHERE id='$idEdit'");
    header("Location: ?page=profil-saya/my-profile&edit=success");
    die;
}

?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h4><strong class="card-title">Data Profil Saya</strong></h4>
                </div>
                <div class="card-body">
                    <?php if (isset($_GET['edit']) && $_GET['edit'] == 'success'): ?>
                        <div class="alert alert-success alert-dismissible" role="alert">
                            Ubah Profil Sukses
                            <button type="button" class="btn btn-close fe fe-check" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php elseif (isset($_GET['edit']) && $_GET['edit'] == 'errorExtension'): ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                           Format file tidak didukung!
                            <button type="button" class="btn btn-close fe-slash" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif ?>
                
                    <div class="row mt-5 align-items-center">
                        <!-- FOTO -->
                        <div class="col-md-3 text-center">
                            <img width="150px"
                                src="<?= !empty($rowEdit['profile_picture']) && file_exists('admin/content/uploads/Foto/' . $rowEdit['profile_picture'])
                                            ? 'admin/content/uploads/Foto/' . $rowEdit['profile_picture']
                                            : 'https://placehold.co/100' ?>"
                                alt="..."
                                class="mt-4 rounded">
                        </div>
                        <!-- DATA / TULISAN -->
                        <div class="col-md-9">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <h4 class="mb-1"><?= isset($rowEdit['username']) ? $rowEdit['username'] : '' ?></h4>
                                    <p class="small mb-3">Domisili : <?= isset($rowEdit['address']) ? $rowEdit['address'] : '' ?></p>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <p class="text-muted"><?= isset($rowEdit['deskripsi']) ? $rowEdit['deskripsi'] : '' ?></p>
                                    <p class="small mb-0 text-muted">Perusahaan : <?= isset($rowEdit['company']) ? $rowEdit['company'] : '' ?></p>
                                    <p class="small mb-0 text-muted">Email : <?= isset($rowEdit['email']) ? $rowEdit['email'] : '' ?></p>
                                    <p class="small mb-0 text-muted">No. HP : <?= isset($rowEdit['phone']) ? $rowEdit['phone'] : '' ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="name" name="username" placeholder="Masukkan nama"
                                        value="<?= isset($rowEdit['username']) ? $rowEdit['username'] : '' ?>" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email"
                                        value="<?= isset($rowEdit['email']) ? $rowEdit['email'] : '' ?>" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="address">Alamat</label>
                                    <textarea class="form-control" name="address" placeholder="Masukkan Alamat anda.."><?= isset($rowEdit['address']) ? $rowEdit['address'] : '' ?></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea style="min-height:100px;" name="deskripsi" class="form-control" rows="3"><?= isset($rowEdit['deskripsi']) ? $rowEdit['deskripsi'] : '' ?></textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="phone" class="form-label">No. Telepon</label>
                                    <input type="text" class="form-control" name="phone" placeholder="Masukkan No.Hp"
                                        value="<?= isset($rowEdit['phone']) ? $rowEdit['phone'] : '' ?>" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="inputCompany5">Nama Perusahaan</label>
                                    <input type="text" class="form-control" name="company" placeholder="Nama Perusahaan"
                                        value="<?= isset($rowEdit['company']) ? $rowEdit['company'] : '' ?>">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="level" class="form-label">Level</label>
                                    <select class="form-control" name="id_level" disabled>
                                        <option value=""> -- Add Level -- </option>
                                        <?php while ($rowLevel = mysqli_fetch_assoc($queryLevel)) : ?>
                                            <option value="<?= $rowLevel['id'] ?>"
                                                <?= isset($rowEdit['id_level']) && ($rowLevel['id'] == $rowEdit['id_level']) ? 'selected' : '' ?>>
                                                <?= $rowLevel['level_name'] ?>
                                            </option>
                                        <?php endwhile ?>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="phone" class="form-label">No. Telepon</label>
                                    <input type="text" class="form-control" name="phone" placeholder="Masukkan No.Hp"
                                        value="<?= isset($rowEdit['phone']) ? $rowEdit['phone'] : '' ?>" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="customFile">Ubah Foto Profil</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="profile_picture" name="photo">
                                        <label class="custom-file-label">Pilih File</label>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inputPassword6">Kata Sandi Baru</label>
                                            <input type="password" name="password" class="form-control" value="<?= isset($rowEdit['phone']) ? $rowEdit['phone'] : '' ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-2">Syarat Kata Sandi </p>
                                        <p class="small text-muted mb-2"> Untuk membuat kata sandi baru, Anda harus memenuhi semua persyaratan berikut: </p>
                                        <ul class="small text-muted pl-4 mb-0">
                                            <li> Minimal 8 karakter </li>
                                            <li> Setidaknya satu karakter khusus </li>
                                            <li> Setidaknya satu angka </li>
                                            <li> Tidak boleh sama dengan kata sandi sebelumnya </li>
                                        </ul>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary" name="edit">
                                Simpan Perubahan Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> <!-- / .card -->
</div> <!-- .col-12 -->