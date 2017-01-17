<html>
<head>
     <title>linkZone Profile</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<script src="ckeditor/ckeditor.js"></script>
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="css/home2.css">
	<link rel="stylesheet" type="text/css" href="css/profile.css">
	<!--<script src="js/jquery-3.1.0.min.js"></script>-->
	<!--<script src="js/bootstrap.min.js" type="text/javascript"></script>
	<link rel="stylesheet" href="vlb_files1/vlightbox1.css" type="text/css" />
		<link rel="stylesheet" href="vlb_files1/visuallightbox.css" type="text/css" media="screen" />
<script src="vlb_engine/jquery.min.js" type="text/javascript"></script>
		<script src="vlb_engine/visuallightbox.js" type="text/javascript"></script>-->
		<script src='js/jquery-3.1.0.min.js'></script>
<script src='js/bootstrap.min.js' type='text/javascript'></script>
	<link rel='stylesheet' href='vlb_files1/vlightbox1.css' type='text/css' />
		<link rel='stylesheet' href='vlb_files1/visuallightbox.css' type='text/css' media='screen' />
<script src='vlb_engine/jquery.min.js' type='text/javascript'></script>
		<script src='vlb_engine/visuallightbox.js' type='text/javascript'></script>
</head>
<body>
<?php
include_once("connect.php");

if(!empty($_SESSION['admin']))
{   $val=$_SESSION['admin'];
	$q1="select * from user_detail where user_id='$val';";
	$res1=mysqli_query($con,$q1)or exit("error in query");
	$row=mysqli_fetch_row($res1);
	$q2="select * from post_detail where user_id='$val';";
	$res2=mysqli_query($con,$q2)or exit("error in query");
	$q3="select * from post_detail where user_id='$val' ORDER BY Sno desc;";
	$res3=mysqli_query($con,$q3)or exit("error in query");

}
else{
	header("location:facebook.php");
    exit();
}
 if(!empty($_POST['fname']))
 {
	 $first_name=$_POST['fname'];
	 $last_name=$_POST['lname'];
	 $birth_day=$_POST['bday'];
	 $gender=$_POST['gender'];
	 $mobile_no=$_POST['mobileno'];
	 $hometown=$_POST['hometown'];
	 $current_city=$_POST['current_city'];
	 $status=$_POST['status'];
	 $about=$_POST['about'];
	 $nickname=$_POST['nickname'];
	 $image=$_FILES['profile_photo']['name'];
	  if(!empty($_FILES['profile_photo']['name']))
	  {
		    echo 'here';
	  $tmp_name=$_FILES['profile_photo']['tmp_name'];
	  $location="profile_photo/".rand(0,500).$image;
	    move_uploaded_file($tmp_name, $location);
		        $info = getimagesize($location); 
				    if ($info['mime'] == 'image/jpeg') 
					$image = imagecreatefromjpeg($location); 
					elseif ($info['mime'] == 'image/gif') 
					$image = imagecreatefromgif($location); 
					elseif ($info['mime'] == 'image/png') 
					$image = imagecreatefrompng($location);
					imagejpeg($image,$location,20);
	  }
	  else
	  {
		  $location=$row[13];
	  }
	  $image1=$_FILES['cover_photo']['name'];
	  if(!empty($_FILES['cover_photo']['name']))
	  {
	  $tmp_name1=$_FILES['cover_photo']['tmp_name'];
	  $location1="cover_photo/".rand(0,500).$image1;
	  move_uploaded_file($tmp_name1,$location1);
	    $info = getimagesize($location1); 	
			   if ($info['mime'] == 'image/jpeg') 
			  $image = imagecreatefromjpeg($location1); 			
			  elseif ($info['mime'] == 'image/gif') 
			 $image = imagecreatefromgif($location1); 
			elseif ($info['mime'] == 'image/png') 
			$image = imagecreatefrompng($location1);
			imagejpeg($image,$location1,20);
	  }
	  else
	  {
	    $location1=$row[14];
	  }
	 $q4="update user_detail set 
	 first_name='$first_name',
	 last_name='$last_name',
	 birth_day='$birth_day',
	 gender='$gender',
	 mobile_no='$mobile_no',
	 hometown='$hometown',
	 current_city='$current_city',
	 relationship_status='$status',
	 about='$about',
	 profile_photo='$location',
	 cover_photo='$location1',
     Nickname='$nickname'	 where user_id=$row[0]";
	 mysqli_query($con,$q4)or exit($q4);
	 header('location:profile.php');
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
			<div class='jumbotron about' style='background: white;'>
		    <h3>Gallery</h3>
			<?php
			$count_post=mysqli_num_rows($res2);
				if($count_post==0)
				{
				    echo "<h5 style='text-align:center'>No Post Yet</h5>";	
				}
				else{
			   while($post=mysqli_fetch_array($res2))
			   {   if(!empty($post[3]))
			   {
             //echo "<img src='$post[3]' style='width:30%; height:15%;'>";
		echo"<a class='vlightbox1' href='vlb_images1/$post[3]'><img src='vlb_thumbnails1/$post[3]' style='width:30%; height:15%;'/></a>
	";
	
			
			   }	   
			   } 
echo "<script src='vlb_engine/vlbdata1.js' type='text/javascript'></script>";			   
			}			   
             ?>
		  </div>
	  </div>
	  <div class="col-md-9">
	    <div class="about" style="width: 90%; height: 60%; background: #0277bd">
		   <img src='<?php echo $row[14]; ?>' style='width:100%; height: 100%; '>
		</div>
		<div class="row">
		<div class="col-md-7">
	      <div class="jumbotron about">
		      <?php
			   if(!empty($_GET['update']))
			   {
			    echo "<form action='' method='post' enctype='multipart/form-data'>
				 <h4>Name</h4>
				   <input name='fname' placeholder='firstname' style=' width: 100%;height:40px' value=".$row[1]."></input><br/>
				   <input name='lname' placeholder='lastname' style=' width: 100%;height:40px' value=".$row[2]."></input>
				   <h4>Nickame</h4>
				   <input name='nickname' placeholder='nickname' style=' width: 100%;height:40px' value=".$row[16]."></input><br/>
				   <h4>Birthday</h4>
				   <input type='date' name='bday' placeholder='birthday' style='width: 100%; height: 40px;' value=".$row[3]."></input><br/>
				   <h4>Gender</h4>
					<input type='radio' name='gender' value='male' checked>Male</input>
					<input type='radio' name='gender' value='female' checked>Female</input>
				    <h4>Mobile no</h4>
				   <input name='mobileno' placeholder='mobile number' size='' style=' width: 100%; height:40px' value=".$row[5]." maxlength='10' minlength='10'></input>
				    <h4>Hometown</h4>
				   <input name='hometown' placeholder='hometown' size='' style=' width: 100%; height:40px' value=".$row[7]."></input>
				    <h4>Current City</h4>
				   <input name='current_city' placeholder='current_city' size='' style=' width: 100%; height:40px' value=".$row[8]."></input>
				   <h4>Relationship Status</h4>
					<input type='radio' name='status' value='Single' checked>Single</input>
					<input type='radio' name='status' value='Married' checked >Married</input>
					<input type='radio' name='status' value='Complicated' checked >Complicated</input>
				    <h4>Profile Photo</h4>
				   <input type='file' name='profile_photo' style='float: left;'>
				   <img src=".$row[13]." style='width:40px; height:40px;clear: left'>
				   <h4>Cover Photo</h4>
				   <input type='file' name='cover_photo'  style='float: left;'>
				   <img src=".$row[14]." style='width:40px; height:40px;clear: left'>
				   <h4>About</h4>
				   <textarea  name='about' cols='' rows='5' style='width: 100%' value=".$row[10].">
				   </textarea>
				<button class='btn btn-info' type='submit' name='save'>Update</button>
				 </form>";
			   }
			   else
			   {
				 echo "<table cellpadding='5' cellspacing='3'>
				   <tr>
				   <th>Name</th>
				   <td>".ucwords($row[1])." ".ucwords($row[2])."</td>
				   </tr>
				   <th>Nickname</th>
				   <td>".ucwords($row[16])."</td>
				   </tr>
				   <tr>
				   <th>Birthday</th>
				   <td>".date_format(date_create($row[3]),'d-M-Y')."</td>
				   </tr>
				   <tr>
				   <th>Gender</th>
				   <td>".ucwords($row[4])."</td>
				   </tr>
				   <tr>
				   <th>Mobile no</th>
				   <td>".ucwords($row[5])."</td>
				   </tr>
				   <tr>
				   <th>Education</th>
				   <td>".ucwords($row[6])."</td>
				   </tr>
				   <tr>
				   <th>Hometown</th>
				   <td>".ucwords($row[7])."</td>
				   </tr>
				   <tr>
				   <th>Present city</th>
				   <td>".ucwords($row[8])."</td>
				   </tr>
				   <tr>
				   <th>Relationship status</th>
				   <td>".ucwords($row[9])."</td>
				   </tr>
				   <tr>
				   <th>Language</th>
				   <td>".ucwords($row[10])."</td>
				   </tr>
				   <tr>
				   <th>Interest</th>
				   <td>".ucwords($row[11])."</td>
				   </tr>
				   <tr>
				   <th>About</th>
				   <td>".ucwords($row[12])."</td>
				   </tr>
				   <tr>
				   <th>Profile Photo</th>
				   <td><img src=".$row[13]." style='width: 30px; height: 30px'></img></td>
				   </tr>
				   <tr>
				   <th>Cover Photo</th>
				   <td><img src=".$row[14]." style='width:30px; height: 30px'></img></td>
				   </tr>
                 </table>
                  <h3><a href='profile.php?update=update' style='float: right'><i class='fa fa-edit fa'>update</i></a></h3></br>"; 				 
			   }
			  ?>
		  </div>
		  </div>
		  <div class="col-md-5">
		   <?php
			echo "<div class='jumbotron about' style='background: white; margin-top: 10px;'>
		    <h3>Friends</h3>";
			   $select_friend="select* from friends where user_id1='$val' or user_id2='$val'";
			   $result_friend=mysqli_query($con,$select_friend)or exit($select_friend);
			    $count_friend=mysqli_num_rows($result_friend);
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
                      <div style='float: right; width: 70%; height:80px'>						  
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
						  <img src=".$res[13]." style='width:30%; height: 60px;'>
                      <div style='float: right; width: 70%; height:60px'>						  
			         <h4><a href='user.php?user=$res[0]'>".ucwords($res[17])."</a></h4>
					 </div>
                    </div>";
				   }
                   				   
			   }   			   
		  echo "</div>"; 
		  ?>
		  		  </div>
		  </div>
		  </div>
</div>
</div>
<?php
include("footer.php");
?>
</body>
</html>