<script src='js/bootstrap.min.js' type='text/javascript'></script>
<nav class="navbar" style='background:#0277bd;'>
			<div class="container-fluid header">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar" style='color:white'>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span> 
					</button>
				</div>
				<div class='row'>
				<div class='col-md-2'>
		          <h3 style='color: white; margin-left:7px;'><label>LinkZone</label><h3>
				</div>
				<div class='col-md-4' style='margin-top: 20px;'>
				  <input type="search" name="search" style="width:90%;" placeholder="Search Friends" onkeyup="showresult(this.value)"><i class='fa fa-search' style='color:black;margin-left:-20px;'></i></input><div id='livesearch' style='width:84%; background:white; z-index:10; position:absolute; border-radius:2px; box-shadow:0px 0px 5px  grey;'></div>
				</div>
				<div class='col-md-6'>
			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav1 navbar-nav navbar-right" style='margin-right: 100px;'>
				<li><a href='home2.php?profile=username' class="fa fa-user" style="color: white;">
					 <?php echo ucwords($row[17])?>
					</a></li> 
					<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#" style="color: white;">Menu</a>
					<ul class="dropdown-menu">
					  <h5 style='padding: 15px;'>
					   <li><a  class='fa fa-home' href='home2.php'> Home</a></li>
					   <li><a class='fa fa-user-plus' href='friends.php'> Friends</a></li>
					   <li><a class='fa fa-bell' href=''>Notification</a></li>
					   <li><a class='fa fa-inbox' href=''> Messages</a></li>
					   <li><a class='fa fa-users' href='groups.php'>Pages</a></li>
					   <li><a  class='fa fa-pencil-square-o' href='home2.php?post=post'> Post</a></li></h5> 
					</ul>
				  </li>
                  <li><a href="settings.php" style='color:white'>Settings</a></li>				  
					<li><a class="fa fa-sign-out" style="color: white;" href="home2.php?logout1=logout1">LogOut </a></li>
				</ul>
			</div>
			</div>
			</div>
			</div>
		</nav>
		<script>
		   var model=document.getElementById('myModel');
		   preference.onclick=function(){
			   model.style.display="block";
		   }
		  function showresult(str)
		  {
			  if (str.length==0) { 
            document.getElementById("livesearch").innerHTML="";
            document.getElementById("livesearch").style.border="0px";
            return;
          }
		  if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		  } else {  // code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		  xmlhttp.onreadystatechange=function() {
			if (this.readyState==4 && this.status==200) {
			  document.getElementById("livesearch").innerHTML=this.responseText;
			  document.getElementById("livesearch").style.border="1px solid #A5ACB2";
			}
		  }
		  xmlhttp.open("GET","comment.php?q="+str,true);
		  xmlhttp.send();
		  }
		</script>