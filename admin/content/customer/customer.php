<?php
include 'admin/controller/administrator-validation.php';
$queryData = mysqli_query($config, "SELECT * FROM customer ORDER BY updated_at DESC");
?>
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header">
            <h5>Data Pelanggan</h5>
        </div>
        <div class="card-body">
            <?php include 'admin/controller/alert-data-crud.php' ?>
            <div align="left" class="button-action">
                <a href="?page=customer/add-customer" class="btn btn-primary btn-sm">Tambah Pelanggan</a>
            </div>
              <table class="table table-borderless table-hover  mt-3 datatable">
                    <thead class="table-dark" >
                    <tr>
                        <th>No</th>
                        <th>Nama Customer</th>
                        <th>No. Handphone</th>
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
                                <a href="?page=customer/add-customer&edit=<?php echo $rowData['id'] ?>">
                                    <button class="btn btn-success btn-sm">Edit
                                    </button>
                                </a>
                                <a onclick="return confirm ('Apakah anda yakin akan menghapus data ini?')"
                                    href="?page=customer/add-customer&delete=<?php echo $rowData['id'] ?>">
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