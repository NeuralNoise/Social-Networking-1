<?php
  class database
  {   $hostname='localhost';
      $username='root';
	  $password='';
	  $db='linkZone';
	  $con='';
	  function database()
	  {
		$this->con=mysqli_connect($this->hostname,$this->username,$this->password,$this->db)or exit('erroe in database'); 
	  }
  }
   class post extends database
   {
       function add_post($user_id,$textarea, $location)
	   {
	      $w= "insert into post_detail values('','$user_id','".str_replace("'","\'",$textarea)."','$location',now())";
		  mysqli_query($con,$w);
	   }
   }
?>