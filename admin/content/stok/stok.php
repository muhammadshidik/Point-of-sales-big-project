<?php
include 'admin/controller/koneksi.php';
$result = mysqli_query($config, "SELECT * FROM produk");
?>
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h5>Laporan Stok</h5>
        </div>
        <div class="card-body ">
            <table class="table table-borderless table-hover">
                <div class="button-action">
                    <a href="?page=stok/tambah-stok" class="btn btn-success btn-sm"><i class="fe fe-plus fe-16"></i></a>
                </div>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) :
                        $status = ($row['stok'] <= 5)
                            ? "<span class='badge badge-pill badge-warning'>Menipis</span>"
                            : "<span class='badge badge-pill badge-success'>Cukup</span>";
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['nama_produk']; ?></td>
                            <td><?= $row['stok']; ?></td>

                            <td><?= $status; ?></td>
                            <td>
                                <div class="button-action"> 
                                    <a class="btn btn-info btn-sm" href="?page=stok/tambah-stok&edit=<?php echo $row['id'] ?>"><i class="fe fe-edit fe-16"></i>
                                    </a>
                                    <a class="btn btn-danger btn-sm " onclick="return confirm ('Apakah anda yakin akan menghapus data ini?')"
                                        href="?page=stok/tambah-stok&delete=<?php echo $row['id'] ?>"><i class="fe fe-trash fe-16"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>