<?php
include 'admin/controller/administrator-validation.php';
$queryData = mysqli_query($config, "SELECT * FROM customer ORDER BY updated_at DESC");
?>

<div class="container">
    <div class="card shadow" style="border-radius: 20px;">
        <div class="card-header">
            <h5>Data Pelanggan</h5>
        </div>
        <div class="card-body">
            <?php include 'admin/controller/alert-data-crud.php' ?>
            <div align="right" class="button-action">
                <a href="?page=add-pelanggan" class="btn btn-primary btn-sm">Tambah Pelanggan</a>
            </div>
            <table class="table table-borderless table-hover  mt-3 datatable ">
                <thead>
                    <tr class="">
                        <th>No</th>
                        <th>Nama Pelanggan</th>
                        <th>No.Telp</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($rowData = mysqli_fetch_assoc($queryData)) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= isset($rowData['customer_name']) ? $rowData['customer_name'] : '-' ?></td>
                            <td><?= isset($rowData['phone']) ? $rowData['phone'] : '-' ?></td>
                            <td><?= isset($rowData['address']) ? $rowData['address'] : '-' ?></td>
                            <td>
                                <a href="?page=add-pelanggan&edit=<?php echo $rowData['id'] ?>">
                                    <button class="btn btn-secondary btn-sm">Edit
                                    </button>
                                </a>
                                <a onclick="return confirm ('Apakah anda yakin akan menghapus data ini?')"
                                    href="?page=add-pelanggan&delete=<?php echo $rowData['id'] ?>">
                                    <button class="btn btn-danger btn-sm">Hapus
                                    </button>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; // End While 
                    ?>
                </tbody>
            </table>
            <div class="mt-4" align="right">

            </div>
        </div>
    </div>
</div>