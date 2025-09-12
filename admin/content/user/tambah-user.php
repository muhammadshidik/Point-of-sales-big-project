<?php
include 'admin/controller/koneksi.php';
include 'admin/controller/administrator-validation.php';

if (isset($_GET['delete'])) {
    $id_user = isset($_GET['delete']) ? $_GET['delete'] : '';
    $queryDelete = mysqli_query($config, "DELETE FROM user WHERE id='$id_user'");


    if ($queryDelete) {
        header("location:?page=user&hapus=berhasil");
    } else {
        header("location:?page=user&hapus=gagal");
    }
}
$id_user = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryEdit = mysqli_query($config, "SELECT * FROM user WHERE id='$id_user'");
$rowEdit = mysqli_fetch_assoc($queryEdit);
// print_r($id_user);
if (isset($_POST['username'])) {
    //ada tidak parameter berusername edit, kalo ada jalankan perintah edit/update, kalo tidak ada tambah data baru/insert
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = isset($_POST['password']) ? $_POST['password'] : $rowEdit['password'];

    if (!isset($_GET['edit'])) {
        $insert = mysqli_query($config, "INSERT INTO user (username, email, password) VALUES('$username','$email','$password')");
        header("location:?page=user&tambah=berhasil");
    } else {
        $Update = mysqli_query($config, "UPDATE user SET username='$name', email='$email', password='$password' WHERE id='$id_user'");
        header("location:?page=user&ubah=berhasil");
    }
}
?>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3><?= isset($_GET['edit']) ? 'Ubah' : 'Tambah' ?> User </h3>
                </div>
                <div class="card-body">
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
                            <input type="submit" class="btn btn-success" name="save">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>