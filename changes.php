<?php
include("connect.php");
if(!empty($_SESSION['admin']))
{   $val=$_SESSION['admin'];
	$q1="select * from user_detail where user_id='$val';";
	$res1=mysqli_query($con,$q1)or exit("error in query1");
	$row=mysqli_fetch_row($res1);
}
else{
	header("location:index.php");
	exit();
}
if(!empty($_POST['current']))
{
	$current=$_POST['current'];
	$password=$_POST['id2'];
	if(empty($password)){exit;}
	$re_password=$_POST['id3'];
	if($password==$re_password){
	$q_password="update users set password='$password' where user_id=$row[0] and password='$current'";
	$q_result=mysqli_query($con,$q_password)or exit($q_password);
	$count=mysqli_affected_rows($q_result);
	if($count==1){
	echo "Successfully you change your password";}}
}
if(!empty($_POST['current1']))
{
	$current=$_POST['current1'];
	$username=$_POST['id2'];
	if(empty($username)){exit;}
	$re_username=$_POST['id3'];
	if($username==$re_username){
	$q_username="update users set username='$username' where user_id=$row[0] and password='$current'";
	$result=mysqli_query($con,$q_username)or exit($q_username);
	$count=mysqli_affected_rows($result);
	if($count==1){
	echo "Successfully you change your username";}}
}
if(!empty($_POST['prefer1']))
{
	$prefer=$_POST['prefer1'];
	$q_prefer="update user_detail set preference_status='$prefer' where user_id='$row[0]'";
		$result=mysqli_query($con,$q_prefer)or exit($q_prefer);
	echo "Successfully you change your prefernce";
}
if(!empty($_POST['description']))
{
	$title=$_POST['title'];
	$desc=$_POST['description'];
	$q_create="insert into groups() values('','$title','".str_replace("'","\'",$desc)."','$row[0]','cover_photo/204romanson_2_3.jpg', now())";
	mysqli_query($con,$q_create)or exit($q_create);
	$q_view="select * from groups where created_id='$row[0]'and group_title='$title' and group_description='$desc'";
	$result=mysqli_query($con,$q_view)or exit($q_view);
	$res=mysqli_fetch_row($result);
	$q_member="insert into pages_member() values('','$res[0]','$row[0]','a',now())";
	mysqli_query($con,$q_member)or exit($q_member);
	echo "<h5 style='color: green'>Successfully you create your page</h5>";
	echo "<button id='view_page$res[0]' class='btn btn-primary'>View Your page</button></a>";
	
}
if(!empty($_POST['user_id']))
{
	$page_id=$_POST['page_id'];
	$user_id=$_POST['user_id'];
	$q_page="select* from pages_member where page_id='$page_id' and member_id='$user_id'";
	$result=mysqli_query($con,$q_page)or exit($q_page);
	$count=mysqli_num_rows($result);
	if($count==1){
   $q_member="delete from pages_member where page_id='$page_id' and member_id='$user_id'";
	}
	else{	
	$q_member="insert into pages_member() values('','$page_id','$user_id','m',now())";}
	mysqli_query($con,$q_member)or exit($q_member);
}
if(!empty($_POST['page_id']))
{
	$page_id=$_POST['page_id'];
	$q_page="select* from groups where sno='$page_id'";
	$result=mysqli_query($con,$q_page)or exit($q_page);
	$res=mysqli_fetch_row($result);
	$q_page="select* from pages_member where page_id='$page_id' and member_id='$row[0]'";
	$result=mysqli_query($con,$q_page)or exit($q_page);
	$count=mysqli_num_rows($result);
	echo "<div style='width:100%;'>
	<img src='$res[4]' style='width:100%; height: 300px;'></img>
	<button class='btn btn-primary' style='float: right;margin-top:5px'>";
	if($count==1){
	echo "member";}else{echo "+Join Group";}
	echo "</button>
	<h3 style='word-break: break-all; color: #0277bd'>".ucwords($res[1])."</h3>
	<h4 style='word-break: break-all;'>".ucwords($res[2])."</h4>
	</div>";
	if($count==1){
echo "<form action='' method='POST' enctype='multipart/form-data'>
		    <div class='panel-group' id='accordion'>
		   <div class='panel panel-default' style='border:none;'>
		   <a data-toggle='collapse' data-parent='#accordion' href='#audio'><button class='btn btn-primary'>Add Photo</button></a>
		   <a data-toggle='collapse' data-parent='#accordion' href='#video'><button class='btn btn-primary'>Add video</button></a>
		     <div id='audio' class='collapse'><input type='file' name='image'></div>
			 <div id='video' class='collapse'>video url:-<input type='url' name='video' placeholder='url'></div></div></div>
		     <div style='margin-top: 5px;'>
		        <textarea id='editor' style='width:100%;' rows='5' name='check'>your timeline show's here........
			    </textarea>
				</div></br>
				<input type='submit' name='submit_page' class='btn btn-info' value='post' style='float: right'></input>
			    </br></form>
		</div>";    	
            if(!empty($_POST['submit_page']))
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
							$location="page_post/".rand(0,1000).$img;
							move_uploaded_file($tmp_name,$location);
				     }else{$location="";}
				
					$w= "insert into pages_post values('','$res[0]','$row[0]','".str_replace("'","\'",$event)."','$location','',now())";
					  mysqli_query($con,$w)or exit($w);				
				}	
}
}
if(!empty($res[0])){
echo "<script>
$(document).ready(function(){
$('#view_page$res[0]').click(function(e) {
e.preventDefault();
$.ajax({
type: 'POST',
url: 'changes.php',
data: {page_id:$res[0]},
success: function(data)
{
$('#page').html(data);
}
});
});	});
</script>";}	
?>