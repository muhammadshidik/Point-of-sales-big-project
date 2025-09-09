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
    header("Location: ?page=pemberian&delete=success");
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
        $id_supplier= intval($_POST['id_supplier']);
        $total      = floatval($_POST['total']);
        $status     = $_POST['status'];
        $pembayaran = $_POST['pembayaran'];

        mysqli_query($config, "UPDATE pemberian_barang 
            SET tanggal='$tanggal', no_invoice='$no_invoice', id_supplier='$id_supplier', 
                total='$total', status='$status', pembayaran='$pembayaran'
            WHERE id_pemberian='$idEdit'");

        header("Location: ?page=pemberian&edit=success");
        die;
    }
}

// ADD
else if (isset($_POST['add'])) {
    $tanggal    = $_POST['tanggal'];
    $no_invoice = $_POST['no_invoice'];
    $id_supplier= intval($_POST['id_supplier']);
    $total      = floatval($_POST['total']);
    $status     = $_POST['status'];
    $pembayaran = $_POST['pembayaran'];

    $queryAdd = mysqli_query($config, "INSERT INTO pemberian_barang 
        (tanggal, no_invoice, id_supplier, total, status, pembayaran) 
        VALUES 
        ('$tanggal', '$no_invoice', '$id_supplier', '$total', '$status', '$pembayaran')");

    header("Location: ?page=pemberian&add=success");
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

function getStatusList() {
    return [
        0 => 'Tersedia',
        1 => 'Barang Kosong',
        2 => 'Pending'
    ];
}
$rowEdit = null; // default
?>

<div class="container mt-4">
  <div class="card shadow">
    <div class="card-header">
      <h3><?= isset($_GET['edit']) ? 'Edit' : 'Add' ?> Produk</h3>
    </div>
    <div class="card-body">
        <form method="POST">
    <?php if ($rowEdit): ?>
        <input type="hidden" name="id_pemberian" value="<?= $rowEdit['id_pemberian'] ?>">
    <?php endif; ?>

    <div class="mb-3">
        <label>Tanggal</label>
        <input type="date" name="tanggal" class="form-control"
               value="<?= $rowEdit ? $rowEdit['tanggal'] : '' ?>" required>
    </div>

    <div class="mb-3">
        <label>No Invoice</label>
        <input type="text"readonly name="no_invoice" class="form-control"
               value="<?= $no_invoices ?>"
" required>
    </div>

    <div class="mb-3">
        <label>Supplier</label>
        <select name="id_supplier" class="form-control" required>
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

    <div class="mb-3">
        <label>Total</label>
        <input type="number" name="total" class="form-control"
               value="<?= $row ['total']?>" required>
    </div>

    <div class="mb-3">
    <label>Status</label>
    <select name="status" class="form-control" required>
        <option value="">-- Pilih Status --</option>
        <?php foreach (getStatusList() as $key => $label): ?>
            <option value="<?= $key ?>" <?= ($rowEdit && $rowEdit['status'] == $key) ? 'selected' : '' ?>>
                <?= $label ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>


    <div class="mb-3">
        <label>Pembayaran</label>
        <input type="text" name="pembayaran" class="form-control"
               value="<?= $row ? $row['pembayaran'] : '' ?>">
    </div>

    <button type="submit" name="<?= $row ? "edit" : "add" ?>" class="btn btn-primary">Simpan</button>
    <a href="?page=pembelian" class="btn btn-secondary">Batal</a>

        <!-- Tombol Submit -->
        <div class="mt-3">
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
    modules: { toolbar: toolbarOptions },
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















<!-- Modal Add -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pemberian Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>No Invoice</label>
                        <input type="text" name="no_invoice" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Supplier</label>
                        <select name="id_supplier" class="form-control" required>
                            <option value="">-- Pilih Supplier --</option>
                            <?php
                            $supplier = mysqli_query($config, "SELECT * FROM supplier");
                            while ($sup = mysqli_fetch_assoc($supplier)) {
                                echo "<option value='{$sup['id_supplier']}'>{$sup['nama_supplier']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Total</label>
                        <input type="number" name="total" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <input type="text" name="status" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Pembayaran</label>
                        <input type="text" name="pembayaran" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="add" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
