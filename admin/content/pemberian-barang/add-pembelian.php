<?php
require_once 'admin/controller/koneksi.php';
require_once 'admin/controller/functions.php';

// Auto-generate No Invoice
$queryNote = mysqli_query($config, "SELECT MAX(id_pemberian) as id_trans FROM pemberian_barang");
$rowNote = mysqli_fetch_assoc($queryNote);
$id_trans = $rowNote['id_trans'];
$id_trans++;

$format_no = "INV";
$date = date("dmy");
$increment_number = sprintf("%03s", $id_trans);
$no_invoices = $format_no . "-" . $date . "-" . $increment_number;

// DELETE
if (isset($_GET['delete'])) {
  $idDelete = $_GET['delete'];
  $query = mysqli_query($config, "DELETE FROM pemberian_barang WHERE id_pemberian='$idDelete'");
  header("Location: ?page=pemberian-barang/daftar-pemberian&delete=success");
  die;
}

// EDIT
else if (isset($_GET['edit'])) {
  $idEdit = $_GET['edit'];
  $queryEdit = mysqli_query($config, "SELECT * FROM pemberian_barang WHERE id_pemberian='$idEdit'");
  $rowEdit = mysqli_fetch_assoc($queryEdit);

  if (isset($_POST['edit'])) {
    $tanggal    = $_POST['tanggal'];
    $no_invoice = $_POST['no_invoice'];
    $produk = $_POST['produk'];
    $gudang = $_POST['gudang'];
    $id_supplier = intval($_POST['id_supplier']);
    $total      = floatval($_POST['total']);
    $status     = $_POST['status'];
    $tempo = $_POST['tempo'];
    $pembayaran = $_POST['pembayaran'];
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
    mysqli_query($config, "UPDATE pemberian_barang 
            SET tanggal='$tanggal', no_invoice='$no_invoice',produk='$produk',gudang='$gudang', id_supplier='$id_supplier', 
                total='$total', status='$status', pembayaran='$pembayaran', tempo = '$tempo'
            WHERE id_pemberian='$idEdit'");

    header("Location: ?page=pemberian-barang/daftar-pembelian&edit=success");
    die;
  }
}

// ADD
else if (isset($_POST['add'])) {
  $tanggal    = $_POST['tanggal'];
  $no_invoice = $_POST['no_invoice'];
  $produk = $_POST['produk'];
  $gudang = $_POST['gudang'];
  $id_supplier = intval($_POST['id_supplier']);
  $total      = floatval($_POST['total']);
  $status     = $_POST['status'];
  $pembayaran = $_POST['pembayaran'];
  $tempo = $_POST['tempo'];
  $file = $_POST['file'];
  $queryAdd = mysqli_query($config, "INSERT INTO pemberian_barang 
        (tanggal, no_invoice, produk, gudang, id_supplier, total, status, pembayaran, tempo) 
        VALUES 
        ('$tanggal', '$no_invoice','$produk','$gudang', '$id_supplier', '$total', '$status', '$pembayaran', '$tempo')");

  $image_name = $_FILES['image']['name'];
  $image_tmp = $_FILES['image']['tmp_name'];
  $image_error = $_FILES['image']['error'];

  // Lokasi penyimpanan gambar
  $upload_dir = 'admin/content/uploads/Foto/';
  $gambar = ''; // Default jika gagal upload

  if ($image_error === 0) {
    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];
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

  header("Location: ?page=pemberian-barang/daftar-pembelian&add=success");
  die;
}

// Ambil data supplier & pemberian
$querySupplier = mysqli_query($config, "SELECT * FROM supplier ORDER BY nama_supplier ASC");
$queryPemberian = mysqli_query($config, "
    SELECT pb.*, s.nama_supplier 
    FROM pemberian_barang pb
    LEFT JOIN supplier s ON pb.id_supplier = s.id_supplier
    ORDER BY pb.tanggal DESC
");
$rowEdit = null; // default
?>

<div class="row">
  <div class="col-md-6 my-4">
    <div class="card shadow">
      <div class="card-header">
        <h5><?= isset($_GET['edit']) ? 'Edit' : 'Add' ?> Pemberian Barang</h5>
      </div>
      <div class="card-body">
        <form method="POST">
          <?php if ($rowEdit): ?>
            <input type="hidden" name="id_pemberian" value="<?= $rowEdit['id_pemberian'] ?>">
          <?php endif; ?>

          <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control"
              value="<?= $rowEdit ? $rowEdit['tanggal'] : '' ?>">
          </div>

          <div class="mb-3">
            <label>No Invoice</label>
            <input type="text" readonly name="no_invoice" class="form-control"
              value="<?= $no_invoices ?>">
          </div>
          <div class=" mb-3">
            <label>Produk</label>
            <input type="text" name="produk" class="form-control"
              value="<?= $rowEdit ? $rowEdit['produk'] : '' ?>">
          </div>
          <div class=" mb-3">
            <label>Gudang</label>
            <input type="text" name="gudang" class="form-control"
              value="<?= $rowEdit ? $rowEdit['gudang'] : '' ?>">
          </div>

          <div class=" mb-3">
            <label>Supplier</label>
            <select name="id_supplier" class="form-control">
              <option value="">-- Pilih Supplier --</option>
              <?php
              $supplier = mysqli_query($config, "SELECT * FROM supplier");
              while ($sup = mysqli_fetch_assoc($supplier)) {
                $selected = ($row && $sup['id_supplier'] == $row['id_supplier']) ? "selected" : "";
                echo "<option value='{$sup['id_supplier']}' $selected>{$sup['nama_supplier']}</option>";
              }
              ?>
            </select>
          </div>

          <div class="mb-3" t>
            <label>Tanggal Jatuh Tempo</label>
            <input type="date" name="tempo" class="form-control"
              value="<?= $rowEdit ? $rowEdit['tempo'] : '' ?>">
          </div>

          <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control select2" id="simple-select2" required>
              <optgroup label="Pilih status">
                <option value="0" <?= (isset($rowEdit['status']) && $rowEdit['status'] == 0) ? ' selected' : '' ?>>
                  <?= getStatusList(0) ?>
                </option>
                <option value="1" <?= (isset($rowEdit['status']) && $rowEdit['stok'] == 1) ? ' selected' : '' ?>>
                  <?= getStatusList(1) ?>
                </option>
              </optgroup>
            </select>
          </div>

          <div class="form-group mb-3">
            <label for="customFile">File</label>
            <div class="custom-file">
              <input name="image" type="file" class="custom-file-input" id="customFile" accept=".jpg,.jpeg,.png" <?= isset($_GET['edit']) ? '' : 'required' ?>>
              <label class="custom-file-label" for="customFile">Choose file</label>
              <?php if (!empty($rowEdit['file'])): ?>
                <small class="text-muted">Gambar saat ini: <?= $rowEdit['file'] ?></small>
              <?php endif; ?>
            </div>
          </div>

          <button type="submit" class="btn btn-primary" name="<?= isset($_GET['edit']) ? 'edit' : 'add' ?>">
            <?= isset($_GET['edit']) ? 'Simpan Perubahan' : 'Simpan Perubahan' ?>
          </button>
          <a href="?page=daftar-pembelian" class="btn btn-secondary">Batal</a>
        </form>
      </div>
    </div>
  </div>

<div class="col-md-6 my-4">
  <div class="card shadow">
    <div class="card-header">
      <h5>Penerima & Pembayaran</h5>
    </div>
    <div class="card-body">
      <div class="mb-3">
        <label>Terima Barang</label>
        <select name="status" class="form-control select2" id="simple-select2" required>
          <optgroup label="Pilih status">
            <option value="0" <?= (isset($rowEdit['status']) && $rowEdit['status'] == 0) ? ' selected' : '' ?>>
              <?= getStatusList(0) ?>
            </option>
            <option value="1" <?= (isset($rowEdit['status']) && $rowEdit['stok'] == 1) ? ' selected' : '' ?>>
              <?= getStatusList(1) ?>
            </option>
          </optgroup>
        </select>
      </div>

      <div class="mb-3">
        <label>Pembayaran</label>
        <div align="left" class="mb-3">
          <button type="button" class="btn btn-primary addRow" id="addRow">Tambah Pembayaran</button>
        </div>
        <!-- tempat row pembayaran muncul -->
        <div id="paymentContainer"></div>
      </div>

      <div class="mb-3">
        <label>Catatan</label>
        <textarea id="editor" name="deskripsi" class="form-control summernote" rows="3" style="min-height:100px;"></textarea>
      </div>
    </div>
  </div>
</div>

<script>
const button = document.querySelector('.addRow');
const container = document.querySelector('#paymentContainer');

let no = 1;

button.addEventListener("click", function() {
    const wrapper = document.createElement('div');
    wrapper.classList.add("payment-row", "border", "p-3", "mb-2", "rounded");
    wrapper.innerHTML = `
        <div class="d-flex justify-content-between align-items-center mb-2">
          <strong>Pembayaran ${no}</strong>
          <button type="button" class="btn btn-danger btn-sm removeRow">Hapus</button>
        </div>
        <div class="mb-2">
          <select name="pembayaran[]" class="form-control" required>
            <optgroup label="Pilih pembayaran">
              <option value="0"> <?= pembayaran(0) ?> </option>
              <option value="1"> <?= pembayaran(1) ?> </option>
              <option value="2"> <?= pembayaran(2) ?> </option>
            </optgroup>
          </select>
        </div>
        <div class="mb-2">
          <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah">
        </div>
        <div class="mb-2">
          <input type="text" name="referensi[]" class="form-control" placeholder="Referensi Pembayaran">
        </div>
    `;
    container.appendChild(wrapper);
    no++;
});

// hapus row
container.addEventListener('click', function(e) {
    if (e.target.classList.contains('removeRow')) {
        e.target.closest(".payment-row").remove();
    }
});
</script>


