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
	$row=mysqli_fetch_row($res1);
	$q2="select *,DATE(post_date)-DATE(now()) from post_detail ORDER BY Sno desc;";
	$res2=mysqli_query($con,$q2)or exit("error in query2");
	$q3="select * from user_detail where user_id!='$val';";
	$res3=mysqli_query($con,$q3)or exit($q3);
}
else{
	header("location:facebook.php");
    exit();
}
if(!empty($_GET['logout1']))
{
	 session_destroy();
	 header('location:facebook.php');
	 exit();
 }
 if(!empty($_GET['profile']))
{
	 $_SESSION['admin'];
	 header('location:profile.php');
	 exit();
 }
 if(!empty($_GET['post']))
{
	 $_SESSION['admin'];
	 header('location:post.php');
	 exit();
 }
 if(!empty($_GET['like']))
 {
	$like=$_GET['like']; 
	$q6="select * from like_table where (post_id='$like' AND user_liking_id='$row[0]')";
	$res6=mysqli_query($con,$q6)or exit($q6);
      $count= mysqli_num_rows($res6);
      if(!empty($count))
	  {
        $delete="delete from like_table where (post_id='$like' AND user_liking_id='$row[0]')";
	    $res_delete=mysqli_query($con,$delete)or exit($delete);
        header('location:home2.php');
        exit();		
	  }
	  else
	  {
		$q5="insert into like_table values('','$row[0]','$like','1',now())";
        mysqli_query($con,$q5)or exit($q5);
        header('location:home2.php');
        exit();		
	  }
 }
 if(!empty($_GET['unlike']))
 {
	$unlike=$_GET['unlike']; 
	$q6="select * from unlike_table where (post_id='$unlike' AND user_disliking_id='$row[0]')";
	$res6=mysqli_query($con,$q6)or exit($q6);
      $count= mysqli_num_rows($res6);
      if(!empty($count))
	  { 
          $delete="delete from unlike_table where (post_id='$unlike' AND user_disliking_id='$row[0]')";
	     $res_delete=mysqli_query($con,$delete)or exit($delete);
		  header('location:home2.php');
        exit();
	  }
	  else
	  {
		$q5="insert into unlike_table values('','$row[0]','$unlike','1',now())";
        mysqli_query($con,$q5)or exit($q5);
        header('location:home2.php');
        exit();		
	  }
 }
  if(!empty($_GET['send_request']))
 {
	$send=$_GET['send_request']; 
	$q6="select * from friend_request where (destination_id='$send' AND sender_id=$row[0]) or(destination_id='$row[0]' AND sender_id='$send') ";
	$res6=mysqli_query($con,$q6)or exit($q6);
      $count= mysqli_num_rows($res6);
      if(!empty($count))
	  { 
         
	  }
	  else
	  {
		$q5="insert into friend_request values('','$row[0]','$send','p','',now())";
        mysqli_query($con,$q5)or exit($q5);
		header('location:home2.php');
        exit();
        		
	  }
 }
 if(!empty($_GET['accept_request']))
 {
	$accept=$_GET['accept_request'];
    $status="update friend_request set request_status='a',accepting_time=now() where sender_id='$accept' and destination_id='$row[0]'";
    mysqli_query($con,$status)or exit($status);
    $query="select * from friend_request where sender_id='$accept' and destination_id='$row[0]' and request_status='a'";
	$result_query=mysqli_query($con,$query)or exit($query);
	 $result=mysqli_fetch_row($result_query);
    $insert_query="insert into friends values('','$result[1]','$result[2]',now())";
	mysqli_query($con,$insert_query)or exit($insert_query);
	header('location:home2.php');
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
	    <div class="jumbotron box" style="background: white; margin-top: 5px;";>
	     <form action="home2.php" method="POST" enctype="multipart/form-data">
		    <div class="panel-group" id="accordion">
		   <div class="panel panel-default" style='border:none;'>
		   <a data-toggle="collapse" data-parent="#accordion" href="#audio"><button class="btn btn-primary">Add Photo</button></a>
		   <a data-toggle="collapse" data-parent="#accordion" href="#video"><button class="btn btn-primary">Add video</button></a>
		     <div id='audio' class='collapse'><input type='file' name='image'></div>
			 <div id='video' class='collapse'>video url:-<input type='url' name='video' placeholder='url'></div></div></div>
		     <div style="margin-top: 5px;">
		        <textarea id='editor' style="width:100%;" rows="5" name='check'>your timeline show's here........
			    </textarea>
				</div></br>
				<input type="submit" name="submit" class="btn btn-info" value="post" style="float: right"></input>
			    </br></form>
		</div>
		<?php  
	          	
                if(!empty($_POST['submit']))
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
					  mysqli_query($con,$w);				
				}
              	while($row2=mysqli_fetch_array($res2))
				{  $q4="select * from user_detail where user_id='$row2[1]';";
	              $res4=mysqli_query($con,$q4)or exit("error in query1");
	               $row4=mysqli_fetch_row($res4);
                    $like="select * from like_table where post_id='$row2[0]'";
	                $res_like=mysqli_query($con,$like)or exit($like);
                     $count_like= mysqli_num_rows($res_like);
                    $unlike="select * from unlike_table where post_id='$row2[0]'";
	                $res_unlike=mysqli_query($con,$unlike)or exit($unlike);
                     $count_unlike= mysqli_num_rows($res_unlike);
                   $query_comment="select * from comment where post_id='$row2[0]'";
						$result=mysqli_query($con,$query_comment)or exit($query_comment);
						$count_comment=mysqli_num_rows($result);
       $total_comment=ceil($count_comment/4);
       $idactive=$total_comment;
$active=4;
if($idactive==0){$start=0;}else
$start=($idactive-1)*$active;	
$q_comment="select * from comment where post_id='$row2[0]' LIMIT $start,$active";
						$result_c=mysqli_query($con,$q_comment)or exit($q_comment);				   
	              echo "<div class='jumbotron box' style='margin-top: 5px;'>
				  <div style='float: left; width:15%; height: 15%''>
				  <img src='$row4[13]' style='width:100%; height: 100%'>
				  </div>
				  <div style='float: left; margin-left:5px;'>"
		          .ucwords($row4[17])."<br>".date_format(date_create($row2[4]),'d-M-y h:ia')."<hr>
				  <div><h5 align='justify' style='word-break: break-all;'>$row2[2]</h5></div></div>";
				 if(!empty($row2[3]))
				 { 
			         echo "<img src='$row2[3]' style='width:100%; height:270px'>";
					
				 } 
				 echo "</br></br>
				<div class='panel-group' id='comment$row2[0]' style='clear:left;'>
				 <a href='home2.php?like=$row2[0]'><i class='fa fa-thumbs-up' aria-hidden='true' style='text-shadow:2px 2px 2px grey; font-size:20px; color: #388e3c; '></i></a>&nbsp";
				  echo $count_like;				  
				  echo "&nbsp<a href='home2.php?unlike=$row2[0]'><i class='fa fa-thumbs-down' aria-hidden='true' style='text-shadow:2px 2px 2px grey; font-size:20px; color: #e57373;'></i></a>&nbsp";
				  echo $count_unlike;
				  echo "&nbsp
                        <a data-toggle='collapse' data-parent='#comment$row2[0]' href='#collapseOne$row2[0]'><i class='fa fa-comment' aria-hidden='true' style='text-shadow:2px 2px 2px grey; font-size:20px;'></i>Comments&nbsp".$count_comment."
                        </a>
                  <div id='collapseOne$row2[0]' class='panel-collapse collapse'>
                    <div class='panel-body'>
					<div>
					<div id='btn$row2[0]'>";
					if($idactive>1)
					echo "<h6 id='previous$row2[0]' style='color:#0277bd'><i class='fa fa-arrow-left'>previous</i></h6>";
						while($res=mysqli_fetch_array($result_c))
						{   $query_user="select * from user_detail where user_id=$res[2]";
                          $result_user=mysqli_query($con,$query_user)or exit($query_user);
	                        $user=mysqli_fetch_row($result_user);
							echo "<div style='clear:left;'>
							<div style='float: left; width:15%; height: 15%'>
				           <img src='$user[13]' style='width:100%; height: 100%'>
						  </div>
						  <div style='float: left; margin-left:5px; width:80%;'><div style='color:#0277bd;font-size:15px;'>"
						  .ucwords($user[17]);
						  if($res[4]!='p'){
							$q_reply="select * from user_detail where user_id='$res[4]'";
							$res_q=mysqli_query($con,$q_reply)or exit($q_reply);
							$reply_user=mysqli_fetch_row($res_q);
						  echo "&nbsp<i class='fa fa-reply fa-rotate-180'></i>&nbsp".ucwords($reply_user[17]);
						}
						  echo"</div><div style='clear:left'><h5 align='justify' style='word-break: break-all;'>$res[3]</h5></div>";
						  if($res[2]!=$row[0]){
						  echo "<div class='panel-group' id='reply$row2[0]$res[0]'>
						  <div class='panel panel-default' style='border: none;background:#eee'>
						  <a data-toggle='collapse' data-parent='#reply$row2[0]$res[0]' href='#replypost$row2[0]$res[0]'><h6 style='color:#0277bd'><i class='fa fa-reply fa-rotate-180'></i>reply</h6></a>
						 <div id='replypost$row2[0]$res[0]' class='collapse'>
						  <div style='margin-top:7px;'>
						  <img src='$row[13]' style='width:15%; height:40px; float: left'>
					       <form name='form1'>
						   <textarea id='$row2[0]$res[0]' style='width: 70%; height: 40px; float: left;'></textarea>
					      <button class='btn btn-primary btn-sm' id='btnn$row2[0]$res[0]'>post</button></form></div>
						 </div>
						 <script>
						   $(document).ready(function() {
							$('#btnn$row2[0]$res[0]').click(function(e) {
								e.preventDefault();
								$.ajax({
									type: 'POST',
									url: 'comment.php',
									data: {comment: $('#$row2[0]$res[0]').val(),user_id:$row[0],post_id:$row2[0],reply_id:$user[0],idactive: $idactive,t:$total_comment},
									success: function(data)
									{
										$('#btn$row2[0]').html(data);
									}
								});
							});
$('#previous$row2[0]').click(function(e) {
e.preventDefault();
								$.ajax({
									type: 'POST',
									url: 'comment.php',
									data: {idactive: $idactive-1,post_id:$row2[0],t:$total_comment},
									success: function(data)
									{
										$('#btn$row2[0]').html(data);
									}
								});
							});	});				   
						</script> 
						  </div>
						  </div>";}
						  else{echo"<h6 id='delete$row2[0]$res[0]' style='color:#0277bd'>delete</h6>";
						  echo "<script>$(document).ready(function() {
						   $('#delete$row2[0]$res[0]').click(function(e) {
							e.preventDefault();
$.ajax({
type: 'POST',
url: 'comment.php',
data: {comment_id:$res[0],post_id:$row2[0],t:$total_comment,idactive: $idactive},
success: function(data)
{
$('#btn$row2[0]').html(data);
}
});
							});
						
						   });</script>";
						  
						  }
						  echo"</div>";
						  echo"</div>";
						}
					if($idactive<($total_comment)){
					echo "<h6 id='next$row2[0]$idactive' style='color:#0277bd'>next<i class='fa fa-arrow-right'></i></h6>";}
echo"<script>
$(document).ready(function(){
$('#next$row2[0]$idactive').click(function(e) {
								e.preventDefault();
								$.ajax({
									type: 'POST',
									url: 'comment.php',
									data: {idactive: $idactive+1,post_id:$row2[0],t:$total_comment},
									success: function(data)
									{
										$('#btn$row2[0]').html(data);
									}
								});
							});
				});

</script>";					
				     echo "</div>
					<div style='margin-top:7px;clear:left;'><img src='$row[13]' style='width:15%; height:40px; float: left'>
					<form name='form1'><textarea id='$row2[0]' style='width: 70%; height: 40px; float: left;'></textarea>
					<button class='btn btn-primary btn-sm' id='btnn$row2[0]'>post</button></form></div>
					</div>
					</div>
				  <script>
					  $(document).ready(function() {
							$('#btnn$row2[0]').click(function(e) {
								e.preventDefault();
								$.ajax({
									type: 'POST',
									url: 'comment.php',
									data: {comment: $('#$row2[0]').val(),idactive: $idactive,user_id:$row[0],post_id:$row2[0],reply_id:'p',t:$total_comment},
									success: function(data)
									{
										$('#btn$row2[0]').html(data);
									}
								});
							});
						});

                 </script>
				  </div>";
				  
				  

				  echo "</div>";
				 echo "</div>";
		        }		 
		?>
	  </div>
	  <div class="col-md-4">
	    <div class="jumbotron box" style="background: white; margin-top: 10px;">
		<h3>Friend Request</h3>
		<?php
		
             $request="select * from friend_request where (destination_id='$row[0]' AND request_status='p')";
	         $result=mysqli_query($con,$request)or exit($request);
             $count_request= mysqli_num_rows($result);
             if(!empty($count_request))
			 {
			     while($row4=mysqli_fetch_array($result))
				{ 
			        $sender="select * from user_detail where user_id='$row4[1]'";
					$res_sender=mysqli_query($con,$sender) or exit($sender);
					$detail=mysqli_fetch_row($res_sender);
			      echo "<div style='margin: 5px; padding: 5px;'>
						  <img src=".$detail[13]." style='width:30%; height: 80px;'>
                      <div style='float: right; width: 70%; height:80px'>						  
			         <h4><a href='user.php?user=$detail[0]'>".ucwords($detail[17])."</a></h4>
					 <a href='home2.php?accept_request=$detail[0]'><input type='submit' class='btn btn-primary' value='Accept'></input></a>
					 <input type='submit' class='btn btn-primary' value='not now'></input>
					 </div>
                    </div>";		
				}
			 }
             else
			 {
				 echo "<h5 style='text-align:center'>No pending request</h5>";
			 }
			 echo "</div>
			 <div class='jumbotron box' style='background: white; margin-top: 5px;'>";
             echo "<h3>People You May Know</h3>";			 
		     
		        while($row3=mysqli_fetch_array($res3))
				{ 
			       $q_friend="select * from friend_request where (sender_id='$val' and destination_id='$row3[0]') or(sender_id='$row3[0]' and destination_id='$val')";
				   $res_friend=mysqli_query($con,$q_friend) or exit($q_friend);
				   $count=mysqli_num_rows($res_friend);
				   if($count==0)
				   {
			      echo "<div style='margin: 5px; padding: 5px;'>
						  <img src='$row3[13]' style='width:30%; height: 80px;'>
                      <div style='float: right; width: 70%; height:80px'>						  
			         <h4><a href='user.php?user=$row3[0]'>".ucwords($row3[17])."</a></h4>
					 <a href='home2.php?send_request=$row3[0]'><input type='submit' class='btn btn-primary' value='Send request'></input>
					 <a href='home2.php?cancel_request=$row3[0]'><input type='submit' class='btn btn-primary' value='Not now'></input></a>
					 </div>
                    </div>	";
				   }					
				}
		?>
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
<script>
  $(document).ready(function() {
        $('#postcomment').click(function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'comment.php',
                data: {test:8},
                success: function(data)
                {
                    $("#yes").html(data);
                }
            });
        });
    });

</script>
</body>
</html>