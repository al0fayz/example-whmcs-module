@extends('admin.layout')
@section('content')
<!-- START PAGE-CONTAINER -->
<div class="page-container ">
      <!-- START PAGE CONTENT WRAPPER -->
      <div class="page-content-wrapper ">
        <!-- START PAGE CONTENT -->
        <div class="content ">
          <nav class="navbar navbar-default bg-master-lighter sm-padding-10 full-width p-t-0 p-b-0" role="navigation">
            <div class="container-fluid full-width">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header text-center">
                <button type="button" class="navbar-toggle collapsed btn btn-link no-padding" data-toggle="collapse" data-target="#sub-nav">
                  <i class="pg pg-more v-align-middle"></i>
                </button>
              </div>
              <!-- Collect the nav links, forms, and other content for toggling -->
              <div class="collapse navbar-collapse" id="sub-nav">
                <div class="row">
                  <div class="col-sm-4">
                  </div>
                  <div class="col-sm-4">
                    <ul class="navbar-nav d-flex flex-row">
                      <li class="nav-item"><a href="#">Open</a></li>
                      <li class="nav-item"><a href="#" data-toggle="tooltip" data-placement="bottom" title="Print"><i class="fa fa-print"></i></a></li>
                      <li class="nav-item"><a href="#" data-toggle="tooltip" data-placement="bottom" title="Download"><i class="fa fa-download"></i></a></li>
                    </ul>
                  </div>
                  <div class="col-sm-4">
                    <ul class="navbar-nav d-flex flex-row justify-content-sm-end">
                      <li class="nav-item">
                        <a href="#" class="p-r-10"><img width="25" height="25" alt="" class="icon-pdf" data-src-retina="assets/img/invoice/pdf2x.png" data-src="assets/img/invoice/pdf.png" src="assets/img/invoice/pdf2x.png"></a>
                      </li>
                      <li class="nav-item">
                        <a href="#" class="p-r-10"><img width="25" height="25" alt="" class="icon-image" data-src-retina="assets/img/invoice/image2x.png" data-src="assets/img/invoice/image.png" src="assets/img/invoice/image2x.png"></a>
                      </li>
                      <li class="nav-item">
                        <a href="#" class="p-r-10"><img width="25" height="25" alt="" class="icon-doc" data-src-retina="assets/img/invoice/doc2x.png" data-src="assets/img/invoice/doc.png" src="assets/img/invoice/doc2x.png"></a>
                      </li>
                      <li class="nav-item"><a href="#" class="p-r-10" onclick="$.Pages.setFullScreen(document.querySelector('html'));"><i class="fa fa-expand"></i></a></li>
                    </ul>
                  </div>
                </div>
              </div>
              <!-- /.navbar-collapse -->
            </div>
            <!-- /.container-fluid -->
          </nav>
<!-- START CONTAINER FLUID -->
          <div class=" container-fluid   container-fixed-lg">
            <!-- START card -->
            <div class="card card-default m-t-20">
              <div class="card-body">
                <div class="invoice padding-50 sm-padding-10">
                  <div>
                    <div class="pull-left">
                      Zone File Respone
                    </div>
                    <div class="pull-right sm-m-t-20">
                      <h4 class="font-montserrat all-caps hint-text">Powered By dataprovider.com</h4>
                    </div>
                  </div>
                  <br>
                  <br>
                  <div class="col-12">
                    <div class="row">
                      <div class="col-lg-12 col-sm-height sm-no-padding">
                        <p class="large-text no-margin">
                          In November we've analyzed 94,020 domains with our crawlers, The results from that crawl are used to generate this report. Not every domain contains a website. This chapter gives insights into the responses of the domains.
                        </p>
                      </div>
                    </div>
                  </div>
                  <br>
                  <br>
                  <div class="row">
                  <div class="col-lg-4">
                  <canvas id="myChart3"></canvas>
                  </div>
                  <div class="col-lg-8">
                  
                  </div>
                  </div>
                  <div class="p-l-15 p-r-15">
                    <div class="row b-a b-grey">
                      <div class="col-md-2 p-l-15 sm-p-t-15 clearfix sm-p-b-15 d-flex flex-column justify-content-center">
                        <h5 class="font-montserrat all-caps small no-margin hint-text bold">Advance</h5>
                        <h3 class="no-margin">$21,000.00</h3>
                      </div>
                      <div class="col-md-5 clearfix sm-p-b-15 d-flex flex-column justify-content-center">
                        <h5 class="font-montserrat all-caps small no-margin hint-text bold">Discount (10%)</h5>
                        <h3 class="no-margin">$645.00</h3>
                      </div>
                      <div class="col-md-5 text-right bg-master-darker col-sm-height padding-15 d-flex flex-column justify-content-center align-items-end">
                        <h5 class="font-montserrat all-caps small no-margin hint-text text-white bold">Total</h5>
                        <h1 class="no-margin text-white">$64,276.00</h1>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <p class="small hint-text">Services will be invoiced in accordance with the Service Description. You must pay all undisputed invoices in full within 30 days of the invoice date, unless otherwise specified under the Special Terms and Conditions. All payments must reference the invoice number. Unless otherwise specified, all invoices shall be paid in the currency of the invoice</p>
                  <p class="small hint-text">Insight retains the right to decline to extend credit and to require that the applicable purchase price be paid prior to performance of Services based on changes in insight's credit policies or your financial condition and/or payment record. Insight reserves the right to charge interest of 1.5% per month or the maximum allowable by applicable law, whichever is less, for any undisputed past due invoices. You are responsible for all costs of collection, including reasonable attorneys' fees, for any payment default on undisputed invoices. In addition, Insight may terminate all further work if payment is not received in a timely manner.</p>
                  <br>
                  <hr>
                  <div>
                    <img src="assets/img/logo.png" alt="logo" data-src="assets/img/logo.png" data-src-retina="assets/img/logo_2x.png" width="78" height="22">
                    <span class="m-l-70 text-black sm-pull-right">+34 346 4546 445</span>
                    <span class="m-l-40 text-black sm-pull-right">support@revox.io</span>
                  </div>
                </div>
              </div>
            </div>
            <!-- END card -->
          </div>
          <!-- END CONTAINER FLUID -->
        </div>
        <!-- END PAGE CONTENT -->
        <!-- START COPYRIGHT -->
        <!-- START CONTAINER FLUID -->
        <!-- START CONTAINER FLUID -->
        <div class=" container-fluid  container-fixed-lg footer">
          <div class="copyright sm-text-center">
            <p class="small no-margin pull-left sm-pull-reset">
              <span class="hint-text">Copyright &copy; 2017 </span>
              <span class="font-montserrat">REVOX</span>.
              <span class="hint-text">All rights reserved. </span>
              <span class="sm-block"><a href="#" class="m-l-10 m-r-10">Terms of use</a> <span class="muted">|</span> <a href="#" class="m-l-10">Privacy Policy</a></span>
            </p>
            <p class="small no-margin pull-right sm-pull-reset">
              Hand-crafted <span class="hint-text">&amp; made with Love</span>
            </p>
            <div class="clearfix"></div>
          </div>
        </div>
        <!-- END COPYRIGHT -->
      </div>
      <!-- END PAGE CONTENT WRAPPER -->
    </div>
    <!-- END PAGE CONTAINER -->
@stop
@section('script')
<script>
    var ctx = document.getElementById("myChart").getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
        datasets: [{
          label: 'Statistics',
          data: [460, 458, 330, 502, 430, 610, 488],
          borderWidth: 2,
          backgroundColor: 'rgb(87,75,144)',
          borderColor: 'rgb(87,75,144)',
          borderWidth: 2.5,
          pointBackgroundColor: '#ffffff',
          pointRadius: 4
        }]
      },
      options: {
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true,
              stepSize: 150
            }
          }],
          xAxes: [{
            ticks: {
              display: false
            },
            gridLines: {
              display: false
            }
          }]
        },
      }
    });

    var ctx = document.getElementById("myChart2").getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
        datasets: [{
          label: 'Statistics',
          data: [460, 458, 330, 502, 430, 610, 488],
          borderWidth: 2,
          backgroundColor: 'rgb(87,75,144)',
          borderColor: 'rgb(87,75,144)',
          borderWidth: 2.5,
          pointBackgroundColor: '#ffffff',
          pointRadius: 4
        }]
      },
      options: {
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true,
              stepSize: 150
            }
          }],
          xAxes: [{
            ticks: {
              display: false
            },
            gridLines: {
              display: false
            }
          }]
        },
      }
    });

    var ctx = document.getElementById("myChart3").getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        datasets: [{
          data: [
            80,
            50,
            40,
            30,
            20,
          ],
          backgroundColor: [
            '#574B90',
            '#28a745',
            '#ffc107',
            '#dc3545',
            '#343a40',
          ],
          label: 'Dataset 1'
        }],
        labels: [
          'Purple',
          'Green',
          'Yellow',
          'Red',
          'Black'
        ],
      },
      options: {
        responsive: true,
        legend: {
          position: 'bottom',
        },
      }
    });

    var ctx = document.getElementById("myChart4").getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'pie',
      data: {
        datasets: [{
          data: [
            80,
            50,
            40,
            30,
            20,
          ],
          backgroundColor: [
            '#574B90',
            '#28a745',
            '#ffc107',
            '#dc3545',
            '#343a40',
          ],
          label: 'Dataset 1'
        }],
        labels: [
          'Purple',
          'Green',
          'Yellow',
          'Red',
          'Black'
        ],
      },
      options: {
        responsive: true,
        legend: {
          position: 'bottom',
        },
      }
    });
  </script>
@endsection