<!DOCTYPE html>
<html>
<head>
     <title>linkZone profile</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="css/home2.css">
	<link rel="stylesheet" type="text/css" href="css/profile.css">
    <script src="js/jquery-3.1.0.min.js"></script>
	<script src="ckeditor/ckeditor.js"></script>
	<script src="js/bootstrap.min.js" type="text/javascript"></script>
</head>
<body>
<?php
include_once("connect.php");
if(!empty($_SESSION['admin']))
{   $val=$_SESSION['admin'];
	$q1="select * from user_detail where user_id='$val';";
	$res1=mysqli_query($con,$q1)or exit("error in query");
	$row=mysqli_fetch_row($res1);
	$people="select * from user_detail where user_id!='$val'";
	$res_people=mysqli_query($con,$people)or exit("error in query2");
	
}
else{
	header("location:facebook.php");
    exit();
    }
if(!empty($_GET['user']))
{
	 $id= $_GET['user'];
	   if($id==$val)
	   {
		  header("location:profile.php"); 
		  exit();
	   }
	   else{
	 $q2="select * from user_detail where user_id='$id';";
	 $res2=mysqli_query($con,$q2)or exit("error in query");
	 $row2=mysqli_fetch_row($res2);
	 $post_select="select * from post_detail where user_id='$id';";
	   $res_post=mysqli_query($con,$post_select)or exit("error in query");}
}
else{
	header("location:facebook.php");
    exit();
 }	
include("user_header.php");
?>
 <div class="container-fluid">
  <div class="row">
    <div class='col-md-3'>
	    <div class="jumbotron about">
	     <?php
		   echo "<h3>About</h3>";
		   echo "<table cellpadding='4' cellspacing='3'>
				   <tr>
				   <th>Name</th>
				   <td>".ucwords($row2[1])." ".ucwords($row2[2])."</td>
				   </tr>
				   <th>Nickname</th>
				   <td>".ucwords($row2[16])."</td>
				   </tr>
				   <tr>
				   <th>Birthday</th>
				   <td>".date_format(date_create($row2[3]),'d-M-Y')."</td>
				   </tr>
				   <tr>
				   <th>Gender</th>
				   <td>".ucwords($row2[4])."</td>
				   </tr>
				   <tr>
				   <th>Mobile no</th>
				   <td>".ucwords($row2[5])."</td>
				   </tr>
				   <tr>
				   <th>Education</th>
				   <td>".ucwords($row2[6])."</td>
				   </tr>
				   <tr>
				   <th>Hometown</th>
				   <td>".ucwords($row2[7])."</td>
				   </tr>
				   <tr>
				   <th>Present city</th>
				   <td>".ucwords($row2[8])."</td>
				   </tr>
				   <tr>
				   <th>Relationship status</th>
				   <td>".ucwords($row2[9])."</td>
				   </tr>
				   <tr>
				   <th>Language</th>
				   <td>".ucwords($row2[10])."</td>
				   </tr>
				   <tr>
				   <th>Interest</th>
				   <td>".ucwords($row2[11])."</td>
				   </tr>
				   <tr>
				   <th>About</th>
				   <td>".ucwords($row2[12])."</td>
				   </tr>
                 </table>"; 
		 ?>
		</div>
		<div class='jumbotron about'>
		    <h3>Gallery</h3>
			<?php
			    $count_post=mysqli_num_rows($res_post);
				if($count_post==0)
				{
				    echo "<h5 style='text-align:center'>No Post Yet</h5>";	
				}
				else{
			   while($post=mysqli_fetch_array($res_post))
			   {   if(!empty($post[3]))
				   {
				   echo "<img src='$post[3]' style='width:70px; height:60px;'>";
				   }
			   }
			}			   
		  echo "</div>";?>
	</div>
	<div class='col-md-5'>
	     <div class="about" style="width: 100%; height: 400px; background: #0277bd;margin-bottom: 60px;">
		   <img src='<?php echo $row2[14];?>' style='width:100%; height: 100%;'>
		   <div class='row'>
		     <div class='col-md-3'>
			 </div>
		   <div class='col-md-3'>
		     <img src='<?php echo $row2[13];?>' style='width:100px; height: 100px;  z-index:5; margin-top:-60px;'>
		   </div>
		   <div class='col-md-6'>
		     <h4 style='z-index: 5;
	            margin-top: -40px; color: white;'><?php echo ucwords($row2[17]); ?></h4>				
		   </div> 
		  </div>
		  <div style='float: right; margin-top:-35px;'>
		  <?php
		    $q_request="select * from friend_request where(sender_id='$row[0]' and destination_id='$id') or(sender_id='$id' and destination_id='$row[0]')";
			$res=mysqli_query($con,$q_request) or exit($q_request);
			$result=mysqli_fetch_row($res);
			$count_status=mysqli_num_rows($res);
			if($count_status==0)
			{
			  echo "<button class='btn btn-primary'>Send request</button>";
			}
			else if($result[3]=='a')
			{
			 echo "<ul>
			 <li class='dropdown'>
					<a class='dropdown-toggle' data-toggle='dropdown' href='#' style='color: white;'><button class='btn btn-primary'>friend<span class='caret'></span></button></a>
					<ul class='dropdown-menu'>
					<h5 style='padding: 10px;'>
					  <li><a href='#'>Unfriend</a></li>
					  <li><a href='#'>Block</a></li>
					</ul>";	
			}
			else if($result[3]=='p')
			{
			  echo "<ul>
			 <li class='dropdown'>
					<a class='dropdown-toggle' data-toggle='dropdown' href='#' style='color: white;'><button class='btn btn-primary'>Respond to request<span class='caret'></span></button></a>
					<ul class='dropdown-menu'>
					<h5 style='padding: 10px;'>
					  <li><a href='#'>Accept Request</a></li>
					  <li><a href='#'>Cancel Request</a></li>
					</ul>";		
			}
			?>
            <button class='btn btn-primary'>Message</button>
			</div>
		</div> 
	
		 <div class="jumbotron box" style="background: white; margin-top: 8px;">
	     <form action="home2.php" method="POST" enctype="multipart/form-data">
		     <div style="margin-top: 5px;">
			 <button class="btn btn-primary" name="Photo"><a href="home2.php?add_photo=add" style="color:white">Add Photo</a></button>
				<button class="btn btn-primary" name="Video">Add Video</button>
		        <textarea id="user_editor" style="width:95%;" rows="5" name="check">your timeline show's here........
			    </textarea>
				</div>
			    <input type="submit" name="submit" class="btn btn-info" value="post" style="float: right">
				<?php
				  if(!empty($_GET['add_photo']))
				  {
					  echo "<input type='file' name='image'>";
				  }
				?>
			    </form>
		</div>
		</div>
		
	
	<div class='col-md-4'>
	     <?php
			echo "<div class='jumbotron about' style='background: white; margin-top: 10px;'>
		    <h3>Friends</h3>";
			   $select_friend="select* from friends where user_id1='$id' or user_id2='$id'";
			   $result_friend=mysqli_query($con,$select_friend)or exit($select_friend);
			    $count_friend=mysqli_num_rows($result_friend);
				if($count_friend==0)
				{
					echo "no friend now";
				}
			   while($friends=mysqli_fetch_array($result_friend))
			   {  
		           if($friends[1]==$id)
				   {
					$query="select * from user_detail where user_id='$friends[2]'";
					$result=mysqli_query($con,$query)or exit($query);
					$res=mysqli_fetch_row($result);
			          echo "<a href='user.php?user=$res[0]'><img src='$res[13]' style='width:70px; height:70px; margin:3px;'></a>";
				   }
				   else
				   {
					$query="select * from user_detail where user_id='$friends[1]'";
					$result=mysqli_query($con,$query)or exit($query);
					$res=mysqli_fetch_row($result);
				    echo "<a href='user.php?user=$res[0]'><img src='$res[13]' style='width:70px; height:70px;margin:3px;'></a>";
				   }
                   				   
			   }   			   
		  echo "</div>";
		  echo"<div class='jumbotron box' style='background: white; margin-top: 5px;'>";
             echo "<h3>People You May Know</h3>";			
		        while($row3=mysqli_fetch_array($res_people))
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
					 <a href='home2.php?send_request=$row3[0]'><input type='submit' class='btn btn-primary' value='send request'></input>
					 <a href='home2.php?cancel_request=$row3[0]'><input type='submit' class='btn btn-primary' value='not now'></input></a>
					 </div>
                    </div>	";					
				} 
				}?>
			
	</div>
	</div>
  </div>
  </div>
  <?php
include("footer.php");
?>
<script>
           CKEDITOR.replace( 'user_editor', { 
   filebrowserUploadUrl: "upload.php"
        
    });
</script>
</body>
</html>