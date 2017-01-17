<!DOCTYPE html>
<html>
<head>
     <title>linkZone</title>
	 <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="css/home2.css">
	<link rel="stylesheet" type="text/css" href="css/post_focus.css">
	<link rel="stylesheet" type="text/css" href="css/admin_homepage.css">
	   <script src="js/jquery-3.1.0.min.js"></script>
<script src="ckeditor/ckeditor.js"></script>
	<script src="ckeditor/samples/js/sample.js"></script>
	<link rel="stylesheet" href="ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">
	<script src="js/bootstrap.min.js" type="text/javascript"></script>
</head>
<body>
<?php
 include("connect.php");
	  if(!empty($_SESSION["super"]))
      {      $val=$_SESSION['super'];
	          $q1="select * from user_detail where user_id='$val';";
	         $res1=mysqli_query($con,$q1)or exit("error in query");
	         $row=mysqli_fetch_row($res1);
      }
	  else
	  {
		  header("location:facebook.php");
		  exit();
	  }
	 if(!empty($_GET['logout']))
       {
	    session_destroy();
	     header('location:facebook.php');
	     exit();
       }
?>
<div class='container-fluid'>
<div class='row'>
<div class='col-md-2'>
<?php
include("admin_menu.php");
?>
</div>
<div class='col-md-10'>
<div style='padding:7px;'>
<a href="admin.php?logout=logout" style='float:right;'><i class="fa fa-sign-out">LOGOUT</i></a>
</div>
<div style='height:300px'>
</div>
<div class='rows'>
<div class='col-md-8'>
<div id='post'>
</div>
</div>
<div class='col-md-4'>
<div id='detail'>
</div>
</div>
</div>
</div>
</div>
</body>
</html>	