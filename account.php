<?php
session_start();
include ("../include/config.php");
# This login is structure different use, the content of settings database must be pulled for 
#various usage. for example (a) the logo of the school, (b) Name of the school etc 
$settingsQuery = $db->query("SELECT * FROM portal_settings ORDER BY id DESC LIMIT 1");
$settings = $settingsQuery->fetch();
include("../include/functions.php");

if(!$db->is_logged_in())
{
	$db->redirect('login.php');
}
$stmt = $db->query("SELECT * FROM registered_students WHERE matricno = ? LIMIT 1", [$_SESSION['matricno']]);
$user_registration = $stmt->fetch();

$record_stmt = $db->query("SELECT * FROM students_records WHERE matricno = ? LIMIT 1", [$_SESSION['matricno']]);
$row = $record_stmt->fetch();
    if($record_stmt->num_rows() > 0){
       $firstname = $row['firstname'];
       $surname = $row['surname'];
       $middlename = $row['middlename'];
       $passport = $row['imagedestination'];
       $matricno = $row['matricno'];
}
$level = getLevel($_SESSION['matricno']);
?>

<!DOCTYPE html>
<html>
<head>
   <title> <?php echo $settings['institution_name']; ?> </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="../css/button.css">
  <link rel="stylesheet" type="text/css" href="../css/stylesheet.css">
  <link rel="stylesheet" type="text/css" href="../css/calendar.css">
  <script type="text/javascript" src="../js/calendar.min.js"></script>

  

</head>
<body>

<hr>
<div class="container">
     <div class="row">
      <center><img style="height:50px; font-weight: bold;" src="../<?php echo $settings['logo_image'];?>"> <h5><?php echo $settings['title'];?></h5></center>
      </div>
                
    <div class="row">
  		<div class="col-sm-10"><h2><?php echo $surname." ".$middlename." ".$firstname; ?> (<?php echo $matricno; ?>) <?php echo $level; ?>Level </h2></div>
    	<div class="col-sm-2"><a href="logout" class="pull-right"><i class='fas fa-power-off fa-4x'></i></a></div>
    </div>
    <div class="row">
        <div class="col-md-offset-3">
                <a href="studentsprofile" class="btn btn-danger"  title="My Profile"><!-- data-toggle="modal" data-target="" -->
                <i class="fa fa-user" aria-hidden="true"></i>  My Profile </a>
                <a href="studentscourses" class="btn btn-danger" title="Course Registration">
                <i class="fa fa-edit" aria-hidden="true"></i>Course Registration</a>
                <a href="studentsfee" class="btn btn-danger"  title="fees">
                <i class="fa fa-tag" aria-hidden="true"></i> School fees </a>
                <a href="studentsresult" class="btn btn-danger"  title="Result">
                <i class="fa fa-file" aria-hidden="true"></i> Result </a>
                <a href="studentspassword" class="btn btn-danger" title="Change password">
                <i class="fa fa-key" aria-hidden="true"></i> Change Password </a>
        </div>
    </div>

    <div class="row">
      <div class="col-sm-3"><!--left col-->
      <div class="text-center">
        <img src="<?php echo $passport; ?>" class="avatar img-circle img-thumbnail" alt="avatar">
        <h6>Upload a different photo...</h6>
        <input type="file" class="text-center center-block file-upload">
      </div></hr><br>
      
      
      
      
      	     <div class="list-group">
		    <a href="#" class="list-group-item active">
		        <span class="glyphicon glyphicon-home"></span> Dashboard 
		    </a>
		    <a href="studentscourses" class="list-group-item list-group-item-info">
		        <span class="glyphicon glyphicon-book"></span> Course Registration <span class="badge"> <i class="fa fa-arrow-right"></i> </span>
		    </a>
		    <a href="studentsfee" class="list-group-item list-group-item-success">
		        <span class="glyphicon glyphicon-tag"></span> Fees <span class="badge"><i class="fa fa-arrow-right"></i></span>
		    </a>
		    <a href="studentsresult" class="list-group-item list-group-item-warning">
		        <span class="glyphicon glyphicon-file"></span> Results <span class="badge"><i class="fa fa-arrow-right"></i></span>
		    </a>
		    <a href="studentsprofile" class="list-group-item list-group-item-danger">
		        <span class="glyphicon glyphicon-user"></span> My Profile <span class="badge"><i class="fa fa-arrow-right"></i></span>
		    </a>
		    <a href="studentspassword" class="list-group-item list-group-item-default">
		        <span class="glyphicon glyphicon-cog"></span> Change Password <span class="badge"><i class="fa fa-arrow-right"></i></span>
		    </a>
		    <a href="studentsemail" class="list-group-item list-group-item-success">
		        <span class="glyphicon glyphicon-envelope"></span> Email History  <span class="badge"><i class="fa fa-arrow-right"></i></span>
		    </a>
	    </div>         
        </div><!--/col-3-->
    	<div class="col-sm-9">
             <div class="row"> <h3> <span class="glyphicon glyphicon-home fx-3"></span> Home</h3></div>
             <div class="row">
             <div class="summary">

                <p>Welcome to Rufus Giwa Polytechnic, Owo</p>

                <p>Academic calendar for <script type="text/javascript"> var year = new Date(); document.write(year.getFullYear());</script> Session </p>

                <p><b><a href="">Download Academic Calendar Size: 2.1 KB <span class="glyphicon glyphicon-download-alt"></span></a></b></p>

             </div>
             <div id="calendar"></div>
             </div>
             

        </div><!--/col-9-->
    </div><!--/row-->
    <hr>
    <div class="footer pull-right" style="padding-top:2em;">
     <p> &copy; <script type="text/javascript"> var year = new Date(); document.write(year.getFullYear());</script> - Information Unit - <a href="https://rugipo.edu.ng"><?php echo $settings['institution_name'];?> </a> For any technical issues send mail to: <?php echo $settings['supportemail'];?></p>
    </div>

<script>

            var events = [{start: '2017/09/30', end: '2017/10/07', summary: "Example Event", mask: true}, {start: '2017/10/08', end: '2017/10/13', summary: "Example Event #3", mask: true}];

            $('#calendar').calendar({'events': events});

            var calendar1 = new Date();
            calendar1.setDate(1);
            calendar1.setMonth(calendar1.getMonth() - 1);

            $('#calendar-1').calendar({color: 'orange', date: calendar1});

            var calendar2 = new Date();
            calendar2.setDate(1);
            calendar2.setMonth(calendar2.getMonth() + 1);

            $('#calendar-2').calendar({color: 'purple', date: calendar2, events: events});

            var calendar3 = new Date();
            calendar3.setDate(1);
            calendar3.setMonth(calendar3.getMonth() + 2);

            $('#calendar-3').calendar({color: 'yellow', date: calendar3});

            var calendar4 = new Date();
            calendar4.setDate(1);
            calendar4.setMonth(calendar4.getMonth() + 3);

            $('#calendar-4').calendar({color: 'blue', date: calendar4});

            var calendar5 = new Date();
            calendar5.setDate(1);
            calendar5.setMonth(calendar5.getMonth() + 4);

            $('#calendar-5').calendar({color: 'green', date: calendar5});

            var calendar6 = new Date();
            calendar6.setDate(1);
            calendar6.setMonth(calendar6.getMonth() + 5);

            $('#calendar-6').calendar({color: 'grey', date: calendar6});

            var calendar7 = new Date();
            calendar7.setDate(1);
            calendar7.setMonth(calendar7.getMonth() + 6);

            $('#calendar-7').calendar({color: 'pink', date: calendar7});


        </script>

</body>                                                    
</html>