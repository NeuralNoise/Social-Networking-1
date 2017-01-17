<!DOCTYPE html>
<html>
<head>
     <title>Post</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="css/home2.css">
	<link rel="stylesheet" type="text/css" href="css/post_focus.css">
	<link rel="stylesheet" type="text/css" href="css/profile.css">
    <script src="js/jquery-3.1.0.min.js"></script>
	<script src="js/bootstrap.min.js" type="text/javascript"></script>
	<script src="ckeditor/ckeditor.js"></script>
	<script src="ckeditor/samples/js/sample.js"></script>
	<link rel="stylesheet" href="ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">
	 </head>
<body>
<?php
include("connect.php");
if(!empty($_SESSION['admin']))
{   $val=$_SESSION['admin'];
	$q1="select * from user_detail where user_id='$val';";
	$res1=mysqli_query($con,$q1)or exit($q1);
	$row=mysqli_fetch_row($res1);
	$q3="select * from post_detail where user_id='$val' ORDER BY Sno desc;";
	$res3=mysqli_query($con,$q3)or exit($q3);
	$q_liked="select * from like_table join post_detail ON like_table.post_id=post_detail.sno and like_table.user_liking_id='$val' ORDER BY like_table.current_date_time desc;";
	$res_liked=mysqli_query($con,$q_liked)or exit($q_liked);

}
else{
	header("location:facebook.php");
    exit();
}
  include("user_header.php");
if(!empty($_POST['submit_post1']))
	{   
	  /*$descrip=mysqli_real_escape_string($con,$_POST['check']);*/
	  $des=$_POST['check'];
	  $query="insert into post_detail values('','$row[0]','','$des',now())";
	  mysqli_query($con,$query)or exit ($query);
						  
	}
?>
<div class="container-fluid">
  <div class="row">
      <div class="col-md-3">
	   <?php
	 include("icons.php");
	 ?>
	  </div>
	  <div class="col-md-9">
	       <div class="panel-group" id="accordion">
		   <div class="panel panel-default" style='border:none;'>
		    <a data-toggle="collapse" data-parent="#accordion" href="#addpost"><button class ='btn btn-primary'>Add Post</button></a>
			<a data-toggle="collapse" data-parent="#accordion" href="#viewpost"><button class='btn btn-primary'>View Post</button></a>
			<a data-toggle="collapse" data-parent="#accordion" href="#likedpost"><button class='btn btn-primary'>View liked Post</button></a>
			  <div id="addpost" class="panel-collapse collapse in">
			  <?php
			    echo "<div class='jumbotron box' style='background: white;'>
	               <form action='' method='POST' enctype='multipart/form-data'>
				     <div class='panel-group' id='accordion1'>
		   <div class='panel panel-default' style='border:none;'>
		   <a data-toggle='collapse' data-parent='#accordion1' href='#audio'><button class='btn btn-primary'>Add Photo</button></a>
		   <a data-toggle='collapse' data-parent='#accordion1' href='#video'><button class='btn btn-primary'>Add video</button></a>
		     <div id='audio' class='collapse'><input type='file' name='image'></div>
			 <div id='video' class='collapse' style='padding: 10px;'><h5>
			 <h6 style='color:red'>Only Youtube Embed Url Are Valid To Post</h6>
			 Video Url:-<input type='url' name='video' placeholder='URL' style='width:90%;border-radius:2px; height:25px;'></h5></div></div></div>
			       <div style='margin-top: 5px;'>
		           <textarea id='editor' name='check' > your friends timeline show's here........
			      </textarea>
				   </div></br>
				    <input type='submit' name='submit_post1' class='btn btn-info' value='post' style='float: right'>";  
	          	
                if(!empty($_POST['submit_post1']))
				{				
				       if(!empty($_POST['check']))
						{  $event= $_POST['check'];
						}
						else{
						$event="";}
				
					   if(!empty($_FILES['image']['name']))
							{
							$img=$_FILES['image']['name'];	
							$size=$_FILES['image']['size'];
							$type=$_FILES['image']['type'];
							$error=$_FILES['image']['error'];
							$tmp_name=$_FILES['image']['tmp_name'];
							$location="upload/".rand(0,1000).$img;
							move_uploaded_file($tmp_name,$location);
				     }else{$location="";}
				
					$w= "insert into post_detail values('','$row[0]','".str_replace("'","\'",$event)."','$location',now())";
					  mysqli_query($con,$w) or exit($w);
				}
				  
			   echo "</div> </form>";
			  ?>
			  </div>
			  <div id="viewpost" class="panel-collapse collapse">
			  <?php
			  $count_post=mysqli_num_rows($res3);
			  if($count_post==0){
		       echo "<h3 style='color: red;'>Dear ".ucwords($row[17]).", currently you are posted nothing.keep smiling, keep posting</h3>";}
	            while($row3=mysqli_fetch_array($res3))
				{	
                    $like="select * from like_table where post_id='$row3[0]'";
	                $res_like=mysqli_query($con,$like)or exit($like);
                     $count_like= mysqli_num_rows($res_like);
                    $unlike="select * from unlike_table where post_id='$row3[0]'";
	                $res_unlike=mysqli_query($con,$unlike)or exit($unlike);
                     $count_unlike= mysqli_num_rows($res_unlike);					 			
	              echo "<div class='jumbotron box' style='width:45%;float: left;
					margin: 10px;'><a><i class='fa fa-edit aria-hidden=''true'></i>edit</a><br><span rows='3'>"
		          .$row3[2]."<span></br>";
				  if(!empty($row3[3]))
				 { 
			         echo "<img src='$row3[3]' style='width:100%; height:200px'>";
				 } echo  "</br>
				 <a href='home2.php?like=$row3[0]'><i class='fa fa-thumbs-up ' aria-hidden='true' style='text-shadow:2px 2px 2px grey; font-size:20px; color: #388e3c;'></i></a>&nbsp".$count_like."&nbsp
				  <a href='home2.php?unlike=$row3[0]'><i class='fa fa-thumbs-down ' aria-hidden='true' style='text-shadow:2px 2px 2px grey; font-size:20px; color: #e57373;'></i>
				  </a>&nbsp".$count_unlike."&nbsp
				  <a href=''><i class='fa fa-comment' aria-hidden='true' style='text-shadow:2px 2px 2px grey; font-size:20px;'></i>Comment</a><span style='float: right'>"
				  .date_format(date_create($row3[4]),'d-M-y h:i a')
				  ."</span>
				  </div>";
		        }?>
			  </div>
			  <div id="likedpost" class="panel-collapse collapse">
			  <?php
	            while($row3=mysqli_fetch_array($res_liked))
				{	
                    $like="select * from like_table where post_id='$row3[2]'";
	                $res_like=mysqli_query($con,$like)or exit($like);
                     $count_like= mysqli_num_rows($res_like);
                    $unlike="select * from unlike_table where post_id='$row3[2]'";
	                $res_unlike=mysqli_query($con,$unlike)or exit($unlike);
                     $count_unlike= mysqli_num_rows($res_unlike);
                     $q_details="select * from user_detail where user_id='$row3[6]'";
                     $res_detail=mysqli_query($con,$q_details)or exit($q_details);
                     $detail=mysqli_fetch_row($res_detail);					 
	              echo "<div class='jumbotron box' style='width:45%;float: left;
					margin: 10px;'>";
					if($row3[1]==$row3[6])
					{
					echo "<a style='float: right'><i class='fa fa-edit aria-hidden=''true'></i>edit</a>";}
					echo " <div style='float: left; width:15%; height: 40px''>
				  <img src='$detail[13]' style='width:100%; height: 100%'>
				  </div>
				  <div style='float: left; margin-left:5px;'>"
		          .ucwords($detail[17])."<br>".date_format(date_create($row3[9]),'d-M-y h:i a')."<hr>".$row3[7]."</div>";
				  if(!empty($row3[8]))
				 { 
			         echo "<img src='$row3[8]' style='width:100%; height:200px'>";
				 } echo  "</br>
				 <a href='home2.php?like=$row3[2]'><i class='fa fa-thumbs-up ' aria-hidden='true' style='text-shadow:2px 2px 2px grey; font-size:20px; color: #388e3c;'></i></a>&nbsp".$count_like."&nbsp
				  <a href='home2.php?unlike=$row3[2]'><i class='fa fa-thumbs-down ' aria-hidden='true' style='text-shadow:2px 2px 2px grey; font-size:20px; color: #e57373;'></i>
				  </a>&nbsp".$count_unlike."&nbsp
				  <a href=''><i class='fa fa-comment' aria-hidden='true' style='text-shadow:2px 2px 2px grey; font-size:20px;'></i>Comment</a>
				  </span>
				  </div>";
				}
               ?>			    
			  </div>
			 </div>
			  </div>
	  </div>
</div>
</div>
<?php
include("footer.php");
?>
<script>
	initSample();
</script>
</body>
</html>