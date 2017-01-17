<!DOCTYPE html>
<html>
<head>
     <title>linkZone</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="css/home2.css">
	<link rel="stylesheet" type="text/css" href="css/post_focus.css">
	<link rel="stylesheet" type="text/css" href="css/profile.css">
    <script src="js/jquery-3.1.0.min.js"></script>
<script src="ckeditor/ckeditor.js"></script>
	<script src="ckeditor/samples/js/sample.js"></script>
	<link rel="stylesheet" href="ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">
	<script src="js/bootstrap.min.js" type="text/javascript"></script>
</head>
<body>
<?php
include("connect.php");
if(!empty($_SESSION['admin']))
{   $val=$_SESSION['admin'];
	$q1="select * from user_detail where user_id='$val';";
	$res1=mysqli_query($con,$q1)or exit("error in query1");
$row=mysqli_fetch_row($res1);}
else
{ header("location:facebook.php");
exit();}
 if(!empty($_GET['prefer_save']))
  { 
	  $prefer=$_GET['prefer'];
	  if($prefer=='Nickname')
	  { 
		$q_prefer="update user_detail set preference_status='$row[16]' where user_id='$row[0]'";  
	  }
	  else{
		  $name=$row[1]." ".$row[2];
		$q_prefer="update user_detail set preference_status='$name' where user_id='$row[0]'"; 
	  }
	  mysqli_query($con,$q_prefer)or exit($q_prefer);
	   header("location:settings.php");
	   exit();
	  
  }
include("user_header.php");	
?>
<div class="container-fluid">
  <div class="row">
      <div class="col-md-3">
	 <?php
	 include("icons.php");
	 ?>
	  </div>
	 <div class='col-md-5'>
	 <div class='jumbotron box' style='background: white; margin-top: 5px;'>
	   <h4 style='font-size:22px'>Change Username And Password</h4>
        <?php 
		  $query_user="select * from users where user_id='$val'";
		  $result=mysqli_query($con,$query_user)or exit($query_user);
		  $res=mysqli_fetch_row($result);
		  echo "<div class='panel group' id='changeusername'>
		  <div class='panel-default'>".
		  $res[2]."<a data-toggle='collapse' data-parent='#changeusername' href='#username' style='word-break: break-all;'><i class='fa fa-edit' style='float:right;color:blue;'>change username</i></a>
		  <div id='username' class='collapse'>
		  <div class='jumbotron'> <div id='msg1'></div>Enter current password-</br>
		   
		   <input type='password' id='current_password1'class='inputtext'/>
		   Enter new username-</br>
		   <input type='text' id='new_username' class='inputtext'/>
		  Re-enter new username-</br>
		   <input type='text' id='reenter_new_username' class='inputtext''/></br>
		   <button id='changeusername_button' class='btn btn-primary btn-sm' style='float:right;'>Save</button></div>
		  </div></div></div>";
		  echo "<div class='panel group' id='changepassword'>
		  <div class='panel-default'>".
		  md5($res[3])."<a data-toggle='collapse' data-parent='#changepassword' href='#password' style='word-break: break-all;'><i class='fa fa-edit' style='float:right;color:blue;'>change password</i></a>
		  <div id='password' class='collapse'>
		   <div class='jumbotron'> <div id='msg'></div>Enter Current Password-</br>
		   
		   <form><input type='password' id='current_password' class='inputtext'/>
		   Enter new Password-</br>
		   <input type='password' id='new_password' class='inputtext'/>
		  Re-enter new Password-</br>
		   <input type='password' id='reenter_new_password'class='inputtext'/>
		   <button id='changepassword_button' class='btn btn-primary btn-sm' style='float:right;'>Save</button></form></div>
		  </div></div></div>";
		?>	   
	 </div>
     </div>
     <div class='col-md-4'>
	    <div class='jumbotron box' style='background: white; margin-top: 5px;'>
		  <h4 style='font-size:22px'>Select Your Preference Which You Want To Show Others-</h4>
			  <h4>
			  <form action='' method='' enctype='' id='prefernce'>
			  <input type='radio' value='<?php echo $row[16];?>' name='radio1' <?php 
			  if($row[16]==$row[17])
			  {echo "checked";}
		      else{
				  if(empty($row[16])) 
				  {echo "disabled";}
			  }
			  ?> ><?php echo $row[16];?></br>
			  <input type='radio' value='<?php echo $row[1]." ".$row[2];?>' name='radio1'<?php if($row[16]!=$row[17]){echo "checked";}?> ><?php echo ucwords($row[1]." ".$row[2]); ?></br></br>
			<input id='prefer_button' class='btn btn-success btn-sm' type='submit' value='Update' style='float: right;'></input></form>
			  </h4><p id='demo'></p>
		</div>
     </div>
</div>
</div>
<?php
include("footer.php");
?>
<?php
if(!empty($_POST['id1'])){
	echo"done";
}
?>
<script>
 $(document).ready(function(){
$('#changepassword_button').click(function(e){
e.preventDefault();
$.ajax({
type: 'POST',
url: 'changes.php',
data: {current: $('#current_password').val(),id2: $('#new_password').val(),id3: $('#reenter_new_password').val()},
success: function(data)
{
$('#msg').html(data);
}
});
});
$('#changeusername_button').click(function(e){
e.preventDefault();
$.ajax({
type: 'POST',
url: 'changes.php',
data: {current1: $('#current_password1').val(),id2: $('#new_username').val(),id3: $('#reenter_new_username').val()},
success: function(data)
{
$('#msg1').html(data);
}
});
});
$('#prefer_button').click(function(e){
	var value=$("input[name='radio1']:checked").val();
e.preventDefault();
$.ajax({
type: 'POST',
url: 'changes.php',
data: {prefer1: value},
success: function(data)
{
$('#confirm').html(data);
}
});
});		
});  
</script>
</body>
</html>	 
	