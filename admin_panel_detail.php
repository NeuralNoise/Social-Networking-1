<?php
include('connect.php');
if(!empty($_POST['post_id'])){
	$post_id=$_POST['post_id'];
	$q_select_post="select * from post_detail where sno='$post_id'";
	$result= mysqli_query($con,$q_select_post) or exit($q_select_post);
	$res=mysqli_fetch_row($result);
	$q_select_post_user="select * from user_detail where user_id='$res[1]'";
	$result_user= mysqli_query($con,$q_select_post_user) or exit($q_select_post_user);
	$res_user=mysqli_fetch_row($result_user);
	echo "<div class='box' style='padding: 5px;'>
				  <div id='user_id' style='float: left; width:15%; height: 15%''>
				  <img src='$res_user[13]' style='width:100%; height: 100%'>
				  </div>
				  <div style='float: left; margin-left:5px;background:white'>"
		          .ucwords($res_user[17])."<br>".date_format(date_create($res[4]),'d-M-y h:ia')."<hr>
				  <div><h5 align='justify' style='word-break: break-all;'>$res[2]</h5></div></div>";
				 if(!empty($res[3]))
				 { 
			         echo "<img src='$res[3]' style='width:100%; height:230px'>";
					
				 } 
				 echo "</br></br>
				<div class='panel-group' id='comment$res[0]' style='clear:left;'>
				 <a href='home2.php?like=$res[0]'><i class='fa fa-thumbs-up' aria-hidden='true' style='text-shadow:2px 2px 2px grey; font-size:20px; color: #388e3c; '></i></a>&nbsp";
				  echo "count_like";				  
				  echo "&nbsp<a href='home2.php?unlike=$res[0]'><i class='fa fa-thumbs-down' aria-hidden='true' style='text-shadow:2px 2px 2px grey; font-size:20px; color: #e57373;'></i></a>&nbsp";
				  echo "count_unlike";
				  echo"</div>";
echo "<script>
$(document).ready(function(){
$('#user_id').click(function(e) {	
e.preventDefault();
$.ajax({
type: 'POST',
url: 'admin_panel_detail.php',
data: {user_id:'$res_user[0]'},
success: function(data)
{
$('#detail').html(data);
}
});
});
});
</script>";				  
}

if(!empty($_POST['user_id']))
{
$user_id=$_POST['user_id'];
$q_select_user="select * from user_detail where user_id='$user_id'";
	$result= mysqli_query($con,$q_select_user) or exit($q_select_user);
	$user_detail=mysqli_fetch_row($result);
echo"<table border='2' cellspacing='10' cellpadding='5'>";
					 echo "<tr>
					 <th>User_id</th>
					 <td>$user_detail[0]</td>
					 </tr>
					 <tr>
					 <th>First_name</th>
					 <td>$user_detail[1]</td>
					 </tr>
					 <tr>
					 <th>Last_name</th>
					 <td>$user_detail[2]</td>
					 </tr>
					 <tr>
					 <th>Birth_day</th>
					 <td>$user_detail[3]</td>
					 </tr>
					 <tr>
					 <th>Gender</th>
					 <td>$user_detail[4]</td>
					 </tr>
					 <tr>
					 <th>Mobile_no</th>
					 <td>$user_detail[5]</td>
					 </tr>
					 <tr>
					 <th>Education</th>
					 <td>$user_detail[6]</td>
					 </tr>
					 <tr>
					 <th>Hometown</th>
					 <td>$user_detail[7]</td>
					 </tr>
					 <tr>
					 <th>Current_city</th>
					 <td>$user_detail[8]</td>
					 </tr>
					 <tr>
					 <th>Status</th>
					 <td>$user_detail[9]</td>
					 </tr>
					 <tr>
					 <th>language</th>
					 <td>$user_detail[10]</td>
					 </tr>
					 <tr>
					 <th>interest</th>
					 <td>$user_detail[11]</td>
					 </tr>
					 <tr>
					 <th>about</th>
					 <td>$user_detail[12]</td>
					 </tr>
					 <tr>
					 <th>profile_photo</th>
					 <td>$user_detail[13]</td>
					 </tr>
					 <tr>
					 <th>cover_photo</th>
					 <td>$user_detail[14]</td>
					 </tr>";
}  	
	




?>