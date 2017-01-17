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
	<script src="js/bootstrap.min.js" type="text/javascript"></script>
</head>
<body>
<?php
include("connect.php");
 if(!empty($_SESSION['admin']))
{
	$val=$_SESSION['admin'];
	$q1="select * from user_detail where user_id='$val';";
	$res1=mysqli_query($con,$q1)or exit("error in query1");
	$row=mysqli_fetch_row($res1);
	$q_people="select * from user_detail where user_id!='$val';";
	$res3=mysqli_query($con,$q_people)or exit($q_people);
}
else{
	header("location:facebook.php");
    exit();
}
if(!empty($_GET['cancel_request']))
{
	$id=$_GET['cancel_request'];
	$query="delete from friend_request where sender_id='$val' and destination_id='$id' and request_status='p'";
	$res=mysqli_query($con,$query)or exit($query);
    header("location:friends.php");
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
	  <?php
			echo "<div class='jumbotron about' style='background: white; margin-top: 10px;'>
		    <h3>Friends</h3>";
			   $select_friend="select* from friends where user_id1='$val' or user_id2='$val'";
			   $result_friend=mysqli_query($con,$select_friend)or exit($select_friend);
			    $count_friend=mysqli_num_rows($result_friend);
				$total_count_request=ceil(($count_friend)/4);
			 $idactive_friend=$total_count_request;
			 $active=4;
			 if($idactive_friend==0){$start=0;}else
			 $start=($idactive_friend-1)*$active;
			 $q_request="select * from friend_request where (sender_id='$row[0]' AND request_status='p')LIMIT $start,$active";
	         $result_q=mysqli_query($con,$q_request)or exit($q_request);
				if($count_friend==0)
				{
					echo "no friend now";
				}
			   while($friends=mysqli_fetch_array($result_friend))
			   {  
		           if($friends[1]==$val)
				   {
					$query="select * from user_detail where user_id='$friends[2]'";
					$result=mysqli_query($con,$query)or exit($query);
					$res=mysqli_fetch_row($result);
					echo "<div style='margin: 5px; padding: 5px;'>
						  <img src=".$res[13]." style='width:30%; height: 80px;'>
                      <div style='float: right; width: 65%; height:80px'>						  
			         <h4><a href='user.php?user=$res[0]'>".ucwords($res[17])."</a></h4>
					 </div>
                    </div>";
				   }
				   else
				   {
					$query="select * from user_detail where user_id='$friends[1]'";
					$result=mysqli_query($con,$query)or exit($query);
					$res=mysqli_fetch_row($result);
					echo "<div style='margin: 5px; padding: 5px;'>
						  <img src=".$res[13]." style='width:30%; height: 80px;'>
                      <div style='float: right; width: 65%; height:80px'>						  
			         <h4><a href='user.php?user=$res[0]'>".ucwords($res[17])."</a></h4>
					 </div>
                    </div>";
				   }
                   				   
			   }
          if($idactive_friend>1)
			 {echo "<h5 id='previous' style='color:#0277bd'><i class='fa fa-arrow-left'>previous</i></h5>";}  			   
		  echo "</div>";
		  ?>
		  	  <div class="jumbotron box" style="background: white; margin-top: 10px;">
		<h3>Pending sent Request</h3>
		<?php
		
             $request="select * from friend_request where (sender_id='$row[0]' AND request_status='p')";
	         $result=mysqli_query($con,$request)or exit($request);
             $count_request= mysqli_num_rows($result);
			 $total_count_request=ceil(($count_request)/4);
			 $idactive_pendingrequest=$total_count_request;
			 $active=4;
			 if($idactive_pendingrequest==0){$start=0;}else
			 $start=($idactive_pendingrequest-1)*$active;
			 $q_request="select * from friend_request where (sender_id='$row[0]' AND request_status='p')LIMIT $start,$active";
	         $result_q=mysqli_query($con,$q_request)or exit($q_request);
             if(!empty($count_request))
			 {
			     while($row4=mysqli_fetch_array($result_q))
				{ 
			        $sender="select * from user_detail where user_id='$row4[2]'";
					$res_sender=mysqli_query($con,$sender) or exit($sender);
					$detail=mysqli_fetch_row($res_sender);
			      echo "<div style='margin: 5px; padding: 5px;'>
						  <img src=".$detail[13]." style='width:30%;height: 80px;'>
                      <div style='float: right; width: 65%; height: 80px;'>						  
			         <h4><a href='user.php?user=$detail[0]'>".ucwords($detail[17])."</a></h4>
					 <input type='submit' class='btn btn-primary' value='Sent request'></input>
					 <a href='friends.php?cancel_request=$detail[0]'><input type='submit' class='btn btn-primary' value='cancel'></input></a>
					 </div>
                    </div>";		
				}
			 }
             else
			 {
				 echo "<h5 style='text-align:center'>No pending sent request</h5>";
			 }
			 if($idactive_pendingrequest>1)
			 {echo "<h6 id='previous' style='color:#0277bd'><i class='fa fa-arrow-left'>previous</i></h6>";}
			 echo "</div>";?>
	  </div>
	  <div class='col-md-4'>
	  <div class="jumbotron box" style="background: white; margin-top: 10px;">
		<h3>Friend Request</h3>
		<?php
		
             $request="select * from friend_request where (destination_id='$row[0]' AND request_status='p')";
	         $result=mysqli_query($con,$request)or exit($request);
             $count_request= mysqli_num_rows($result);
			 $total_count_request=ceil(($count_request)/5);
			 $idactive_request=$total_count_request;
			 $active=5;
			 if($idactive_request==0){$start=0;}else
			 $start=($idactive_request*$active)-1;
			 $q_request="select * from friend_request where (destination_id='$row[0]' AND request_status='p')LIMIT $start,$active";
	         $result_q=mysqli_query($con,$q_request)or exit($q_request);
             if(!empty($count_request))
			 {
			     while($row4=mysqli_fetch_array($result_q))
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
			 if($idactive_request>1)
			 {echo "<h6 id='previous' style='color:#0277bd'><i class='fa fa-arrow-left'>previous</i></h6>";}
			 echo "</div>";?>
	   <?php
	      echo "<div class='jumbotron box' style='background: white; margin-top: 5px;'>";
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
	  <div>
  </div>
</div>
<?php
include("footer.php");
?>
</body>
</html>