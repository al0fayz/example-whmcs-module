<!doctype html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Chart1</title>

  <style type="text/css">
  html {
    font-family: sans-serif;
  }
  body {
    margin: 0;
  }

.container {
  padding-right: 15px;
  padding-left: 15px;
  margin-right: auto;
  margin-left: auto;
  font-size: 12px;
  text-align: justify;
}

.container:before,
.container:after {
  display: table;
  content: " ";
}

.container:after {
  clear: both;
}

.container:before,
.container:after {
  display: table;
  content: " ";
}

.container:after {
  clear: both;
}

  .row {
    margin-right: -15px;
    margin-left: -15px;
  }

  .row:before,
  .row:after {
    display: table;
    content: " ";
  }

  .row:after {
    clear: both;
  }
  .col-md-1,
  .col-md-2,
  .col-md-3,
  .col-md-4,
  .col-md-5,
  .col-md-6,
  .col-md-7,
  .col-md-8,
  .col-md-9,
  .col-md-10,
  .col-md-11,
  .col-md-12{
    position: relative;
    min-height: 1px;
    padding-right: 15px;
    padding-left: 15px;
    float: left;
  }
  .col-md-12 {
    width: 100%;
  }

  .col-md-11 {
    width: 91.66666666666666%;
  }

  .col-md-10 {
    width: 83.33333333333334%;
  }

  .col-md-9 {
    width: 75%;
  }

  .col-md-8 {
    width: 66.66666666666666%;
  }

  .col-md-7 {
    width: 58.333333333333336%;
  }

  .col-md-6 {
    width: 50%;
  }

  .col-md-5 {
    width: 41.66666666666667%;
  }

  .col-md-4 {
    width: 33.33333333333333%;
  }

  .col-md-3 {
    width: 25%;
  }

  .col-md-2 {
    width: 16.666666666666664%;
  }

  .col-md-1 {
    width: 8.333333333333332%;
  }
</style>
<script>


</script>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <p> In November we've analyzed 94,020 domains with our crawlers, The results from that crawl are used to generate this report. Not every domain contains a website. This chapter gives insights into the responses of the domains.
        </p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
      <canvas id="myCahrt1"></canvas>
      </div>
      <div class="col-md-7">
      <p>When we Index a domain there can be four type of response. If a domain name is 'available' it means that we have
            received a valid response with status code 1xx or 2xx . A domain can also result in a 'host not found' response . This
            means there is no IP configured in the DNS for this domain . If the response is a 'redirect' then we received a service side redirect with status code 
            3xx. The last response type is an 'Access denied', this means the crawler could not access the website and recieved status
            code 4xx, 5xx, or 9xx. The following paragraph gives more details about the cause of the access denied.
        </p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
      <p>
        An 'Access denied' means that the crawler can't access the website. This can occur when the DNS is not configured, the server is unavailable or access is not allowed. in most cases there is no website (DNS is not configured) but sometimes there is, in that case the hosting 
        provider, Webmaster or CMS of the website doesn't allow the crawler to visit the website. if a domain result in an Access denied the 'Status Code' explains why access was denied. In the following chart you can see the top 5 reasons why some domains resulted in an access denied. 
      </p>
    </div>
  </div>
</div>
</body>
</html>