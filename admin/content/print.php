<?php
include 'admin/controller/koneksi.php';

$id = isset($_GET['order']) ? $_GET['order'] : '';
$queryOrder = mysqli_query($config, "
    SELECT 
        t.id,
        t.id_user,
        t.no_transaction,
        t.sub_total,
        p.nama_produk,
        td.qty,
        td.total
    FROM transactions t
    LEFT JOIN transaction_details td ON t.id = td.id_transaction
    LEFT JOIN produk p ON td.id_product = p.id
    WHERE t.id = '$id'
");


$dataOrder = mysqli_fetch_assoc($queryOrder);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laundry App</title>
    <link rel="icon" type="image/png" href="../../img/logo/logo3.png">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            width: 100vw;
            /* Lebar penuh layar */
            height: 100vh;
            /* Tinggi penuh layar */
            display: flex;
            justify-content: center;
            /* Pusatkan secara horizontal */
            align-items: center;
            /* Pusatkan secara vertikal */
            background-color: #f5f5f5;
            /* Tambahkan warna latar (opsional) */
        }

        .struct {
            border: 1px dashed #000;
            padding: 10px;
            background-color: #fff;
            /* Tambahkan latar belakang putih */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* Tambahkan bayangan (opsional) */
        }


        .struct-header {
            text-align: center;
            margin-bottom: 10px;
        }

        .struct-header img {
            display: block;
            margin: 0 auto 5px;
        }

        .struct-header p {
            margin: 2px 0;
            font-size: 10px;
            /* Perkecil font pada header */
        }

        .order-s {
            text-align: left;
            font-size: 9px;
            /* Perkecil font pada rincian pesanan */
            margin-top: 10px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            font-size: 9px;
            /* Perkecil font pada tabel */
            border-bottom: 1px solid #ddd;
            padding: 3px;
            /* Perkecil padding */
            text-align: left;
        }

        th {
            text-align: center;
            font-weight: bold;
        }

        tfoot td {
            font-size: 9px;
            /* Perkecil font pada bagian footer tabel */
        }

        .struct-footer {
            text-align: center;
            margin-top: 15px;
        }

        .struct-footer p {
            margin: 2px 0;
            font-size: 9px;
            /* Perkecil font pada footer */
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                width: 80mm;
                height: auto;
                display: flex;
                justify-content: center;
                align-items: flex-start;
                background: none;
            }

            .struct {
                border: none;
                margin: 0;
                width: 80mm;
            }

            /* Sembunyikan elemen lain selain .struct */
            body>*:not(.struct) {
                display: none;
            }
        }
    </style>

</head>

<body>
    <div class="struct">
        <div class="struct-header">
            <img src="" alt="" width="50px">
            <p><strong>Waroeng Aceh</strong></p>
            <p>Jl.Tb. Simatupang, RT.011, RW.002, Kel. Susukan, Kec. Ciracas, Jakarta Timur</p>
            <p>0818-0818-0818</p>
        </div>
        <br>
        <div class="order-details">
            <p><strong>Nama Kasir:</strong> <?= $_SESSION['username'] ?></p>
            <p><strong>Kode Produk :</strong> <?= $dataOrder['no_transaction'] ?></p>
            <p><strong>Order Date:</strong> <?= $dataOrder['order_date'] ?></p>
        </div>
        <br>
        <div class="struct-body">
            <table>
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($dataOrder = mysqli_fetch_assoc($queryOrder)) : ?>
                        <tr>
                            <td><?= $dataOrder['nama_produk'] ?></td>
                            <td><?= 'Rp ' . number_format($dataOrder['harga_jual'], 2, ',', '.') ?></td>
                            <td><?= $dataOrder['qty'] ?></td>
                            <td><?= 'Rp ' . number_format($dataOrder['sub_total'], 2, ',', '.') ?></td>
                        </tr>
                    <?php endwhile ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" align="right"><strong>Total Price</strong></td>
                        <td><?= 'Rp ' . number_format($dataOrder['total_price'], 2, ',', ',') ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="right"><strong>Amount Paid</strong></td>
                        <td><?= 'Rp ' . number_format($dataOrder['order_pay'], 2, ',', ',') ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="right"><strong>Amount Change</strong></td>
                        <td><?= 'Rp ' . number_format($dataOrder['order_change'], 2, ',', ',') ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <br>
        <div class="struct-footer">
            <p><strong>Thank You for Your Visit!</strong></p>
            <p><i>"Want to be clean? Just wash it!"</i></p>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>