<?php
require_once 'admin/controller/koneksi.php';
require_once 'admin/controller/functions.php';

if (isset($_POST['submit'])) {
  $name = mysqli_real_escape_string($config, $_POST['judul']);
  $deskripsi = mysqli_real_escape_string($config, $_POST['deskripsi']);
  $gambar = ($_POST['gambar']);
} else if (isset($_GET['delete'])) {
  $idDelete = $_GET['delete'];
  $query = mysqli_query($config, "DELETE FROM banner WHERE id='$idDelete'");
  header("Location: ?page=slider&delete=success");
  die;
} else if (isset($_GET['edit'])) {
  $idEdit = $_GET['edit'];
  $queryEdit = mysqli_query($config, "SELECT * FROM banner WHERE id='$idEdit'");
  $rowEdit = mysqli_fetch_assoc($queryEdit);

  if (isset($_POST['edit'])) {
    $judul = mysqli_real_escape_string($config, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($config, $_POST['deskripsi']);

    // Ambil gambar lama
    $gambar = $rowEdit['gambar'];

    // Cek jika upload gambar baru
    if (!empty($_FILES['gambar']['name'])) {
      $image_name = $_FILES['gambar']['name'];
      $image_tmp = $_FILES['gambar']['tmp_name'];
      $image_error = $_FILES['gambar']['error'];

      if ($image_error === 0) {
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

        if (in_array($ext, $allowed_ext)) {
          $upload_dir = 'admin/content/uploads/Foto/';
          if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
          }
          $new_image_name = uniqid('menu_', true) . '.' . $ext;
          $upload_path = $upload_dir . $new_image_name;

          if (move_uploaded_file($image_tmp, $upload_path)) {
            $gambar = $new_image_name;
            // Hapus gambar lama jika ada
            if (!empty($rowEdit['gambar']) && file_exists($upload_dir . $rowEdit['gambar'])) {
              unlink($upload_dir . $rowEdit['gambar']);
            }
          }
        }
      }
    }

    mysqli_query($config, "UPDATE banner SET judul='$judul', deskripsi='$deskripsi', gambar='$gambar' WHERE id='$idEdit'");
    header("Location: ?page=slider&edit=success");
    die;
  }
} else if (isset($_POST['add'])) {
  $judul = mysqli_real_escape_string($config, $_POST['judul']);
  $deskripsi = mysqli_real_escape_string($config, $_POST['deskripsi']);
  $gambar = ($_POST['gambar']);
  // Proses upload gambar
  $image_name = $_FILES['gambar']['name'];
  $image_tmp = $_FILES['gambar']['tmp_name'];
  $image_error = $_FILES['gambar']['error'];

  // Lokasi penyimpanan gambar
  $upload_dir = 'admin/content/uploads/Foto/';
  $gambar = ''; // Default jika gagal upload

  if ($image_error === 0) {
    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
    $ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

    if (in_array($ext, $allowed_ext)) {
      $new_image_name = uniqid('menu_', true) . '.' . $ext;
      $upload_path = $upload_dir . $new_image_name;

      // Buat folder jika belum ada
      if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
      }

      // Upload file ke folder
      if (move_uploaded_file($image_tmp, $upload_path)) {
        $gambar = $new_image_name;
      }
    }
  }

  // Simpan ke database
  $queryAdd = mysqli_query($config, "INSERT INTO banner (judul, deskripsi, gambar) VALUES ('$judul', '$deskripsi', '$gambar')");
  header("Location: ?page=slider&add=success");
  die;
}
?>
<div class="container mt-4">
  <div class="card shadow">
    <div class="card-header">
      <h3><?= isset($_GET['edit']) ? 'Edit' : 'Add' ?> Paket</h3>
    </div>
    <div class="card-body">
      <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label class="form-label">Nama</label>
          <input value="<?php echo isset($rowEdit['judul']) ? $rowEdit['judul'] : '' ?>" type="text" name="judul" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Deskripsi</label>
          <textarea id="editor" style="min-height:100px;" name="deskripsi" class="form-control" rows="3"><?php echo isset($rowEdit['deskripsi']) ? $rowEdit['deskripsi'] : '' ?></textarea>
        </div>
        <div class="mb-3">
          <label for="customFile">Upload Gambar</label>
          <div class="custom-file">
            <input name="gambar" type="file" class="custom-file-input" id="customFile" accept=".jpg,.jpeg,.png" <?= isset($_GET['edit']) ? '' : 'required' ?>>
            <label class="custom-file-label" for="customFile">Choose file</label>
            <?php if (!empty($rowEdit['gambar'])): ?>
              <small class="text-muted">Gambar saat ini: <?= $rowEdit['gambar'] ?></small>
            <?php endif; ?>
          </div>
        </div>
        <div class="">
          <button type="submit" class="btn btn-primary btn-s"
            name="<?php echo isset($_GET['edit']) ? 'edit' : 'add' ?>">
            <?php echo isset($_GET['edit']) ? 'Simpan' : 'Add' ?>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>