<?php
include 'admin/controller/koneksi.php';

// Query ambil semua data utang
$queryUtang = mysqli_query($config, "SELECT * FROM utang ORDER BY id DESC");
$rowUtang = mysqli_fetch_all($queryUtang, MYSQLI_ASSOC);

// Query total semua utang
$queryTotal = mysqli_query($config, "SELECT SUM(total) as total_utang FROM utang");
$rowTotal = mysqli_fetch_assoc($queryTotal);
$totalUtang = $rowTotal['total_utang'] ?? 0;


// Query total keseluruhan omset
$queryOmset = mysqli_query($config, "
    SELECT SUM(sub_total) as total_omset 
    FROM transactions
");
$rowOmset = mysqli_fetch_assoc($queryOmset);
$totalOmset = $rowOmset['total_omset'] ?? 0;

// Hitung jumlah customer
$queryCustomer = mysqli_query($config, "SELECT COUNT(*) as total_customer FROM customer");
$rowCustomer = mysqli_fetch_assoc($queryCustomer);
$totalCustomer = $rowCustomer['total_customer'] ?? 0;

$queryPendapatan = mysqli_query($config, "
  SELECT 
    MONTH(created_at) as bulan,
    SUM(sub_total) as total_pendapatan
  FROM transactions
  WHERE YEAR(created_at) = 2025
  GROUP BY MONTH(created_at)
  ORDER BY bulan ASC
");

$pendapatanPerBulan = [];
while ($row = mysqli_fetch_assoc($queryPendapatan)) {
  $pendapatanPerBulan[$row['bulan']] = $row['total_pendapatan'];
}


$queryPendapatan = mysqli_query($config, "
  SELECT 
    DATE(t.created_at) as tanggal,
    c.customer_name, t.no_transaction, t.status,
    SUM(t.sub_total) as total_pendapatan
  FROM transactions t
  LEFT JOIN customer c ON t.id_customer = c.id
  WHERE YEAR(t.created_at) = 2025
  GROUP BY DATE(t.created_at), c.customer_name
  ORDER BY tanggal ASC
");

$rows = [];
while ($row = mysqli_fetch_assoc($queryPendapatan)) {
    $rows[] = $row;
}
?>

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-12">
      <div class="row align-items-center mb-2">
        <div class="col">
          <h2 class="h5 page-title">Dashboard</h2>
        </div>
        <div class="col-auto">
          <form class="form-inline">
            <div class="form-group d-none d-lg-inline">
              <label for="reportrange" class="sr-only">Date Ranges</label>
              <div id="reportrange" class="px-2 py-2 text-muted">
                <span class="small"></span>
              </div>
            </div>
            <div class="form-group">
              <button type="button" class="btn btn-sm"><span class="fe fe-refresh-ccw fe-16 text-muted"></span></button>
              <button type="button" class="btn btn-sm mr-2"><span class="fe fe-filter fe-16 text-muted"></span></button>
            </div>
          </form>
        </div>
      </div>

      <!-- .row -->
      <div class="row">
        <div class="col-md-6 col-xl-3 mb-4">
          <div class="card shadow  text-white">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-3 text-center">
                  <span class="circle circle-sm bg-primary">
                    <i class="fe fe-16 fe-shopping-bag text-white mb-0"></i>
                  </span>
                </div>
                <div class="col pr-0">
                  <p class="small text-muted mb-0">Total utang Hari ini </p>
                  <span class="h3 mb-0 text-white">
                    <?= 'Rp. ' . number_format($totalUtang, 0, ',', '.') ?>
                  </span>
                  <span class="small text-muted">+5.5%</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-xl-3 mb-4">
          <div class="card shadow  text-white">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-3 text-center">
                  <span class="circle circle-sm bg-primary">
                    <i class="fe fe-16 fe-shopping-bag text-white mb-0"></i>
                  </span>
                </div>
                <div class="col pr-0">
                  <p class="small text-muted mb-0">Total Omset Hari ini </p>
                  <span class="h3 mb-0 text-white">
                    <?= 'Rp. ' . number_format($totalOmset, 0, ',', '.') ?>
                  </span>


                  <span class="small text-muted">+5.5%</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-xl-3 mb-4">
          <div class="card shadow  text-white">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-3 text-center">
                  <span class="circle circle-sm bg-primary">
                    <i class="fe fe-16 fe-shopping-bag text-white mb-0"></i>
                  </span>
                </div>
                <div class="col pr-0">
                  <p class="small text-muted mb-0">Total Omset bulanan </p>
                  <span class="h3 mb-0 text-white">
                    Duarr
                  </span>
                  <span class="small text-muted">+5.5%</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-xl-3 mb-4">
          <div class="card shadow">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-3 text-center">
                  <span class="circle circle-sm bg-primary">
                    <i class="fe fe-16 fe-shopping-cart text-white mb-0"></i>
                  </span>
                </div>
                <div class="col pr-0">
                  <p class="small text-muted mb-0">Orders</p>
                  <span class="h3 mb-0">1,869</span>
                  <span class="small text-success">+16.5%</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-xl-3 mb-4">
          <div class="card shadow">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-3 text-center">
                  <span class="circle circle-sm bg-primary">
                    <i class="fe fe-16 fe-filter text-white mb-0"></i>
                  </span>
                </div>
                <div class="col">
                  <p class="small text-muted mb-0">Conversion</p>
                  <div class="row align-items-center no-gutters">
                    <div class="col-auto">
                      <span class="h3 mr-2 mb-0"> 86.6% </span>
                    </div>
                    <div class="col-md-12 col-lg">
                      <div class="progress progress-sm mt-2" style="height:3px">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 87%" aria-valuenow="87" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-xl-3 mb-4">
          <div class="card shadow">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-3 text-center">
                  <span class="circle circle-sm bg-primary">
                    <i class="fe fe-16 fe-activity text-white mb-0"></i>
                  </span>
                </div>
                <div class="col">
                  <p class="small text-muted mb-0">AVG Orders</p>
                  <span class="h3 mb-0">$80</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


      <div class="row">
        <div class="col-md-4 mb-4">
          <div class="card shadow">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col">
                  <span class="h2 mb-0"> <?= $totalCustomer ?></span>
                  <p class="small text-muted mb-0">Customers</p>
                  <span class="badge badge-pill badge-warning">+1.5%</span>
                </div>
                <div class="col-auto">
                  <span class="fe fe-32 fe-users text-muted mb-0"></span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="card shadow">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col">
                  <span class="h2 mb-0">$1.2K</span>
                  <p class="small text-muted mb-0">Monthly Sales</p>
                  <span class="badge badge-pill badge-success">+15.5%</span>
                </div>
                <div class="col-auto">
                  <span class="fe fe-32 fe-shopping-bag text-muted mb-0"></span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="card shadow">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col">
                  <span class="h2 mb-0">1K+</span>
                  <p class="small text-muted mb-0">Orders</p>
                  <span class="badge badge-pill badge-success">+16.5%</span>
                </div>
                <div class="col-auto">
                  <span class="fe fe-32 fe-clipboard text-muted mb-0"></span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> <!-- .row-->

      <div class="row">
        <!-- simple table -->
        <div class="col-sm-12 my-4">
          <div class="card shadow">
            <div class="card-body">
              <h5 class="card-title">Transaksi Terakhir</h5>
              <table class="table table-hover">
                <thead>

                  <tr>
                    <th>No</th>
                    <th>Nomor Invoice</th>
                    <th>Tanggal</th>
                    <th>Nama Pelanggan</th>
                    <th>Pembayaran</th>
                    <th>Total</th>
                    <th>Status</th>
                    <td>Aksi</td>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1;
                  foreach ($rows as $row): ?>
                    <tr>
                      <td><?= $no++; ?></td>
                      <td><?= $row['no_transaction'] ?></td>
                      <td><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>
                      <td><?= $row['customer_name'] ?></td>
                      <td><?= $status = pembayaran($row['status'])?></td>
                      <td><?= "Rp. " . number_format($row['total_pendapatan'], 0, ',', '.') ?></td>
                      <td></td>
                      <td>
                        <div class="button-action">
                          <a href="print.php?tanggal=<?= $row['tanggal'] ?>"
                            class="btn btn-primary btn-sm" target="_blank">
                            <i class="fe fe-printer fe-16"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>
          </div>
        </div> <!-- simple table -->
      </div>