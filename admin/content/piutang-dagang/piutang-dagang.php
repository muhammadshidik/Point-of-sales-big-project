<?php
include 'admin/controller/koneksi.php';
include 'admin/controller/administrator-validation.php';

// Ambil data utang
$queryData = mysqli_query($config, "SELECT * FROM utang ORDER BY id ASC");
if (isset($_POST['catat_pembayaran'])) {
    $id_utang = $_POST['id_utang'];
    $bayar_baru = $_POST['sudah_dibayar'];

    $query = mysqli_query($config, "SELECT total, sudah_dibayar FROM utang WHERE id='$id_utang'");
    $row = mysqli_fetch_assoc($query);

    $total = $row['total'];
    $sudah_dibayar_lama = $row['sudah_dibayar'];

    $sudah_dibayar_baru = $sudah_dibayar_lama + $bayar_baru;
    $sisa = $total - $sudah_dibayar_baru;

    // Ubah status jadi angka
    if ($sudah_dibayar_baru == 0) {
        $status = 0; // Belum Bayar
    } elseif ($sisa > 0) {
        $status = 1; // Bayar Sebagian
    } elseif ($sisa == 0) {
        $status = 2; // Lunas
    } else {
        $status = 3; // Kelebihan Bayar
    }

    mysqli_query($config, "UPDATE utang 
        SET sudah_dibayar='$sudah_dibayar_baru', sisa='$sisa', status='$status' 
        WHERE id='$id_utang'");

    header("Location: ?page=piutang-dagang/piutang-dagang&bayar=success");
    exit;
} else if (isset($_GET['delete'])) {
    $idDelete = $_GET['delete'];
    $query = mysqli_query($config, "DELETE FROM utang WHERE id='$idDelete'");
    header("Location: ?page=piutang-dagang/piutang-dagang&delete=success");
    die;
}
?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header">
            <h5>Data utang pelanggan</h5>
        </div>
        <div class="card-body">
            <?php include 'admin/controller/alert-data-crud.php' ?>
            <div class="button-action">
                <a href="?page=piutang-dagang/tambah-piutang-dagang" class="btn btn-primary btn-sm">Tambah Utang</a>
            </div>
            <table class="table table-borderless table-hover mt-3">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Sudah dibayar</th>
                        <th>Sisa</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    while ($rowData = mysqli_fetch_assoc($queryData)) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $rowData['pelanggan'] ?? '-' ?></td>
                            <td><?= 'Rp. ' . number_format($rowData['total'], 0, ',', '.') ?></td>
                            <td><?= 'Rp. ' . number_format($rowData['sudah_dibayar'], 0, ',', '.') ?></td>
                            <td><?= 'Rp. ' . number_format($rowData['sisa'], 0, ',', '.') ?></td>
                            <?php $status = utang($rowData['status']) ?>
                            <td><?= $status ?></td>
                            <td><?= $rowData['tanggal'] ?? '-' ?></td>
                            <td>
                                <!-- Tombol modal Catat Pembayaran -->
                                <button type="button" class="btn btn-success btn-sm"
                                    data-toggle="modal"
                                    data-target="#detailModal<?= $rowData['id'] ?>">
                                    <i class="fe fe-file-text fe-16"></i>
                                </button>

                                <a href="print.php?utang=<?= $rowData['id'] ?>"
                                    target="print_<?= $rowData['id'] ?>"
                                    class="btn btn-warning btn-sm">
                                    <i class="fe fe-printer fe-16"></i>
                                </a>

                                <a href="?page=piutang-dagang/tambah-piutang-dagang&edit=<?= $rowData['id'] ?>"
                                    class="btn btn-secondary btn-sm"><i class="fe fe-edit fe-16"></i></a>

                                <a onclick="return confirm('Apakah anda yakin akan menghapus data ini?')"
                                    href="?page=piutang-dagang/piutang-dagang&delete=<?= $rowData['id'] ?>"
                                    class="btn btn-danger btn-sm"><i class="fe fe-trash fe-16"></i></a>
                            </td>
                        </tr>

                        <!-- Modal untuk tiap baris -->
                        <div class="modal fade" id="detailModal<?= $rowData['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel<?= $rowData['id'] ?>" aria-hidden="true">
                            <div class="modal-dialog modal-md" role="document">
                                <div class="modal-content">
                                    <form method="POST">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Catat Pembayaran</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="id_utang" value="<?= $rowData['id'] ?>">
                                            <div class="mb-3">
                                                <label class="form-label">Bayar Sekarang</label>
                                                <input type="number" name="sudah_dibayar" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="catat_pembayaran" class="btn btn-primary">Simpan</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
$('#modalBayar').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var id = button.data('id')
  var modal = $(this)
  modal.find('#idUtang').val(id)
})
</script>