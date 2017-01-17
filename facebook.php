<html>
<head>
     <title>linkZone</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/custom.css">
	<script src="js/jquery-3.1.0.min.js"></script>
	<script src="js/bootstrap.min.js" type="text/javascript"></script>
</head>
<style>
.error {color: #FF0000;}
</style>
<body>
<?php
session_start();
$con=mysqli_connect("localhost","root","","linkzone")or exit("error in database");
$error="";
if(!empty($_SESSION['super']))
   {
	header("location:admin.php");
	exit();
	
   }
else if(!empty($_SESSION['admin']))
{
	header("location:home2.php");
	exit();
}
else if(!empty($_POST["username"]))
   {  
	  $adminusername=$_POST["username"]; 
	  $adminpassword=$_POST["password"];
      $q="select * from users where username='$adminusername' and password='$adminpassword';";
      $res=mysqli_query($con,$q);
      $count= mysqli_num_rows($res);
      if($count==1)
	  {
         $row=mysqli_fetch_row($res);
		 $_SESSION['admin']=$row[0];
		 if($row[1]=='admin')
		 {    $_SESSION['super']=$row[0];
			 header("location:admin.php");
			 exit();
		 }
		 else{ $_SESSION['admin']=$row[0];
		  header("location:home2.php");
		  exit(); 
		 }
	}
   
   else{
       $error="invalid username and password";
   }		 
   }
?>
<div class="container-fluid">
     <div class= "header">
	      <div class="row">
		  <div class="col-md-2">
		  </div>
		     <div class="col-md-2">
	         <h1 class="logo1">linkZone</h1>
		      </div>
			  <div class="col-md-2">
		       </div>
			   <form action="" method="post" enctype="">
			   <div class="col-md-2" style="margin-top: 0px ;"> 
			    <h4 class="logo1">Username</h4>
				<input type="username" name="username" style="border-radius:5px"><span class = "error"><?php echo $error;?></span>
				<!--<h5 style="color: white"> <input type="checkbox">keep me as login</input></h5>-->
				</div>
			   <div class="col-md-2" style="margin-top:0px;">
			     <h4 class="logo1">Password</h4>
				<input type="Password" name="password" style="border-radius:5px"></input>
				<!--<input type="submit" class="btn btn-info" value="submit">-->
				 <h5><a href="#" style="color: white">Forgotten account?</a></h5>
		       </div>
               <div  class="col-md-1" style="margin-top: 33px">
				<input type="submit" class="btn btn-info" value="Log In" name="submit">
                </div>
                 </form>				
	</div>
	 </div>
	 </div>
	 <?php
	 $fname=$lname=$username=$confirm_username=$password=$gender=$birth_day="";
       $fnameErr=$lnameErr=$usernameErr=$confirmErr=$passwordErr=$genderErr=$birthdayErr="";
 if(!empty($_POST['signup']))
	{ 
			   if(empty($_POST['fname']))
			   {   
				  $fnameErr='required filled';
			   }
			   else
			   { 
		         $fname=($_POST['fname']);
				 if (!preg_match("/^[a-zA-Z ]*$/",$fname)) {
                 $fnameErr = "Only letters and white space allowed";}
		       }
			    if(empty($_POST['lname']))
				  $lnameErr='required filled';
			   else
			   { 
		          $lname=($_POST['lname']);
				  if (!preg_match("/^[a-zA-Z ]*$/",$lname)) {
				  $lnameErr = "Only letters and white space allowed";} 
		       }
			   if(empty($_POST['emailAddr']))
				   $usernameErr='required filled';
			   else
			   { $username=($_POST['emailAddr']); 
		         if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$username)) {
                  $usernameErr = "You Entered An Invalid Email Format"; 
                   }
		       }
			   if(empty($_POST['reenter_mobileno']))
				  $confirm_usernameErr='required field';
			   else
			   { 
		        $confirm_username=($_POST['reenter_mobileno']);
		       }
			   if(empty($_POST["password"])){$passwordErr="required field";}
               else				   
			   {
                     $password =($_POST["password"]);
					if (strlen($_POST["password"]) <= '8') {
						$passwordErr = "Your Password Must Contain At Least 8 Characters!";
					}
					elseif(!preg_match("#[0-9]+#",$password)) {
						$passwordErr = "Your Password Must Contain At Least 1 Number!";
					}
					elseif(!preg_match("#[A-Z]+#",$password)) {
						$passwordErr = "Your Password Must Contain At Least 1 Capital Letter!";
					}
					elseif(!preg_match("#[a-z]+#",$password)) {
						$passwordErr = "Your Password Must Contain At Least 1 Lowercase Letter!";
					}
                }
			   if(empty($_POST['bday']))
				   $birthdayErr='required field';
			   else
			   { 
		         $birth_day=($_POST['bday']);
		       }
			   if(empty($_POST['gender']))
				   $genderErr="required field";
			   else
			   { 
		         $gender=($_POST['gender']);
		       }
			   $preference=$fname." ".$lname;
			   if($username==$confirm_username)
				   {
				    if(($fnameErr=="")&&($lnameErr=="")&&($usernameErr=="")&&($confirm_usernameErr=="")&&($birthdayErr=="")&&($genderErr=="")&&($passwordErr==""))
					{	   
				    $q1="insert into user_detail values('','$fname','$lname','$birth_day','$gender','','','','','','','','','profile_photo/profil-pic_dummy.png','',now(),'','$preference');";
				   mysqli_query($con,$q1)or exit("error in query");
				   $q2="insert into users values('','user','$username','$password',now());";
				    $res=mysqli_query($con,$q2)or exit("error in query");
					$row=mysqli_fetch_row($res);
				    $_SESSION['log']='login';
				    header("location:linkZone_login.php");
					exit();
					}
				   }
				else{
					$confirmErr="username does not match";
				}
	}				
  
?> 
<div class="container-fluid">
	 <div class="section">
	    <div class="row">
		    <div class="col-md-6">
			   <img src="images/1.png" width='100%' style="padding-top:15%; padding-left:10%"></img>
			</div>
			 <div class="col-md-1">
			 </div>
			 <form action="" method="post" enctype="">
			 <div class="col-md-4 content"> 
<form action="" method="post" enctype="" name='form1'>			 
			     <h1> SIGN UP </h1>
				 <h3>It's free and always will be.</h3>
				 <h4>Name</h4>
				   <input name="fname" placeholder="firstname" style=" width: 49%;height:40px">
				   <input name="lname" placeholder="lastname" style=" width: 50%;height:40px"><span class = "error"><?php echo $lnameErr;?></span>
				    <h4>Username</h4>
				   <input name="emailAddr" placeholder="email address" size="" style=" width: 100%; height:40px"><span class = "error"><?php echo $usernameErr;?></span>
				    <h4>Confirm Username</h4>
				   <input name="reenter_mobileno" placeholder="email address"size="" style=" width: 100%; height:40px"><span class = "error"><?php echo $confirmErr;?></span>
				    <h4>Password</h4>
				   <input type="password" name="password" placeholder="New password" size="" style=" width: 100%; height:40px"><span class = "error"><?php echo $passwordErr;?></span>
				   <h4>Birthday</h4>
				   <input type="date" name="bday" placeholder="birthday" style="width: 100%; height: 40px;"><span class = "error"><?php echo $birthdayErr;?></span><br/>
					<h4>Gender</h4>
					<input type="radio" name="gender" value="male">Male</input>
					<input type="radio" name="gender" value="female">Female</input><span class = "error"> <?php echo $genderErr;?></span>
					<!--<a class="link" href="#">Why do i need to provide my dateof birth</a>-->
					<h6>By clicking Sign Up, you agree to our Terms and that you have read<br/> our Data Policy, including our Cookie Use.</h6>
					<input class="btn btn-success btn-lg" style="width: 150px; text-align: center;" name="signup" type="submit" value="Sign up"></input>
					<h5>Create a Page for a celebrity, band or business.</h5>
</form>
	 </div>
	 </div>
</div>
<?php
  include("footer.php");
?>
<script>
function validate(mail) 
{ 
 var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;  
if(mail.value.match(mailformat))  
{   
return true;  
}  
else  
{  
alert("You have entered an invalid email address!");  
document.form1.text1.focus();  
return false;  
} 
}
function check($data) {
                 $data = trim($data);
                $data = stripslashes($data);
                 $data = htmlspecialchars($data);
				return $data;}
</script>
</body>
</html>