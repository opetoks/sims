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
$querysemester = $db->query("SELECT * FROM currentsemester WHERE id= ?", [1]);
while($result = $querysemester->fetch()){
$semester = $result['semester'];
$session = $result['description'];
//SELECT value FROM semesters WHERE semester = '$semester' ORDER BY id
}
//$stmt = $db->query("SELECT * FROM registered_students WHERE matricno = ? LIMIT 1", [$_SESSION['matricno']]);
//$user_registration = $stmt->fetch();

$registeredcoursetable = '';
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
$registeredcourses = $db->query("SELECT * FROM registered_courses WHERE matricno =? AND level= ?",[$_SESSION['matricno'],$level]);
        			$studentregcourses=$registeredcourses->fetch();
        			//$coursecode = $studentregcourses['coursecode'];
        			$i = 1; 
        			$total_unit=0;
        			while($studentregcourses = $registeredcourses->fetch()){
        			
        			$registeredcoursetable.="
		                <tr id='$studentregcourses[id]'>
		                    <td> $i </td>
		                    <td> $studentregcourses[coursedescription]</td>
		                    <td> $studentregcourses[coursecode] </td> 
		                    <td> $studentregcourses[unit] </td>
		                    <td> $studentregcourses[level] </td>
		                    <td> $studentregcourses[semester] </td>
		                    <td> $studentregcourses[session] </td>
		                    <td> $studentregcourses[date_submitted] </td>
		                    <td><input class='form-check-input' type='checkbox' id='blankCheckbox' data-emp-id='$studentregcourses[id]' value='$studentregcourses[id]'></td>
		                </tr>
		                ";
		                $i++;
        			$total_unit+=$studentregcourses["unit"];
		                } 
		                if($registeredcourses->fetch() < 0)
		                {
		                $registeredcoursetable.="No results found";
		                }
		                
		           
  
?>
<?php
if(isset($_POST['reg-btn'])){
$selectedCourse = $_POST['selectedCourse'];
$stmt1 = $db->query("SELECT * FROM registered_courses WHERE matricno = ? AND coursecode = ? AND level= ?",[$_SESSION['matricno'],$selectedCourse,$level]);
$regCourse = $stmt1->fetch(); //array

if($stmt1->num_rows() > 0){ 
 echo"<span><b>SORRY!</b> You have once selected this Course </span>";
 }
 else{
 $stmt2=$db->query("SELECT * FROM courses WHERE coursecode = ? AND level= ?",[$selectedCourse,$level]);
 $course=$stmt2->fetch();
 //print_r($course);
 $unit = $course['unit'];
 $coursedescription = $course['coursedescription'];
 //$id = $course['id'];

	    $data = array(
					'matricno' => $_SESSION['matricno'],
					'coursecode' => $selectedCourse,
					'unit' => $unit,
					'coursedescription' => $coursedescription,
					'level' => $level,
					'semester' => $semester,
					'session' => $session);
				$db->insert('registered_courses', $data);
				if ($db->affectedRows() == 0)
				echo "<meta http-equiv='refresh' content='0'>";
				  //  $db->redirect('login.php?success');
				//else
				//$db->redirect('register.php?error');
			
        }
}
 
//else{
/*$stmt2=$db->query("INSERT INTO registered_courses SET matricno=?,coursecode=?,unit=?,coursedescription =?,level=?,id=?,semester=?,session=?",[$_SESSION['matricno'],$coursecode,$unit,$coursedescription,$level,$id,$semester,$session]);}*/


?>
<!DOCTYPE html>
<html>
<head>
   <title> <?php echo $settings['institution_name']; ?> </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="../<?php echo $settings['logo_image'];?>" rel="shortcut icon" type="image/png">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.min.css">
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="../css/button.css">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
  
  <script type="text/javascript">
  	// select all checkbox
	$('#selectall').on('click', function(e) {
	if($(this).is(':checked',true)) {
	$(".form-check-input").prop('checked', true);
	}
	else {
	$(".form-check-input").prop('checked',false);
	}
	// set all checked checkbox count
	$("#select_count").html($("input.form-check-input:checked").length+" Selected");
	});
	// set particular checked checkbox count
	$(".form-check-input").on('click', function(e) {
	$("#select_count").html($("input.form-check-input:checked").length+" Selected");
	});
  </script>
  
  <style>
  #searchCourse {
  border-box: box-sizing;
  background-image: url('searchicon.png');
  background-position: 14px 12px;
  background-repeat: no-repeat;
  font-size: 16px;
  padding: 14px 20px 12px 45px;
  border: none;
  border-bottom: 1px solid #ddd;
}
  </style>
  
 

</head>
<body>

<hr>
<div class="container">
     <div class="row">
      <center><img style="height:50px; font-weight: bold;" src="../<?php echo $settings['logo_image'];?>"> <h5><?php echo $settings['title'];?></h5></center>
      </div>
                
    <div class="row">
  		<div class="col-sm-10"><h2><?php echo $surname." ".$middlename." ".$firstname; ?> (<?php echo $matricno; ?>) </h2></div>
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
             <div class="row"> <h3> <span class="glyphicon glyphicon-file fx-3"></span> Course Registration <br> <?php echo $level; ?>Level <br> <?php echo $session; ?> </h3></div>
             <div class="row">
             
             <div class="panel panel-primary">
		    <div class="panel-heading"><span class="glyphicon glyphicon-book"></span> Registered Courses <span class="badge pull-right"><?php $c = $i-1; echo $c;?> New Courses</span> </div>
		    <div class="panel-body">
		        <div class="btn-group pull-right">
			  <button type="button" class="btn btn-success loader"><span class="glyphicon glyphicon-plus"></span> Add New Course </button>
			  <button type="button" id="delete_records" class="btn btn-danger"><span class="rows_selected glyphicon glyphicon-trash" id="select_count"> 0 </span> Delete </button>
			  <button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Save All </button>
			</div>
		    </div>
		
		    <div class="table-responsive">
		        <table class="table table-bordered col-md-8" id="coursetable" style="font-size:10px;width:850px;">
		        
		            <thead>
		                <tr>
		     		    <th style="width:5%;">#</th>
		                    <th style="width:31.8%;"> Course Title </th>
		                    <th style="width:5%"> Course Code </th>
		                    <th style="width:3%"> Credit Unit </th> 
		                    <th style="width:3%"> Level </th>
		                    <th style="width:3%"> Semester </th>
		                    <th style="width:3%"> Session </th>
		                    <th style="width:5%"> Date Registered </th>      
		                    <th style="width:2%"> </th>
		                </tr>
		            </thead>
		           
		            <tbody>
		            
		            	<?php 
        // echo table here
        			echo $registeredcoursetable;
		                ?>
		                <tr>
		                    <td>  </td>
		                    <td>  <b>Total Number of Units Registered</b></td>
		                    <td>  </td> 
		                    <td>  <b><?php echo $total_unit; ?></b> </td>
		                    <td>  </td>
		                    <td>  </td>
		                    <td>  </td>
		                    <td>  </td>
		                    <td>  </td>
		                    </tr>
		                <tr>
		                    <td>  </td>
		                    <td> <input type="text" name="coursedescription" class="col-md-12"> </td>
		                    <td> <input type="text" name="coursecode" class="col-xs-6"> </td> 
		                    <td> <input type="text" name="unit" class="col-xs-6"> </td>
		                    <td> 
			                    <select> 
			                    	<option>100L</option>
			                    	<option>200L</option> 
			                    	<option>300L</option>
			                    	<option>400L</option>
			                    	<option>500L</option>
			                    </select>
		                    </td>
		                    <td>
			                    <select> 
			                        <option>1st Semester</option>
			                    	<option>2nd Semester</option>	 
			                    </select>
		                    </td>
		                    <td>
			                    <select> 
			                    	 
			                    </select>
		                    </td>
		                    <td> </td>
		                    <td> <input type='checkbox' id='selectall'>  </td>
		               </tr>
		                
		                
		            </tbody>
		           
		        </table>
		    </div>
		</div>
             
               </div>
             

        </div><!--/col-9-->
    </div><!--/row-->
    
     <div class="modal" tabindex="-1" role="dialog" id='courseloader'>
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h3 class="modal-title">New Course Registration</h3>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form class="form-inline" method="post" style="font-size:15px">
	      <div class="modal-body">
	    		<select class="selectpicker show-tick" data-live-search="true" name="selectedCourse" data-width="90%">/*selectpicker*/
	    		<?php
	    		//get content from database
	                $query = $db->query("SELECT * FROM courses WHERE level = ?",[$level]);
	    		while($courseData = $query->fetch()){
	    		$coursecode = $courseData['coursecode'];
	    		$coursedisc = $courseData['coursedescription'];
	    		
	                echo "
	                <option id='courseOption' value='$coursecode'>". $coursecode.' '.$coursedisc."</option>";
	    		 }
	    		 ?>
	    		</select>    	   
    	     
    	     
	        
	      </div>
	      <div class="modal-footer">
	        <button type='submit' name="reg-btn" class="btn btn-success pull-left"> Register </button>
	      </div>
	    </div>
	    </form>
	  </div>
	</div>
    
    
    <hr>
    <div class="footer pull-right" style="padding-top:2em;">
     <p> &copy; <script type="text/javascript"> var year = new Date(); document.write(year.getFullYear());</script> - Information Unit - <a href="https://rugipo.edu.ng"><?php echo $settings['institution_name'];?> </a> For any technical issues send mail to: <?php echo $settings['supportemail'];?></p>
    </div>
 <script>
$('.loader').on('click',function(){
$('#courseloader').modal({show:true});
    //$('.modal-body').load('getCourses.php?id=2',function(){
  //where to show if load function used      
   // });
});
</script>


<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script> 

 
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
                $(document).ready(function() {
                $('#coursetable').DataTable();
            } );
</script>
</body>                                                    
</html>