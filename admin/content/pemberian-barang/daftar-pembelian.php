<?php
require_once 'admin/controller/koneksi.php';

// Ambil data pembelian + supplier
$result = mysqli_query($config, "
    SELECT pb.id_pemberian, pb.tanggal, pb.no_invoice, 
           s.nama_supplier, pb.total, 
           pb.status, pb.pembayaran
    FROM pemberian_barang pb
    LEFT JOIN supplier s ON pb.id_supplier = s.id_supplier
    ORDER BY pb.tanggal DESC
");
?>


<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header">
            <h5>Daftar Pembelian</h5>
        </div>
        <div class="card-body">
            <?php include 'admin/controller/alert-data-crud.php'; // Semicolon added 
            ?>
            <a href="?page=pemberian-barang/add-pembelian" class="btn btn-primary mb-3 btn-sm">Tambah</a>
            <!-- table -->
            <table class="table table-borderless table-hover  mt-3">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>No Invoice</th>
                        <th>Supplier</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Pembayaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    // Check if there are any rows returned
                    if (mysqli_num_rows($result) > 0) :
                        while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>
                                <td><?= $row['no_invoice'] ?></td>
                                <td><?= $row['nama_supplier'] ?></td>
                                <td>Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
                                <?php $status = getStatusList($row['status']) ?>
                                <td><?= $status ?></td>
                                <?php $status = pembayaran($row['pembayaran']) ?>
                                <td><?= $status ?></td>
                                <td>
                                    <!-- Tombol Ubah -->
                                    <a href="?page=pemberian-barang/add-pembelian&edit=<?= $row['id_pemberian']; ?>">
                                        <button class="btn btn-secondary btn-sm">
                                            Ubah
                                        </button>
                                    </a>
                                    <!-- Tombol Hapus -->
                                    <a onclick="return confirm('Apakah anda yakin akan menghapus data ini?')"
                                        href="?page=pemberian-barang/daftar-pembelian&delete=<?= $row['id_pemberian']; ?>">
                                        <button class="btn btn-danger btn-sm">
                                            Hapus
                                        </button>
                                    </a>
                                    <button type="button" class="btn btn-primary btn-sm"
                                        data-toggle="modal"
                                        data-target="#detailModal<?= $row['id_pemberian']; ?>">
                                        Detail
                                    </button>

                                </td>

                            </tr>
                            <div class="modal fade" id="detailModal<?= $row['id_pemberian']; ?>" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Detail Pembelian</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6 my-4">
                                                    <div class="card shadow">
                                                        <div class="card-body">
                                                            <h5 class="card-header">Informasi Pembelian</h5>
                                                            <ul class="list-group list-group-flush">
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                    <span>No. Invoice</span>
                                                                    <strong><?= $row['no_invoice']; ?></strong>
                                                                </li>
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                    <span>Tanggal</span>
                                                                    <strong><?= date('d-m-Y', strtotime($row['tanggal'])); ?></strong>
                                                                </li>
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                    <span>Supplier</span>
                                                                    <strong><?= $row['nama_supplier']; ?></strong>
                                                                </li>
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                    <span>Gudang</span>
                                                                    <strong><?= isset($row['gudang']) ? $row['gudang'] : 'Undifined'; ?></strong>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                             
                                                <div class="col-md-6 my-4">
                                                    <div class="card shadow">
                                                        <div class="card-body">
                                                            <h5 class="card-header">Status</h5>
                                                            <ul class="list-group list-group-flush">
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                    <span>Status</span>
                                                                    <span class="badge badge-pill badge-danger">
                                                                        <?= getOrderStatus($row['status']); ?>
                                                                    </span>
                                                                </li>
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                    <span>Pembayaran</span>
                                                                    <span class="badge badge-md bg-success text-light">
                                                                        <?= pembayaran($row['pembayaran']); ?>
                                                                    </span>
                                                                </li>
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                    <span>Dibuat Oleh</span>
                                                                    <strong><?= isset($row['karyawan']) ? $row['karyawan'] : 'Masih dalam proses'; ?></strong>
                                                                </li>
                                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                    <span>Diterima Oleh </span>
                                                                    <strong><?= isset($row['karyawan']) ? $row['karyawan'] : 'Masih dalam proses'; ?></strong>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="card shadow">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Riwayat Pembayaran</h5>
                                                        </div>
                                                        <h5>DUARR</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
        </div>
    </div>
<?php endwhile;
                    else : ?>
<tr>
    <td colspan="8" class="text-center">Data Tidak Ditemukan.</td>
</tr>
<?php endif; ?>
</tbody>
</table>
</div>
</div>
</div>

<script>
    $('#dataTable-1').DataTable({
        autoWidth: true,
        "lengthMenu": [
            [16, 32, 64, -1],
            [16, 32, 64, "All"]
        ]
    });
</script>
<script src="tmp/js/apps.js"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'UA-56159088-1');
</script>