<?php
include 'admin/controller/administrator-validation.php';
$queryData = mysqli_query($config, "SELECT * FROM karyawan ORDER BY id ASC");
?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header">
            <h5>Data karyawan</h5>
        </div>
        <div class="card-body">
            <div class="button-action">
                 <?php include 'admin/controller/alert-data-crud.php' ?>
                <a href="?page=karyawan/tambah-karyawan" class="btn btn-success btn-sm me-2"> <i class="fe fe-plus fe-16"></i> Tambah</a>
            </div>
            <table class="table table-borderless table-hover mt-3">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>No.Hp</th>
                        <th>Alamat</th>
                        <th>Tanggal Masuk</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($rowData = mysqli_fetch_assoc($queryData)) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= isset($rowData['nama']) ? $rowData['nama'] : '-' ?></td>
                            <td><?= isset($rowData['no_hp']) ? $rowData['no_hp'] : '-' ?></td>
                            <td><?= isset($rowData['alamat']) ? $rowData['alamat'] : '-' ?></td>
                            <td><?= isset($rowData['tgl_masuk']) ? $rowData['tgl_masuk'] : '-' ?></td>
                            <?php $status = karyawan($rowData['status']) ?>
                            <td><?= $status ?></td>
                            <td>
                                <div class="button-action my-3">
                                    <a href="?page=karyawan/tambah-karyawan&edit=<?php echo $rowData['id'] ?>">
                                        <button class="btn btn-info btn-sm ">
                                            <i class="fe fe-edit fe-16"></i>
                                        </button>
                                    </a>
                                    <a onclick="return confirm ('Apakah anda yakin akan menghapus data ini?')"
                                        href="?page=karyawan/tambah-karyawan&delete=<?php echo $rowData['id'] ?>">
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fe fe-trash fe-16"></i>
                                        </button>
                                    </a>
                                </div>

                            </td>
                        </tr>
                    <?php endwhile; // End While 
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>