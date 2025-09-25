<?php
include 'admin/controller/koneksi.php';
$query = mysqli_query($config, "
  SELECT 
    user.username, 
    customer.customer_name, 
    transactions.*
  FROM transactions AS transactions
  LEFT JOIN user AS user
    ON user.id = transactions.id_user
  LEFT JOIN customer AS customer 
    ON customer.id = transactions.id_customer
  ORDER BY transactions.id DESC
");
// 12345, 54321
$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);

if (isset($_GET['delete'])) {
    $idDel = $_GET['delete'];

    $del = mysqli_query($config, "DELETE FROM transactions WHERE id = '$idDel'");
    if ($del) {
        header("location:?page=POS/pos");
        exit();
    }
}

if (isset($_GET['delete'])) {
    $id_user = isset($_GET['delete']) ? $_GET['delete'] : '';
    $queryDelete = mysqli_query($config, "DELETE FROM transactions WHERE id='$id_user'");

    if ($queryDelete) {
        header("location:?page=POS/pos&hapus=berhasil");
    } else {
        header("location:?page=POS/pos&hapus=gagal");
    }
}

$queryUser = mysqli_query($config, "SELECT * FROM user ORDER BY id DESC");
$rowUser = mysqli_fetch_all($queryUser, MYSQLI_ASSOC);

$queryProduct = mysqli_query($config, "SELECT * FROM produk ORDER BY id DESC");
$rowProducts = mysqli_fetch_all($queryProduct, MYSQLI_ASSOC);

$queryPelanggan = mysqli_query($config, "SELECT * FROM customer ORDER BY id DESC");
$rowPelanggan = mysqli_fetch_all($queryPelanggan, MYSQLI_ASSOC);


$queryNoteTrans = mysqli_query($config, "SELECT MAX(id) as id_trans FROM transactions");
$rowNoteTrans = mysqli_fetch_assoc($queryNoteTrans);
$id_trans = $rowNoteTrans['id_trans'];
$id_trans++;

// opsional lain buat nomor transaksi:
// if(mysqli_num_rows($queryNoteTrans) > 0){
//     $id_trans = $rowNoteTrans['id_trans'] + 1;
// }else {
//     $id_trans = 1;
// }

$format_no = "TR";
$date = date("dmy");
$increment_number = sprintf("%03s", $id_trans); //s: string
$no_transaction = $format_no . "-" . $date . "-" . $increment_number;

if (isset($_POST['save'])) {
    $no_transaction = $_POST['no_transaction'];
    $id_user = $_POST['id_user'];
    $id_customer = $_POST['id_customer'];
    $grand_total = $_POST['grand_total'];

    $insTransaction = mysqli_query($config, "INSERT INTO transactions (id_user, id_customer, no_transaction, sub_total) VALUES ('$id_user','$id_customer', '$no_transaction', '$grand_total')");


    if ($insTransaction) {
        $id_transaction = mysqli_insert_id($config);
        $id_products = $_POST['id_product'];
        $qtys = $_POST['qty'];
        $totals = $_POST['total'];

        foreach ($id_products as $key => $id_product) {
            $qty = $qtys[$key];
            $total = $totals[$key];

            $insTransacDetail = mysqli_query($config, "INSERT INTO transaction_details (id_transaction, id_product, qty, total) VALUES ('$id_transaction', '$id_product', '$qty', '$total')");
        }
        header("location:?page=POS/pos");
        exit();
    }
}
?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header">
            <h5>Transaksi</h5>
        </div>
        <div class="card-body">
            <?php include 'admin/controller/alert-data-crud.php'; // Semicolon added 
            ?>
            <div class="button-action">
                <a class="btn btn-success btn-sm" data-toggle="modal" data-target="#defaultModal"> <i class="fe fe-plus fe-16"></i></a>
            </div>
            <!-- table -->
            <table class="table table-borderless table-hover">
                <thead">
                    <tr>
                        <th>No</th>
                        <th>Kode Transaksi</th>
                        <th>Nama Kasir</th>
                        <th>Nama Pembeli</th>
                        <th>Total (Rp)</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($rows as $index => $row): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $row['no_transaction'] ?></td>
                                <td><?= $row['username'] ?></td>
                                <td><?= $row['customer_name'] ?></td>
                                <td><?= "Rp." .  $row['sub_total'] ?></td>
                                <td>
                                    <div class="button-action">
                                        <a href="print.php?utang=<?= $row['id'] ?>"
                                            class="btn btn-primary btn-sm" target="_blank"> <i class="fe fe-printer fe-16"></i></a>
                                        <a onclick="return confirm('Are you sure wanna delete this data??')"
                                            href="?page=POS/pos&delete=<?= $row['id'] ?>"
                                            class="btn btn-danger btn-sm"><i class="fe fe-trash fe-16"></i></a>
                                    </div>

                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
            </table>
            <div class="modal fade bd-example-modal-xl" id="defaultModal" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="verticalModalTitle"> <?php
                                                                                if (isset($_GET['add-user-role'])):
                                                                                    $title = "Add User Role : ";
                                                                                elseif (isset($_GET["edit"])):
                                                                                    $title = "Edit User";
                                                                                else:
                                                                                    $title = "Transaksi";
                                                                                endif;
                                                                                ?> <?= $title ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card-body">
                                <form action="" method="post">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="">Kode Transaksi </label>
                                                <input value="<?= $no_transaction ?>"
                                                    type="text" class="form-control"
                                                    readonly
                                                    name="no_transaction">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Nama Pelanggan</label>
                                                <select name="id_customer" class="form-control select2" id="simple-select2" required>
                                                    <optgroup label="Pilih Pelanggan">
                                                        <?php foreach ($rowPelanggan as $pelanggan) : ?>
                                                            <option value="<?= $pelanggan['id'] ?>" <?= (isset($pelanggan['customer_name']) && $pelanggan['customer_name'] == $pelanggan['id']) ? ' selected' : '' ?>>
                                                                <?= $pelanggan['customer_name'] ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="">Nama Produk</label>
                                                <select name="id_product" id="id_product" class="form-control select2">
                                                    <optgroup label="Pilih Kategori">
                                                        <?php foreach ($rowProducts as $rowProduct): ?>
                                                            <option data-price="<?= $rowProduct['harga_jual'] ?>" value="<?= $rowProduct['id'] ?>">
                                                                <?= $rowProduct['nama_produk'] ?>
                                                            </option>
                                                        <?php endforeach ?>
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="">Nama Kasir </label>
                                                <input value="<?= $_SESSION['username'] ?>"
                                                    type="text" class="form-control"
                                                    readonly>
                                                <input type="hidden" name="id_user" value="<?= $_SESSION['id'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="">Tanggal Transaksi </label>
                                                <input value="<?= date('Y-m-d') ?>"
                                                    type="date" class="form-control"
                                                    readonly>
                                                <input type="hidden" name="tanggal" value="<?= $_SESSION['id'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label>Metode Pembayaran</label>
                                                <select name="status" class="form-control select2" id="simple-select2" required>
                                                    <optgroup label="Pilih status">
                                                        <option value="0" <?= (isset($rowEdit['status']) && $rowEdit['status'] == 0) ? ' selected' : '' ?>>
                                                            <?= pembayaran(0) ?>
                                                        </option>
                                                        <option value="1" <?= (isset($rowEdit['status']) && $rowEdit['status'] == 1) ? ' selected' : '' ?>>
                                                            <?= pembayaran(1) ?>
                                                        </option>
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                            </div>

                            <div align="right" class="mb-3">
                                <button type="button" class="btn btn-success addRow" id="addRow"><i class="fe fe-plus fe-16"></i> </button>
                            </div>
                            <table class="table table-borderless table-hover  mt-3 datatable" id="myTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <br>

                            <p><strong>Total : Rp. <span id="grandTotal"></span></strong></p>
                            <input type="hidden" name="grand_total" id="grandTotalInput" value="0">

                            <div class="mb-3">
                                <label for="uangBayar" class="form-label">Uang Bayar</label>
                                <input type="number" id="uangBayar" class="form-control" placeholder="Masukkan uang pembayaran">
                            </div>

                            <div class="mb-3">
                                <label for="kembalian" class="form-label">Kembalian</label>
                                <input type="text" id="kembalian" class="form-control" readonly>
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary btn-sm" name="save" value=""><i class="fe fe-save fe-16"></i></button>
                            </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn mb-2 btn-secondary btn-sm" data-dismiss="modal"><i class="fe fe-arrow-left fe-16"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    // var, let, const, var: ketika nilainya tidak ada tidak error, kalo let harus mempunyai nilai
    // const: nilainya tidak boleh berubah
    // const nama = "bambang";
    // nama = "reza";
    // const button = document.getElementById('addRow');
    // const button = document.getElementsByClassName('addRow');
    const button = document.querySelector('.addRow');
    const tbody = document.querySelector('#myTable tbody');
    const select = document.querySelector('#id_product');
    // button.textContent = "Duarr";
    // button.style.color = "red";
    const grandTotal = document.getElementById('grandTotal');
    const grandTotalInput = document.getElementById('grandTotalInput');

    let no = 1;
    button.addEventListener("click", function() {

        const selectedProduct = select.options[select.selectedIndex];
        const productValue = selectedProduct.value;
        if (!productValue) {
            alert('Mohon diisi terlebih dahulu!');
            return;
        }
        const productName = selectedProduct.textContent;
        const productPrice = selectedProduct.dataset.price;

        const tr = document.createElement('tr'); //<tr></tr>
        tr.innerHTML = `
        <td>${no}</td>
        <td><input type='hidden' name='id_product[]' class='id_products'>${productName}</td>
        <td>
            <input type='number' name='qty[]' value='1' class='qtys form-control'>
            <input type='hidden' class='priceInput' name='price[]' value='${productPrice}'>
        </td>
        <td><input type='hidden' name='total[]' class='totals' value='${productPrice}'><span class='totalText'>${productPrice}</span></td>
        <td>
            <button class='btn btn-success btn-sm removeRow' type='button'>Hapus</button>
        </td>
        `; //<tr><td></td></tr>

        tbody.appendChild(tr);
        no++;
        select.value = ""; //untuk mengarahkan kembali ke option

        updateGrandTotal();

    });

    tbody.addEventListener('click', function(e) { //e: callback
        if (e.target.classList.contains('removeRow')) {
            e.target.closest("tr").remove();
        }

        updateNumber();
        updateGrandTotal();
    });

    tbody.addEventListener('input', function(e) {
        if (e.target.classList.contains('qtys')) {
            const row = e.target.closest("tr");
            const qty = parseInt(e.target.value) || 0;

            const price = parseInt(row.querySelector('[name="price[]"]').value);
            // const price = 10000;
            row.querySelector('.totalText').textContent = price * qty;
            row.querySelector('.totals').value = price * qty;
            // console.log(price);
            updateGrandTotal();

        }
    });

    function updateNumber() {
        const rows = tbody.querySelectorAll("tr");

        rows.forEach(function(row, index) {
            row.cells[0].textContent = index + 1;
        });

        no = rows.length + 1;
    }

    function updateGrandTotal() {
        const totalCells = tbody.querySelectorAll('.totals');
        let grand = 0;
        totalCells.forEach(function(input) {
            grand += parseInt(input.value) || 0;
        });
        grandTotal.textContent = grand.toLocaleString('id-ID');
        grandTotalInput.value = grand;
    }
    // Hitung kembalian otomatis
    const uangBayar = document.getElementById('uangBayar');
    const kembalian = document.getElementById('kembalian');

    uangBayar.addEventListener('input', function() {
        const bayar = parseInt(this.value) || 0;
        const total = parseInt(grandTotalInput.value) || 0;
        const kembali = bayar - total;

        if (kembali >= 0) {
            kembalian.value = kembali.toLocaleString('id-ID');
        } else {
            kembalian.value = "Uang kurang";
        }
    });
</script>