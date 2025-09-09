<?php 
include 'admin/controller/koneksi.php';







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
                          <p class="small text-muted mb-0">Omset Hari ini </p>
                          <span class="h3 mb-0 text-white">$1250</span>
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
                          <span class="h2 mb-0">186</span>
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
                      <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>Invoice</th>
                            <th>Tanggal</th>
                            <th>Nama Pelanggan</th>
                            <th>Pembayaran</th>
                            <th>Total</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>3224</td>
                            <td>Keith Baird</td>
                            <td>Enim Limited</td>
                            <td>901-6206 Cras Av.</td>
                            <td>Apr 24, 2019</td>
                            <td><span class="badge badge-pill badge-warning">Hold</span></td>
                          </tr>
                          <tr>
                            <td>3218</td>
                            <td>Graham Price</td>
                            <td>Nunc Lectus Incorporated</td>
                            <td>Ap #705-5389 Id St.</td>
                            <td>May 23, 2020</td>
                            <td><span class="badge badge-pill badge-success">Success</span></td>
                          </tr>
                          <tr>
                            <td>2651</td>
                            <td>Reuben Orr</td>
                            <td>Nisi Aenean Eget Limited</td>
                            <td>7425 Malesuada Rd.</td>
                            <td>Nov 4, 2019</td>
                            <td><span class="badge badge-pill badge-warning">Hold</span></td>
                          </tr>
                          <tr>
                            <td>2636</td>
                            <td>Akeem Holder</td>
                            <td>Pellentesque Associates</td>
                            <td>896 Sodales St.</td>
                            <td>Mar 27, 2020</td>
                            <td><span class="badge badge-pill badge-danger">Danger</span></td>
                          </tr>
                          <tr>
                            <td>2757</td>
                            <td>Beau Barrera</td>
                            <td>Augue Incorporated</td>
                            <td>4583 Id St.</td>
                            <td>Jan 13, 2020</td>
                            <td><span class="badge badge-pill badge-success">Success</span></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div> <!-- simple table -->
           </div>
