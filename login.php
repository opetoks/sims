<?php
session_start();
include ("../include/config.php");
# This login is structure different use, the content of settings database must be pulled for 
#various usage. for example (a) the logo of the school, (b) Name of the school etc 
$settingsQuery = $db->query("SELECT * FROM portal_settings ORDER BY id DESC LIMIT 1");
$settings = $settingsQuery->fetch();
include("../include/functions.php");

if($db->is_logged_in()!="")
{
    $db->redirect('account.php');
}
if(isset($_POST['btn-login']))
{  
    
    $matricno = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $pass = md5($password);
    if(!empty($matricno)){
    $stmt = $db->query("SELECT * FROM students_records WHERE matricno = ? and password = ? LIMIT 1", [$matricno,$pass]);
    $row = $stmt->fetch();
    if($stmt->num_rows() > 0){
    $_SESSION['matricno'] = $row['matricno'];
    $db->redirect('account.php');
}
    else{
        $msg = "
        <div class='alert alert-danger' role='alert'>
            <b> Sorry! </b> User doesn't exist.
        </div>
              ";
    }
    
        
 }

}

?>

<!DOCTYPE html>
<html>
<head>
    <title> <?php echo $settings['title']; ?> </title>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

</head>
<body>
<div class="container"> 
        <div class="row">
            <center><img style="height:100px; width: 80px; font-weight: bold;" src="../<?php echo $settings['logo_image'];?>"> <h3><?php echo $settings['title'];?></h3></center>
        </div>   
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
            <div class="panel panel-info" >
                    <div class="panel-heading">
                        <div class="panel-title">Sign In</div>
                        <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#">Forgot password?</a></div>
                    </div>     

                    <div style="padding-top:30px" class="panel-body" >
                            <?php if(isset($msg)) echo $msg;  ?>

                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                            
                        <form id="loginform" class="form-horizontal" method="post">
                                    
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input id="username" type="text" class="form-control" name="username" placeholder="username or matric number">                                        
                                    </div>
                                
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input id="login-password" type="password" class="form-control" name="password" placeholder="password">
                                    </div>
                                    

                                
                            <div class="input-group">
                                      <div class="checkbox">
                                        <label>
                                          <input id="login-remember" type="checkbox" name="remember" value="1"> Remember me
                                        </label>
                                      </div>
                                    </div>


                                <div style="margin-top:10px" class="form-group">
                                
                                    <div class="col-sm-12 controls">
                                      <button id="btn-login" name="btn-login" href="#" class="btn btn-success">Login  </button>
                                      <!-- <a id="btn-fblogin" href="#" class="btn btn-primary">Login with Facebook</a> -->
                                
                                    </div>
                                </div> 


                                 <!-- <div class="form-group">
                                        <div class="col-md-12 control">
                                            <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                                Don't have an account! 
                                            <a href="#" onClick="$('#loginbox').hide(); $('#signupbox').show()">
                                                Sign Up Here
                                            </a>
                                            </div>
                                        </div>
                                    </div>   --> 
                            </form>     



                        </div>                     
                    </div>  
        </div>
          <!-- 
         <div id="signupbox" style="display:none; margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                     <div class="panel panel-info">
                         <div class="panel-heading">
                             <div class="panel-title">Sign Up</div>
                             <div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" href="#" onclick="$('#signupbox').hide(); $('#loginbox').show()">Sign In</a></div>
                         </div>  
                         <div class="panel-body" >
                             <form id="signupform" class="form-horizontal" role="form">
                                 
                                 <div id="signupalert" style="display:none" class="alert alert-danger">
                                     <p>Error:</p>
                                     <span></span>
                                 </div>
                                     
                                 
                                
                                 <div class="form-group">
                                     <label for="email" class="col-md-3 control-label">Email</label>
                                     <div class="col-md-9">
                                         <input type="text" class="form-control" name="email" placeholder="Email Address">
                                     </div>
                                 </div>
                                     
                                 <div class="form-group">
                                     <label for="firstname" class="col-md-3 control-label">First Name</label>
                                     <div class="col-md-9">
                                         <input type="text" class="form-control" name="firstname" placeholder="First Name">
                                     </div>
                                 </div>
                                 <div class="form-group">
                                     <label for="lastname" class="col-md-3 control-label">Last Name</label>
                                     <div class="col-md-9">
                                         <input type="text" class="form-control" name="lastname" placeholder="Last Name">
                                     </div>
                                 </div>
                                 <div class="form-group">
                                     <label for="password" class="col-md-3 control-label">Password</label>
                                     <div class="col-md-9">
                                         <input type="password" class="form-control" name="passwd" placeholder="Password">
                                     </div>
                                 </div>
                                     
                                 <div class="form-group">
                                     <label for="icode" class="col-md-3 control-label">Invitation Code</label>
                                     <div class="col-md-9">
                                         <input type="text" class="form-control" name="icode" placeholder="">
                                     </div>
                                 </div>
         
                                 <div class="form-group">
                                                                           
                                     <div class="col-md-offset-3 col-md-9">
                                         <button id="btn-signup" type="button" class="btn btn-info"><i class="icon-hand-right"></i> &nbsp Sign Up</button>
                                         <span style="margin-left:8px;">or</span>  
                                     </div>
                                 </div>
                                 
                                 <div style="border-top: 1px solid #999; padding-top:20px"  class="form-group">
                                     
                                     <div class="col-md-offset-3 col-md-9">
                                         <button id="btn-fbsignup" type="button" class="btn btn-primary"><i class="icon-facebook"></i>   Sign Up with Facebook</button>
                                     </div>                                           
                                         
                                 </div>
                                 
                                 
                                 
                             </form>
                          </div>
                     </div>       
          </div> --> 
    </div>
    <div class="footer">
    <center> <p> &copy; <script type="text/javascript"> var year = new Date(); document.write(year.getFullYear());</script> - Information Unit - <a href="https://rugipo.edu.ng"><?php echo $settings['institution_name'];?> </a> For any technical issues send mail to: <?php echo $settings['supportemail'];?></p></center>
    </div>
</body>
</html>
    