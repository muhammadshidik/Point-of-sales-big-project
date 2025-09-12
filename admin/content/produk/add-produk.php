<?php
require_once 'admin/controller/koneksi.php';
require_once 'admin/controller/functions.php';

$queryNoteTrans = mysqli_query($config, "SELECT MAX(id) as id_trans FROM transactions");
$rowNoteTrans = mysqli_fetch_assoc($queryNoteTrans);
$id_trans = $rowNoteTrans['id_trans'];
$id_trans++;

$format_no = "SKU";
$date = date("dmy");
$increment_number = sprintf("%03s", $id_trans); //s: string
$kode_produk = $format_no . " : " . $date . "-" . $increment_number;

if (isset($_POST['submit'])) {
  $name = mysqli_real_escape_string($config, $_POST['nama_produk']);
  $deskripsi = $_POST['deskripsi'];
  $harga_jual = floatval($_POST['harga_jual']);
  $stok = $_POST['stok'];
  $gambar = ($_POST['gambar']);
  $kode_produk = $_POST['kode_produk'];
} else if (isset($_GET['delete'])) {
  $idDelete = $_GET['delete'];
  $query = mysqli_query($config, "DELETE FROM produk WHERE id='$idDelete'");
  header("Location: ?page=produk/produk&delete=success");
  die;
} else if (isset($_GET['edit'])) {
  $idEdit = $_GET['edit'];
  $queryEdit = mysqli_query($config, "SELECT * FROM produk WHERE id='$idEdit'");
  $rowEdit = mysqli_fetch_assoc($queryEdit);

  if (isset($_POST['edit'])) {
    $nama_produk = mysqli_real_escape_string($config, $_POST['nama_produk']);
    $deskripsi =  $_POST['deskripsi'];
    $harga_jual = floatval($_POST['harga_jual']);
    $stok = $_POST['stok'];
    $kategori_id = intval($_POST['kategori_id']);
    $id_unit  = $_POST['id_unit'];


    // Ambil data lama
    $oldImage = $rowEdit['gambar'];

    // Proses upload gambar baru (jika ada)
    $gambar = $oldImage; // default gambar lama
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
      $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
      $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
      if (in_array($ext, $allowed_ext)) {
        $upload_dir = 'admin/content/uploads/Foto/';
        if (!is_dir($upload_dir)) {
          mkdir($upload_dir, 0777, true);
        }
        $new_image_name = uniqid('menu_', true) . '.' . $ext;
        $upload_path = $upload_dir . $new_image_name;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
          $gambar = $new_image_name;
          // Hapus gambar lama jika ada
          if (!empty($oldImage) && file_exists($upload_dir . $oldImage)) {
            unlink($upload_dir . $oldImage);
          }
        }
      }
    }


    mysqli_query($config, "UPDATE produk 
        SET nama_produk='$nama_produk', kode_produk='$kode_produk',  deskripsi='$deskripsi', harga_jual='$harga_jual', 
            kategori_id='$kategori_id',id_unit='$id_unit', stok='$stok', gambar='$gambar' 
        WHERE id='$idEdit'");
    header("Location: ?page=produk/produk&edit=success");
    die;
  }
} else if (isset($_POST['add'])) {
  $nama_produk = $_POST['nama_produk'];
  $deskripsi = $_POST['deskripsi'];
  $harga_jual = floatval($_POST['harga_jual']);
  $stok = $_POST['stok'];
  $kode_produk = $_POST['kode_produk'];
  $kategori_id  = $_POST['kategori_id'];
  $id_unit  = $_POST['id_unit'];
  // Proses upload gambar
  $image_name = $_FILES['image']['name'];
  $image_tmp = $_FILES['image']['tmp_name'];
  $image_error = $_FILES['image']['error'];

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
  $queryAdd = mysqli_query($config, "INSERT INTO produk (nama_produk, kode_produk, deskripsi, harga_jual, kategori_id, id_unit, stok, gambar) VALUES ('$nama_produk', '$kode_produk','$deskripsi', '$harga_jual', '$kategori_id', '$id_unit', '$stok', '$gambar')");
  header("Location: ?page=produk/produk&add=success");
  die;
}
// Ambil data kategori (pastikan queryCategory didefinisikan)
$queryCategory = mysqli_query($config, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
$queryProduk = mysqli_query($config, "SELECT * FROM produk ORDER BY nama_produk ASC");
$queryUnit = mysqli_query($config, "SELECT * FROM unit ORDER BY nama_unit ASC");
?>

<div class="container mt-4">
  <div class="card shadow">
    <div class="card-header">
      <h3><?= isset($_GET['edit']) ? 'Edit' : 'Add' ?> Produk</h3>
    </div>
    <div class="card-body">
      <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label class="form-label">Nama Produk</label>
          <input type="text" name="nama_produk" class="form-control" required value="<?= $rowEdit['nama_produk'] ?? '' ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">kode Produk</label>
          <input value="<?php echo $kode_produk ?>" type="text" class="form-control" readonly name="kode_produk">
        </div>
        <div class="mb-3 mt-3">
          <label class="form-label">Deskripsi</label>
          <textarea id="editor" name="deskripsi" class="form-control summernote" rows="3" style="min-height:100px;"></textarea>
        </div>
        <div class="form-group mb-3">
          <label for="simple-select2">Kategori</label>
          <select name="kategori_id" class="form-control select2" id="simple-select2" required>
            <optgroup label="Pilih Kategori">
              <?php while ($kategori = mysqli_fetch_assoc($queryCategory)) : ?>
                <option value="<?= $kategori['id'] ?>" <?= (isset($rowEdit['kategori_id']) && $rowEdit['kategori_id'] == $kategori['id']) ? ' selected' : '' ?>>
                  <?= $kategori['nama_kategori'] ?>
                </option>
              <?php endwhile; ?>
            </optgroup>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Harga</label>
          <input type="number" name="harga_jual" class="form-control" required value="<?= $rowEdit['harga_jual'] ?? '' ?>">
        </div>

        <div class="form-group mb-3">
          <label for="simple-select2">Unit</label>
          <select name="id_unit" class="form-control select2" id="simple-select2" required>
            <optgroup label="Pilih Unit">
              <?php while ($unit = mysqli_fetch_assoc($queryUnit)) : ?>
                <option value="<?= $unit['id'] ?>" <?= (isset($rowEdit['id_unit']) && $rowEdit['id_unit'] == $unit['id']) ? ' selected' : '' ?>>
                  <?= $unit['nama_unit'] ?>
                </option>
              <?php endwhile; ?>
            </optgroup>
          </select>
        </div>

        <div class="form-group mb-3">
          <label for="simple-select2">Stok</label>
          <input type="number" name="stok" class="form-control" required value="<?= $rowEdit['stok'] ?? '' ?>">
        </div>
        <div class="form-group mb-3">
          <label for="customFile">Upload Gambar</label>
          <div class="custom-file">
            <input name="image" type="file" class="custom-file-input" id="customFile" accept=".jpg,.jpeg,.png" <?= isset($_GET['edit']) ? '' : 'required' ?>>
            <label class="custom-file-label" for="customFile">Choose file</label>
            <?php if (!empty($rowEdit['gambar'])): ?>
              <small class="text-muted">Gambar saat ini: <?= $rowEdit['gambar'] ?></small>
            <?php endif; ?>
          </div>
        </div>
        <div>
          <button type="submit" class="btn btn-primary" name="<?= isset($_GET['edit']) ? 'edit' : 'add' ?>">
            <?= isset($_GET['edit']) ? 'Simpan Perubahan' : 'Tambah Produk' ?>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  // editor
  if (editor) {
    var quill = new Quill(editor, {
      modules: {
        toolbar: toolbarOptions
      },
      theme: 'snow'
    });

    // SIMPAN DATA KE HIDDEN INPUT
    document.querySelector('form').addEventListener('submit', function() {
      document.getElementById('hidden-deskripsi').value = quill.root.innerHTML;
    });
  }

  var editor = document.getElementById('editor');
  if (editor) {
    var toolbarOptions = [
      [{
        'font': []
      }],
      [{
        'header': [1, 2, 3, 4, 5, 6, false]
      }],
      ['bold', 'italic', 'underline', 'strike'],
      ['blockquote', 'code-block'],
      [{
          'header': 1
        },
        {
          'header': 2
        }
      ],
      [{
          'list': 'ordered'
        },
        {
          'list': 'bullet'
        }
      ],
      [{
          'script': 'sub'
        },
        {
          'script': 'super'
        }
      ],
      [{
          'indent': '-1'
        },
        {
          'indent': '+1'
        }
      ], // outdent/indent
      [{
        'direction': 'rtl'
      }], // text direction
      [{
          'color': []
        },
        {
          'background': []
        }
      ], // dropdown with defaults from theme
      [{
        'align': []
      }],
      ['clean'] // remove formatting button
    ];
    var quill = new Quill(editor, {
      modules: {
        toolbar: toolbarOptions
      },
      theme: 'snow'
    });
  }
</script>

<link rel="stylesheet" href="css/quill.snow.css">

<script src='tmp/js/quill.min.js'></script>
<script src="tmp/js/config.js"></script>