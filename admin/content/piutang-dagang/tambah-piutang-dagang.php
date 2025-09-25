<?php
require_once 'admin/controller/koneksi.php';
require_once 'admin/controller/functions.php';

$queryNoteTrans = mysqli_query($config, "SELECT MAX(id) as id_trans FROM transactions");
$rowNoteTrans = mysqli_fetch_assoc($queryNoteTrans);
$id_trans = $rowNoteTrans['id_trans'];
$id_trans++;

$format_no = "UTG";
$date = date("d/m/y");
$increment_number = sprintf("%03s", $id_trans); //s: string
$kode_utang = $format_no . " : " . $date . "-" . $increment_number;

if (isset($_POST['submit'])) {
    $pelanggan = $_POST['pelanggan'];
    $total = $_POST['total'];
    $sudah_dibayar = $_POST['sudah_dibayar'];
    $sisa = $_POST['sisa'];
    $status = $_POST['status'];
    $tanggal = $_POST['tanggal'];
    $catatan = $_POST['catatan'];
    $kode_utang = $_POST['kode_utang'];
} else if (isset($_GET['delete'])) {
    $idDelete = $_GET['delete'];
    $query = mysqli_query($config, "DELETE FROM utang WHERE id='$idDelete'");
    header("Location: ?page=piutang-dagang/piutang-dagang&delete=success");
    die;
} else if (isset($_GET['edit'])) {
    $idEdit = $_GET['edit'];
    $queryEdit = mysqli_query($config, "SELECT * FROM utang WHERE id='$idEdit'");
    $rowEdit = mysqli_fetch_assoc($queryEdit);

    if (isset($_POST['edit'])) {
        $pelanggan = $_POST['pelanggan'];
        $total = $_POST['total'];
        $sudah_dibayar = $_POST['sudah_dibayar'];
        $sisa = $_POST['sisa'];
        $status = $_POST['status'];
        $tanggal = $_POST['tanggal'];
        $catatan = $_POST['catatan'];
        $kode_utang = $_POST['kode_utang'];
        mysqli_query($config, "UPDATE utang 
        SET pelanggan ='$pelanggan', total ='$total', sudah_dibayar ='$sudah_dibayar', sisa ='$sisa', 
            status ='$status', tanggal='$tanggal', catatan='$catatan', kode_utang = '$kode_utang'
        WHERE id='$idEdit'");
        header("Location: ?page=piutang-dagang/piutang-dagang&edit=success");
        die;
    }
} else if (isset($_POST['add'])) {
    $pelanggan = $_POST['pelanggan'];
    $total = $_POST['total'];
    $sudah_dibayar = $_POST['sudah_dibayar'];
    $sisa = $_POST['sisa'];
    $status = $_POST['status'];
    $tanggal = $_POST['tanggal'];
    $catatan = $_POST['catatan'];
    // Simpan ke database
    $queryAdd = mysqli_query($config, "INSERT INTO utang (pelanggan, total, sudah_dibayar, sisa, status, tanggal, catatan, kode_utang) VALUES ('$pelanggan', '$total','$sudah_dibayar', '$sisa', '$status', '$tanggal', '$catatan', '$kode_utangs')");
    header("Location: ?page=piutang-dagang/piutang-dagang&add=success");
    die;
}
// Ambil data kategori (pastikan queryCategory didefinisikan)

?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header">
            <h5><?= isset($_GET['edit']) ? 'Edit' : 'Add' ?> Daftar Utang</h5>
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group col-md-8">
                    <label class="form-label">No Invoice</label>
                    <input name="kode_utang" value="<?= $kode_utang ?>" type="text" class="form-control" readonly name="kode_utang">
                </div>
                <div class="form-group col-md-8">
                    <label for="simple-select2">Pelanggan</label>
                    <select name="pelanggan" class="form-control select2" id="simple-select2" required>
                        <optgroup label="Pilih Pelanggan">
                            <?php $no = 1 ?>
                            <?php $queryCustomer = mysqli_query($config, "SELECT * FROM customer ORDER BY customer_name ASC"); ?>
                            <?php while ($Customer = mysqli_fetch_assoc($queryCustomer)) : ?>
                                <option value="<?= $Customer['id'] ?>" <?= (isset($rowEdit['customer_name']) && $rowEdit['customer_name'] == $Customer['id']) ? ' selected' : '' ?>>
                                    <?= $no . '. ' . $Customer['customer_name'] ?>
                                    <?php $no++ ?>
                                </option>
                            <?php endwhile; ?>
                        </optgroup>
                    </select>
                </div>
                <input type="hidden" name="sudah_dibayar" value="0">
                <input type="hidden" name="sisa" value="0">
                <div class="form-group col-md-8">
                    <label class="form-label">Total</label>
                    <input type="number" name="total" class="form-control" value="<?= $rowEdit['total'] ?? ''  ?> ">
                </div>
                <div class="form-group col-md-8 mt-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea id="editor" name="catatan" class="form-control summernote" rows="3" style="min-height:100px;"></textarea>
                </div>
                <div class="form-group form-group col-md-8">
                    <label for="simple-select2">Status</label>
                    <select name="status" class="form-control select2" id="simple-select2" required>
                        <optgroup label="Pilih status">
                            <?php $no = 1; ?>
                            <option value="0" <?= (isset($rowEdit['status']) && $rowEdit['status'] == 0) ? ' selected' : '' ?>>
                                <?= $no++ . '. ' . utang(0) ?>
                            </option>
                            <option value="1" <?= (isset($rowEdit['status']) && $rowEdit['status'] == 1) ? ' selected' : '' ?>>
                                <?= $no++ . '. ' . utang(1) ?>
                            </option>
                            <option value="2" <?= (isset($rowEdit['status']) && $rowEdit['status'] == 2) ? ' selected' : '' ?>>
                                <?= $no++ . '. ' . utang(2) ?>
                            </option>
                        </optgroup>
                    </select>

                </div>
                <div class="form-group form-group col-md-8">
                    <label for="simple-select2">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" required value="<?= isset($rowEdit['tanggal']) ? $rowEdit['tanggal'] : '' ?>">
                </div>
                <div class="form-group col-md-8">
                    <button type="submit" class="btn btn-primary" name="<?= isset($_GET['edit']) ? 'edit' : 'add' ?>">
                        <?= isset($_GET['edit']) ? '' : '' ?><i class="fe fe-save fe-16"></i>
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