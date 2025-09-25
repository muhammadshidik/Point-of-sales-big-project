<?php
include 'admin/controller/koneksi.php';
session_start();

$id = isset($_GET['utang']) ? $_GET['utang'] : '';

$queryUtang = mysqli_query($config, "SELECT * FROM utang WHERE id = '$id'");
$dataUtang = mysqli_fetch_assoc($queryUtang);
$queryUser = mysqli_query($config, "SELECT * FROM user WHERE id = '$id'");
$dataUser = mysqli_fetch_assoc($queryUser);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utang</title>
    <link rel="icon" type="image/png" href="../../img/logo/logo3.png">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            width: 100vw;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f5f5f5;
        }

        .struct {
            border: 1px dashed #000;
            padding: 10px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
        }

        .order-details {
            text-align: left;
            font-size: 9px;
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
            border-bottom: 1px solid #ddd;
            padding: 3px;
            text-align: left;
        }

        th {
            text-align: center;
            font-weight: bold;
        }

        tfoot td {
            font-size: 9px;
        }

        .struct-footer {
            text-align: center;
            margin-top: 15px;
        }

        .struct-footer p {
            margin: 2px 0;
            font-size: 9px;
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
                width: 58mm;
                font-size: 9px;
            }

            body>*:not(.struct) {
                display: none;
            }

            @page {
                size: 58mm auto;
                margin: 0;
            }

        }
    </style>

</head>

<body>
    <div class="struct">
        <div class="struct-header">
            <img src="" alt="" width="50px">
            <p><strong>Cv. Al-Ikhlas</strong></p>
            <p>Jl. Tb. Simatupang, RT.011, RW.002, Kel. Susukan, Kec. Ciracas, Jakarta Timur</p>
            <p>0818-0818-0818</p>

            <div class="mt-5">
                <h4>Catatan Hutang</h4>
            </div>

        </div>
        <br>
        <div class="order-details">
            <p><strong>Nama Kasir:</strong> <?= $_SESSION['username'] ?></p>
            <p><strong>Nama Pelanggan:</strong> <?= $dataUtang['pelanggan'] ?? '-' ?></p>
            <p><strong>No Invoice:</strong> <?= $dataUtang['kode_utang'] ?? '-' ?></p>
            <p><strong>Tanggal Ngutang:</strong> <?= $dataUtang['tanggal'] ?? '-' ?></p>
            <p><strong>Status Pembayaran:</strong> <?= $status = utang($dataUtang['status']) ?? '' ?></p>
            <p>Catatan : <?= $dataUtang['catatan'] ?? '-' ?></p>
        </div>
        <br>
        <div class="struct-body">
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th></th>
                        <th></th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $dataUtang['pelanggan'] ?? '-' ?></td>
                        <td></td>
                        <td></td>
                        <td><?= 'Rp ' . number_format($dataUtang['total'] ?? 0, 0, ',', '.') ?></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" align="right"><strong>Nominal Utang</strong></td>
                        <td><?= 'Rp ' . number_format($dataUtang['total'] ?? 0, 0, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="right"><strong>Sudah Dibayar</strong></td>
                        <td><?= 'Rp ' . number_format($dataUtang['sudah_dibayar'] ?? 0, 0, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="right"><strong>Sisa </strong></td>
                        <td><?= 'Rp ' . number_format($dataUtang['sisa'] ?? 0, 0, ',', '.') ?></td>
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
<?php

function utang($status_code)
{
    switch ($status_code) {
        case 0:
            return '<span class="badge badge-pill badge-danger">Belom Bayar</span>';
        case 1:
            return '<span class="badge badge-pill badge-warning">Bayar Sebagian</span>';
        case 2:
            return '<span class="badge badge-pill badge-success">Lunas</span>';
        case 3:
            return '<span class="badge badge-pill badge-primary">Kelebihan dana</span>';
        default:
            return '<span class="bg bg-secondary">Tidak Diketahui</span>';
    }
}



?>