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
	   <div id='page'>
	   <?php
	   $q_page="select* from pages_member where member_id='$row[0]'";
	   $result=mysqli_query($con,$q_page)or exit($q_page);
	   $count=mysqli_num_rows($result);
	   if($count==0){
		   echo "<h4 style='color: red'>Currently you are not liked any page</h4>";
		   
	   }
	   else{}
		?>	
		
	   </div>
	 </div>
	 <div class='col-md-4'>
	 <div class="panel-group" id="accordion">
     <div class="panel panel-default" style='border:none;'>
	 <a data-toggle="collapse" data-parent="#accordion" href="#create"><button class ='btn btn-primary'>Create Page</button></a>
			<a data-toggle="collapse" data-parent="#accordion" href="#viewgroups"><button class='btn btn-primary'>Liked Page</button></a>
			<a data-toggle="collapse" data-parent="#accordion" href="#admingroups"><button class='btn btn-primary'>Your Created Page</button></a>
			<div id="create" class="panel-collapse collapse" style='margin-top:50px;'>
                  <div class="jumbotron box" style='margin-top: 5px;'>
				  <div id='msg' style='word-break: break-all;'>
				     <h2 style='text-align:center;color:#0277bd'>Create A New Page</h2>
					 <h4>Page Title</h4>
					   <input type='text' id='title' class='inputtext'>
					   <h4>Page Description</h4>
					   <textarea id='editor1' class='inputtext' style='height:30%'></textarea>
					   <button id='create_page' class='btn btn-primary btn-sm' style='float:right;margin-top:5px;'>Create</button></div>
				  </div>
				  </div>
		<div id="admingroups" class="panel-collapse collapse" style='margin-top:40px;margin-bottom:50px;'>
			     <?php
		     $q_created="select * from groups where created_id='$row[0]'";
			$result_created=mysqli_query($con,$q_created)or exit($q_created);
		    while($res_c=mysqli_fetch_array($result_created))
			{
			 echo"<div class='box' style='width:47%;float:left;margin-left:10px;'><img src='$res_c[4]' style='width:100%; height:150px'></img>
			<h4>".ucwords($res_c[1])."</h4><h6 style='word-break: break-all;'>$res_c[2]</h6>
			<button id='view_created$res_c[0]' class='btn btn-primary' style='width:100%'>View Page</button>
			</div>";
echo "<script>
$(document).ready(function(){
$('#view_create$res_c[0]').click(function(e) {
e.preventDefault();
$.ajax({
type: 'POST',
url: 'changes.php',
data: {page_id:$res_c[0]},
success: function(data)
{
$('#page').html(data);
}
});
});	});
</script>";		
			}
			?>			    
			</div>
			 <div id="viewgroups" class="panel-collapse collapse in" style='margin-top:40px;'>
				     <?php
					  $q_group="select * from groups";
					  $result=mysqli_query($con,$q_group)or exit($q_group);
					  while($res=mysqli_fetch_array($result))
					  {
					$q_likedgroups="select * from pages_member where page_id='$res[0]' and member_id='$row[0]'";
					$result_liked=mysqli_query($con,$q_likedgroups)or exit($q_likedgroups);
	               $count_liked=mysqli_num_rows($result_liked);
	               if($count_liked==1){
					   echo"<div class='box' style='width:47%;float:left;margin-left:10px;'><img src='$res[4]' style='width:100%; height:150px'></img>
					   <h4>".ucwords($res[1])."</h4>
					   <div class='panel-group' id='suggest_description$res[0]'>
					   <div class='panel panel-default' style='border:none'>
					   <a data-toggle='collapse' data-parent='#suggest_description$res[0]' href='#viewsuggest_description$res[0]'>About $res[1]</a>
					   <div id='viewsuggest_description$res[0]' class='collapse'>
					   <h6 style='word-break: break-all;'>$res[2]</h6></div></div></div>
					   <button id='page_member$res[0]' class='btn btn-primary' style='width:48%'><i class='fa fa-users'></i>member</button>
				   <button id='view_page$res[0]' class='btn btn-primary' style='width:48%'>View Page</button></div>";}   
					  }
				   ?>
				   </div> 
			</div></div>
	 <?php
			  echo "<h3 style='margin-top:40px;clear:left;color:#0277bd'>Suggested Pages</h3>";
			 $q_group="select * from groups";
					  $result=mysqli_query($con,$q_group)or exit($q_group);
					  while($res=mysqli_fetch_array($result))
					  {
					$q_likedgroups="select * from pages_member where page_id='$res[0]' and member_id='$row[0]'";
					$result_liked=mysqli_query($con,$q_likedgroups)or exit($q_likedgroups);
	               $count_liked=mysqli_num_rows($result_liked);
	               if($count_liked!=1){
					   echo"<div class='box' style='width:47%;float:left;margin-left:10px;'><img src='$res[4]' style='width:100%; height:150px'></img>
					   <h4>".ucwords($res[1])."</h4>
					   <div class='panel-group' id='accordian_description$res[0]'>
					   <div class='panel panel-default' style='border:none'>
					   <a data-toggle='collapse' data-parent='#accordian_description$res[0]' href='#view_description$res[0]'>About $res[1]</a>
					   <div id='view_description$res[0]' class='collapse'>
					   <h6 style='word-break: break-all;'>$res[2]</h6></div></div></div>
					   <button id='page_member$res[0]' class='btn btn-primary' style='width:48%'><i class='fa fa-users'></i>+Join</button>
					  <button id='view_page$res[0]' class='btn btn-primary' style='width:48%'>View Page</button></div>";}
echo"<script>
$(document).ready(function(){
$('#view_page$res[0]').click(function(e) {
e.preventDefault();
function testAjax(handledata){
$.ajax({
type: 'POST',
url: 'changes.php',
data: {page_id:$res[0]},
success: function(data)
{
handleData(data);
} }
});
});
$('#page_member$res[0]').click(function(e) {
e.preventDefault();
$.ajax({
type: 'POST',
url: 'changes.php',
data: {page_id:$res[0],user_id:$row[0]},
success: function(data)
{
$('#page').html(data);
}
});
});	
});
</script>";						  
					}
				  ?>
	 </div>
</div>
</div>
<?php
echo "<script>
	initSample();
</script>
";
echo "<script>
$(document).ready(function() {
$('#create_page').click(function(e) {
e.preventDefault();
$.ajax({
type: 'POST',
url: 'changes.php',
data: {title: $('#title').val(),description: $('#editor1').val()},
success: function(data)
{
$('#msg').html(data);
}
});
});						
});
</script>";
include("footer.php");
?>
</body>
</html>