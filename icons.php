  <div class="jumbotron box" style="background: white; margin-top: 5px;">
<?php
echo "<div class='profile' style='background: #0277bd'> 
<img src='$row[13]' style='width:100%; height: 100%' class='profile'>		  
</div>";
echo "<a href='home2.php?profile=username'><h3 style='text-align: center'>".ucwords($row[17])."</h3></a>";
 echo "<ul>
<h4 style='padding: 15px;'>
<li><a  class='fa fa-home' href='home2.php'> Home</a></li>
<li><a class='fa fa-user-plus' href='friends.php'> Friends</a></li>
<li><a class='fa fa-bell' href=''> Notification</a></li>
<li><a class='fa fa-inbox' href=''> Messages</a></li>
<li><a class='fa fa-users' href='groups.php'> Pages</a></li>
<li><a  class='fa fa-pencil-square-o' href='home2.php?post=post'> Post</a></li>
<li><a class='fa fa-sign-out' href='home2.php?logout1=logout1'> logout</a></li></h4>
</ul>";
?>			
 </div>