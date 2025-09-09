<?php
include 'admin/controller/koneksi.php';
$query = mysqli_query($config, "
  SELECT 
    u.username, 
    c.customer_name, 
    t.*
  FROM transactions AS t
  LEFT JOIN user AS u 
    ON u.id = t.id_user
  LEFT JOIN customer AS c 
    ON c.id = t.id
  ORDER BY t.id DESC
");
// 12345, 54321
$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);

if (isset($_GET['delete'])) {
    $idDel = $_GET['delete'];

    $del = mysqli_query($config, "DELETE FROM transactions WHERE id = '$idDel'");
    if ($del) {
        header("location:?page=pos");
        exit();
    }
}
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Data Transaction</h5>
                <div align="right" class="mb-3">
                    <a href="?page=tambah-pos" class="btn btn-primary">Tambah Transaksi</a>
                </div>
                <table class="table table-borderless table-hover  mt-3 datatable">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Kode Transaksi</th>
                            <th>Nama Kasir</th>
                            <th>Total (Rp)</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($rows as $index => $row): ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $row['no_transaction'] ?></td>
                                <td><?php echo $row['username'] ?></td>
                                <td><?php echo "Rp." .  $row['sub_total'] ?></td>
                                <td>
                                    <a href="?page=print&=<?php echo $row['id'] ?>"
                                        class="btn btn-primary" target="_blank">Print</a>
                                    <a onclick="return confirm('Are you sure wanna delete this data??')"
                                        href="?page=pos&delete=<?php echo $row['id'] ?>"
                                        class="btn btn-danger">Delete</a>

                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>