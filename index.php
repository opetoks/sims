<?php
session_start();
include ("include/config.php");
# This login is structure different use, the content of settings database must be pulled for 
#various usage. for example (a) the logo of the school, (b) Name of the school etc 
$settingsQuery = $db->query("SELECT * FROM portal_settings ORDER BY id DESC LIMIT 1");
$settings = $settingsQuery->fetch();
include("include/functions.php");
?>
<!DOCTYPE html>
<html>
<head>
  <title> <?php echo $settings['title']; ?> </title>
  <link href="<?php echo $settings['logo_image'];?>" rel="shortcut icon" type="image/png">
  <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="css/button.css">
  <style type="text/css">
  
  body
  {
    top:50px;
  }
    .mb-60 {
    margin-bottom: 60px;
}
.services-inner {
    border: 2px solid #48c7ec;
    margin-left: 35px;
    transition: .3s;
}
.our-services-img {
    float: left;
    margin-left: -36px;
    margin-right: 22px;
    margin-top: 28px;
}
.our-services-text {
    padding-right: 10px;
}
.our-services-text {
    overflow: hidden;
    padding: 28px 0 25px;
}
.our-services-text h4 {
    color: #222222;
    font-size: 18px;
    font-weight: 700;
    letter-spacing: 1px;
    margin-bottom: 8px;
    padding-bottom: 10px;
    position: relative;
    text-transform: uppercase;
}
.our-services-text h4::before {
    background: #ec6d48 none repeat scroll 0 0;
    bottom: 0;
    content: "";
    height: 1px;
    position: absolute;
    width: 35px;
}
.our-services-wrapper:hover .services-inner {
    background: #fff none repeat scroll 0 0;
    border: 2px solid transparent;
    box-shadow: 0px 5px 10px 0px rgba(0, 0, 0, 0.2);
}
.our-services-text p {
    margin-bottom: 0;
}
p {
    font-size: 14px;
    font-weight: 400;
    line-height: 26px;
    color: #666;
    margin-bottom: 15px;
}
  </style>
</head>
<body>
<div class="container">
      <div class="row">
      <center><img style="height:100px; width: 80px; font-weight: bold;" src="<?php echo $settings['logo_image'];?>"> <h3><?php echo $settings['title'];?></h3></center>
      <center><h2>MANAGEMENT INFORMATION SYSTEM</h2> </center>
      </div>
  <div class="row">
    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
            <div class="our-services-wrapper mb-60">
              <div class="services-inner">
                <div class="our-services-img">
                <img src="user.png" width="68px" alt="" />
                </div>
                <div class="our-services-text">
                  <h4>Admission Portal</h4>
                  <p>The admission processing portal for the new intakes</p>
                  <a href='app/'><button class="btn btn-danger"> STUDENT / STAFF login</button></a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
            <div class="our-services-wrapper mb-60">
              <div class="services-inner">
                <div class="our-services-img">
                <img src="user.png" width="68px" alt=""><!-- https://www.orioninfosolutions.com/assets/img/icon/Agricultural-activities.png -->
                </div>
                <div class="our-services-text">
                  <h4>Students Portal</h4>
                  <p>Student course registration, time-table and other activities management</p>
                  <a href='simportal/login'><button class="btn btn-danger"> STUDENT / STAFF login</button></a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
            <div class="our-services-wrapper mb-60">
              <div class="services-inner">
                <div class="our-services-img">
                <img src="user.png" width="68px" alt="">
                </div>
                <div class="our-services-text">
                  <h4> Learning System</h4>
                  <p> Learning management system for all students</p>
                  <a href='lms'><button class="btn btn-danger"> STUDENT / STAFF login</button></a>
                </div>
              </div>
            </div>
          </div>
  </div>
</div>
<div class="footer">
    <center> <p> &copy; <script type="text/javascript"> var year = new Date(); document.write(year.getFullYear());</script> - Information Unit - <a href="https://rugipo.edu.ng"><?php echo $settings['institution_name'];?> </a> For any technical issues send mail to: <?php echo $settings['supportemail'];?></p></center>
 </div>
<!-- <div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <span class="glyphicon glyphicon-bookmark"></span> Quick Shortcuts</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-6 col-md-6">
                          <a href="#" class="btn btn-danger btn-lg" role="button"><span class="glyphicon glyphicon-list-alt"></span> <br/>Apps</a>
                          <a href="#" class="btn btn-warning btn-lg" role="button"><span class="glyphicon glyphicon-bookmark"></span> <br/>Bookmarks</a>
                          <a href="#" class="btn btn-primary btn-lg" role="button"><span class="glyphicon glyphicon-signal"></span> <br/>Reports</a>
                          <a href="#" class="btn btn-primary btn-lg" role="button"><span class="glyphicon glyphicon-comment"></span> <br/>Comments</a>
                        </div>
                        <div class="col-xs-6 col-md-6">
                          <a href="#" class="btn btn-success btn-lg" role="button"><span class="glyphicon glyphicon-user"></span> <br/>Users</a>
                          <a href="#" class="btn btn-info btn-lg" role="button"><span class="glyphicon glyphicon-file"></span> <br/>Notes</a>
                          <a href="#" class="btn btn-primary btn-lg" role="button"><span class="glyphicon glyphicon-picture"></span> <br/>Photos</a>
                          <a href="#" class="btn btn-primary btn-lg" role="button"><span class="glyphicon glyphicon-tag"></span> <br/>Tags</a>
                        </div>
                    </div>
                    <a href="http://www.jquery2dotnet.com/" class="btn btn-success btn-lg btn-block" role="button"><span class="glyphicon glyphicon-globe"></span> Website</a>
                </div>
            </div>
        </div>
    </div>
</div> -->

</body>
</html>



