<?php
require_once 'admin/controller/koneksi.php';
require_once 'admin/controller/functions.php';

// Auto-generate No Invoice
$queryNote = mysqli_query($config, "SELECT MAX(id) as id_trans FROM pembelian_barang");
$rowNote = mysqli_fetch_assoc($queryNote);
$id_trans = $rowNote['id_trans'] ?? 0; // antisipasi kalau kosong
$id_trans++;

$format_no = "INV";
$date = date("dmy");
$increment_number = sprintf("%03s", $id_trans);
$no_invoices = $format_no . "-" . $date . "-" . $increment_number;

// DELETE
if (isset($_GET['delete'])) {
  $idDelete = $_GET['delete'];
  $query = mysqli_query($config, "DELETE FROM pembelian_barang WHERE id='$idDelete'");
  header("Location: ?page=pemberian-barang/daftar-pemberian&delete=success");
  die;
}

// EDIT
else if (isset($_GET['edit'])) {
  $idEdit = $_GET['edit'];
  $queryEdit = mysqli_query($config, "SELECT * FROM pembelian_barang WHERE id='$idEdit'");
  $rowEdit = mysqli_fetch_assoc($queryEdit);

  if (isset($_POST['edit'])) {
    $tanggal    = $_POST['tanggal'];
    $no_invoice = $_POST['no_invoice'];
    $produk     = $_POST['produk'];
    $id_supplier = $_POST['id_supplier'];
    $id_karyawan = $_POST['id_karyawan'];
    $total      = isset($_POST['total']) ? array_sum($_POST['total']) : 0;
    $status     = $_POST['status'];
    $tempo      = $_POST['tempo'];
    $pembayaran = $_POST['pembayaran'];

    // Ambil data lama
    $oldFile = $rowEdit['file'] ?? "";

    // Proses upload file baru (jika ada)
    $file = $oldFile; // default pakai lama
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
      $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
      $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
      if (in_array($ext, $allowed_ext)) {
        $upload_dir = 'admin/content/uploads/Foto/';
        if (!is_dir($upload_dir)) {
          mkdir($upload_dir, 0777, true);
        }
        $new_file_name = uniqid('menu_', true) . '.' . $ext;
        $upload_path = $upload_dir . $new_file_name;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
          $file = $new_file_name;
          // Hapus file lama jika ada
          if (!empty($oldFile) && file_exists($upload_dir . $oldFile)) {
            unlink($upload_dir . $oldFile);
          }
        }
      }
    }

    // UPDATE
    mysqli_query($config, "UPDATE pembelian_barang 
            SET tanggal='$tanggal', no_invoice='$no_invoice', id_supplier='$id_supplier', id_karyawan='$id_karyawan',
                produk='$produk', total='$total', status='$status', pembayaran='$pembayaran', tempo='$tempo', file='$file'
            WHERE id='$idEdit'");

    header("Location: ?page=pemberian-barang/daftar-pembelian&edit=success");
    die;
  }
}

// ADD
else if (isset($_POST['add'])) {
  $tanggal    = $_POST['tanggal'];
  $no_invoice = $_POST['no_invoice'];
  $id_supplier = $_POST['id_supplier'];
  $id_karyawan = $_POST['id_karyawan'];
  $produk     = $_POST['produk'];
  $tempo      = $_POST['tempo'];
  $status     = $_POST['status'];
  $pembayaran = isset($_POST['pembayaran']) ? implode(",", $_POST['pembayaran']) : "";
  $total      = isset($_POST['total']) ? array_sum($_POST['total']) : 0;

  // Proses upload file
  $file = "";
  if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    if (in_array($ext, $allowed_ext)) {
      $upload_dir = 'admin/content/uploads/Foto/';
      if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
      }
      $new_file_name = uniqid('menu_', true) . '.' . $ext;
      $upload_path = $upload_dir . $new_file_name;
      if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
        $file = $new_file_name;
      }
    }
  }

  // INSERT
  $queryAdd = mysqli_query($config, "INSERT INTO pembelian_barang 
      (tanggal, no_invoice, id_supplier, id_karyawan, produk, tempo, status, pembayaran, total, file) 
      VALUES 
      ('$tanggal', '$no_invoice','$id_supplier','$id_karyawan','$produk', '$tempo', '$status', '$pembayaran', '$total', '$file')");

  header("Location: ?page=pemberian-barang/daftar-pembelian&add=success");
  die;
}

// Ambil data supplier & pemberian
$querySupplier = mysqli_query($config, "SELECT * FROM supplier ORDER BY nama_supplier ASC");
$rowSupplier = mysqli_fetch_all($querySupplier, MYSQLI_ASSOC);

$queryKaryawan = mysqli_query($config, "SELECT * FROM karyawan ORDER BY nama ASC");
$rowKaryawan = mysqli_fetch_all($queryKaryawan, MYSQLI_ASSOC);

$queryPemberian = mysqli_query($config, "
    SELECT pb.*, s.nama_supplier, k.nama
    FROM pembelian_barang pb
    LEFT JOIN supplier s ON pb.id = s.id
    LEFT JOIN karyawan k ON pb.id = k.id
    ORDER BY pb.tanggal DESC
");

$queryProduk = mysqli_query($config, "SELECT * FROM produk ORDER BY nama_produk ASC");
$rowProducts = mysqli_fetch_all($queryProduk, MYSQLI_ASSOC);

$rowEdit = $rowEdit ?? null; // default
?>


<div class="row">
  <div class="col-md-12 my-4">
    <div class="card shadow">
      <div class="card-header">
        <h5><?= isset($_GET['edit']) ? 'Edit' : 'Add' ?> Pemberian Barang</h5>
      </div>
      <div class="card-body">
        <!-- FORM MULAI -->
        <form method="POST" enctype="multipart/form-data">

          <div class="row">
            <!-- === KIRI === -->
            <div class="col-md-6">
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
                <select name="produk" id="id_product" class="form-control select2">
                  <optgroup label="Pilih Kategori">
                    <?php foreach ($rowProducts as $rowProduct): ?>
                      <option value="<?php echo $rowProduct['nama_produk'] ?>">
                        <?php echo $rowProduct['nama_produk'] ?>
                      </option>
                    <?php endforeach ?>
                  </optgroup>
                </select>
              </div>

              <div class=" mb-3">
                <label>Supplier</label>
                <select name="id_supplier" class="form-control select2">
                  <optgroup label="Pilih Kategori">
                    <?php foreach ($rowSupplier as $rowSuppliers): ?>
                      <option value="<?php echo $rowSuppliers['id'] ?>">
                        <?php echo $rowSuppliers['nama_supplier'] ?>
                      </option>
                    <?php endforeach ?>
                  </optgroup>
                </select>
              </div>

              <div class="mb-3">
                <label>Tanggal Jatuh Tempo</label>
                <input type="date" name="tempo" class="form-control"
                  value="<?= $rowEdit ? $rowEdit['tempo'] : '' ?>">
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
            </div>

            <!-- === KANAN === -->
            <div class="col-md-6">
              <div class="mb-3">
                <label>Terima Barang</label>
                <select name="status" class="form-control select2" id="simple-select2" required>
                  <optgroup label="Pilih status">
                    <option value="Diterima" <?= getOrderStatus(isset($rowEdit['status']) && $rowEdit['status'] == "Diterima") ? ' selected' : '' ?>>
                      Diterima
                    </option>
                    <option value="Ditolak" <?= getOrderStatus(isset($rowEdit['status']) && $rowEdit['status'] == "Ditolak") ? ' selected' : '' ?>>
                      Ditolak
                    </option>
                  </optgroup>
                </select>
              </div>


              <div class="mb-3">
                <label>Penerima Barang</label>
                <select name="id_karyawan" class="form-control select2">
                  <optgroup label="Pilih Kategori">
                    <?php foreach ($rowKaryawan as $rowKaryawans): ?>
                      <option value="<?php echo $rowKaryawans['id'] ?>">
                        <?php echo $rowKaryawans['nama'] ?>
                      </option>
                    <?php endforeach ?>
                  </optgroup>
                </select>
              </div>

              <div class="mb-3">
                <label>Pembayaran</label>
                <div align="left" class="mb-3">
                  <button type="button" class="btn btn-success btn-sm addRow" id="addRow">
                    <i class="fe fe-plus fe-16"></i>
                  </button>
                </div>
                <div id="paymentContainer"></div>
              </div>

              <div class="mb-3">
                <label>Catatan</label>
                <textarea id="editor" name="deskripsi" class="form-control summernote" rows="3" style="min-height:100px;"></textarea>
              </div>
            </div>
          </div>

          <!-- SUBMIT BUTTON -->
          <button type="submit" class="btn btn-primary" name="<?= isset($_GET['edit']) ? 'edit' : 'add' ?>">
            <i class="fe fe-save fe-16"></i>
          </button>
          <a href="?page=daftar-pembelian" class="btn btn-secondary">
            <i class="fe fe-arrow-left fe-16"></i>
          </a>

        </form>
        <!-- FORM SELESAI -->
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
              <option value="Tempo"> <?= pembayaran("Tempo") ?> </option>
              <option value="Transfer"> <?= pembayaran("Transfer") ?> </option>
              <option value="Tunai"> <?= pembayaran("Tunai") ?> </option>
            </optgroup>
          </select>
        </div>
        <div class="mb-2">
          <input type="number" name="total[]" class="form-control" placeholder="Jumlah">
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