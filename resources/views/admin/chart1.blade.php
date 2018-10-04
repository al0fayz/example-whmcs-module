@extends('admin.layout')
@section('content')
<style>
.dot {
    height: 15px;
    width: 15px;
    background-color: #33ccff;
    border-radius: 50%;
    display: inline-block;
}
.dot1 {
    height: 15px;
    width: 15px;
    background-color: #28a745;
    border-radius: 50%;
    display: inline-block;
}
.dot2 {
    height: 15px;
    width: 15px;
    background-color: #ff9933;
    border-radius: 50%;
    display: inline-block;
}
.dot3 {
    height: 15px;
    width: 15px;
    background-color: #cc0066;
    border-radius: 50%;
    display: inline-block;
}
.dot4 {
    height: 15px;
    width: 15px;
    background-color: #cc3300;
    border-radius: 50%;
    display: inline-block;
}
.table-new {
    width: 100%;
}

tr {
    height: 30px;
}
td{
  width: 20px;
  text-align: justify;
}

</style>
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
                    <a href="/pdf/chart1" class="p-r-10"><img width="25" height="25" alt="" class="icon-pdf" data-src-retina="assets/img/invoice/pdf2x.png" data-src="assets/img/invoice/pdf.png" src="assets/img/invoice/pdf2x.png"></a>
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
      <!-- START card -->
      <div class=" container-fluid   container-fixed-lg">
        <div class="card card-transparent">
          <div class="invoice padding-50 sm-padding-10">
          <div class="pull-left">
            <h2 class="bold">Zone File Respone</h2>
          </div>
          <div class="pull-right sm-m-t-20">
            <h5>Powered By dataprovider.com</h5>
          </div>
        </div>
              <div class="col-lg-12 col-sm-height sm-no-padding">
                <p>
                  In November we've analyzed 94,020 domains with our crawlers, The results from that crawl are used to generate this report. Not every domain contains a website. This chapter gives insights into the responses of the domains.
                </p>
              </div>
          </div>
        </div>
        <div class=" container-fluid   container-fixed-lg">
        <!-- START card -->
        <div class="card card-transparent">
          <div class="card-header ">
            <div class="card-title bold"><b>Response</b>
            </div>
            <div class="card-controls">
              <ul>
                <li><a href="#" class="card-collapse" data-toggle="collapse"><i
                  class="pg-arrow_maximize"></i></a>
                </li>
                <li><a href="#" class="card-refresh" data-toggle="refresh"><i class="pg-refresh_new"></i></a>
                </li>
                <li><a href="#" class="card-close" data-toggle="close"><i class="pg-close"></i></a>
                </li>
              </ul>
            </div>
          </div>
          <div class="card-body d-flex flex-wrap">
            <div class="col-lg-4 no-padding">
              <div class="card card-transparent">
                <div class="card-body">
                  <canvas id="myChart"></canvas>
                </div>
              </div>
            </div>
            <div class="col-lg-8 sm-no-padding">
            <div class="p-r-30">
            <table class="table-new">
            <tbody>
            <tr>
              <td><span class="dot"></span>Available</td>
              <td>(70,499)</td>
              <td><b>75%</b></td>
            </tr>
            <tr>
              <td><span class="dot1"></span>Access denied</td>
              <td>(19,117)</td>
              <td><b>20,3%</b></td>
            </tr>
            <tr>
              <td><span class="dot2"></span>Redirect</td>
              <td>(4,404)</td>
              <td><b>4,7%</b></td>
            </tr>
            </tbody>
            </table>
            </div>
              
                <p>When we Index a domain there can be four type of response. If a domain name is 'available' it means that we have
                  received a valid response with status code 1xx or 2xx . A domain can also result in a 'host not found' response . This
                  means there is no IP configured in the DNS for this domain . If the response is a 'redirect' then we received a service side redirect with status code 
                  3xx. The last response type is an 'Access denied', this means the crawler could not access the website and recieved status
                  code 4xx, 5xx, or 9xx. The following paragraph gives more details about the cause of the access denied.
                </p>
              </div>
            </div>
        <!-- END card -->
      </div>
      <!-- END CONTAINER FLUID -->

      <!-- START CONTAINER FLUID -->
      <!-- <div class=" container-fluid   container-fixed-lg"> -->
        <!-- START card -->
        <div class="card card-transparent">
          <div class="card-header  ">
            <div class="card-title bold"><b>Access Denied</b>
            </div>
          </div>
          <div class="card-body d-flex flex-wrap">
            <div class="col-lg-12 no-padding">
              <div class="p-r-30">
                <br>
                <p>
                  An 'Access denied' means that the crawler can't access the website. This can occur when the DNS is not configured, the server is unavailable or access is not allowed. in most cases there is no website (DNS is not configured) but sometimes there is, in that case the hosting 
                  provider, Webmaster or CMS of the website doesn't allow the crawler to visit the website. if a domain result in an Access denied the 'Status Code' explains why access was denied. In the following chart you can see the top 5 reasons why some domains resulted in an access denied. 
                </p>
                <br>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="card card-transparent">
                <div class="card-header  ">
                  <div class="card-controls">
                    <ul>
                      <li><a href="#" class="card-collapse" data-toggle="collapse"><i
                        class="pg-arrow_maximize"></i></a>
                      </li>
                      <li><a href="#" class="card-refresh" data-toggle="refresh"><i
                        class="pg-refresh_new"></i></a>
                      </li>
                      <li><a href="#" class="card-close" data-toggle="close"><i
                        class="pg-close"></i></a>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                  <div class="col-md-12">
                    <canvas id="myChart1"></canvas>
                    </div>
                  </div>
                  <div class="row">
                    <table class="table-new">
                      <tbody>
                        <tr>
                          <td><span class="dot"></span>   403</td>
                          <td>(8,070)</td>
                          <td><b>45%</b></td>
                          <td>Ok</td>
                        </tr>
                        <tr>
                          <td><span class="dot1"></span>   950</td>
                          <td>(4,900)</td>
                          <td><b>27%</b></td>
                          <td>Forbidden</td>
                        </tr>
                        <tr>
                          <td><span class="dot2"></span>   902</td>
                          <td>(2,079)</td>
                          <td><b>12%</b></td>
                          <td>Website is disallowed by robots.txt</td>
                        </tr>
                        <tr>
                          <td><span class="dot3"></span>   404</td>
                          <td>(1,626)</td>
                          <td><b>9%</b></td>
                          <td>Unable to connect (DNS contains invalid IP address).</td>
                        </tr>
                        <tr>
                          <td><span class="dot4"></span>   404</td>
                          <td>(1,400)</td>
                          <td><b>8%</b></td>
                          <td>Not Found</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
            
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- END card -->
        </div>
      </div>
      <!-- END CONTAINER FLUID -->

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
    type: 'doughnut',
    data: {
      datasets: [{
        data: [
        75,
        20,
        4,
        ],
        backgroundColor: [
        '#33ccff',
        '#28a745',
        '#ff9933',
        ],
        labels: [
      'Available',
      'Access denied',
      'Redirect',
      ],
      }],
      labels: [
      'Available',
      'Access denied',
      'Redirect',
      ],
    },
    options: {
      responsive: true,
      legend: {
        display: false,
      },
    }
  });
  // var ctx = document.getElementById("myChart1").getContext('2d');
  // var myChart = new Chart(ctx, {
  //   type: 'horizontalBar',
  //   data: {
  //     labels: ["OK", "Forbidden", "Website is disallowed b robots.txt.", "Unable to connect. (DNS contains invalid IP address)", "Not Found"],
      
  //     datasets: [{
  //       labels: ["OK", "Forbidden", "Website is disallowed b robots.txt.", "Unable to connect. (DNS contains invalid IP address)", "Not Found"],
  //       data: [45, 27, 12, 9, 8],
  //       backgroundColor: [
  //       '#574B90',
  //       '#28a745',
  //       '#ffc107',
  //       '#574B90',
  //       '#28a745',
  //       '#ffc107',
  //       ]
  //     },]
  //   },
  //   options: {
  //     responsive: true,
  //     scales: {
  //       xAxes: [{
  //         type: 'linear',
  //           scaleLabel:{
  //               display:false
  //           },
  //           gridLines: {
  //             display:false,
  //           }, 
  //           stacked: true
  //       }],
  //       yAxes: [{
  //         scaleLabel:{
  //               display:false
  //           },
  //           gridLines: {
  //             display:false,
  //           }, 
  //           stacked: true
  //       }]
  //   },
  //   legend:{
  //       display:false
  //   },
  //   labels:{
  //     display:false
  //   },
  //   }
  // });
var myCanvas = document.getElementById("myChart1");
myCanvas.width = 1010;
myCanvas.height = 50;
var myData = {
  "OK" : 45,
  "Forbidden" : 27, 
  "Website is disallowed b robots.txt." : 12, 
  "Unable to connect. (DNS contains invalid IP address)": 9, 
  "Not Found": 8  
};
var ctx = myCanvas.getContext("2d");
var myBarchart = new Barchart(
    {
        canvas:myCanvas,
        padding:10,
        data:myData,
        colors:[
        "#33ccff",
        '#28a745',
        '#ff9933',
        '#cc0066',
         "#cc3300",
        ]
    }
);
myBarchart.draw();
var canvas = document.getElementById("canvas");
canvas.width = 20;
canvas.height = 20;
var cyrcle = myCanvas.getContext("2d");
drawCyrcle(cyrcle, 150,150,150,'#ff0000');
</script>
@endsection