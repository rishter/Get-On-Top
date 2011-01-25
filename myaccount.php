<?php 
include 'datalink.php';
page_protect();
?>
<html>
<head>
<title>My Account</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
  
  <style>
@font-face{
 font-family: helvetican;
 src: local("HelveticaNeue-Light"), url("/HelveticaNeue-Light.ttf") format("truetype");
}
#header{
 position: absolute;
 top: 0px;
 left:0;
 right:0;
 margin-left: auto;
 margin-right: auto;
 margin-top:0px;
}
#container{
 position: absolute;
 top: 0px;
 left:0;
 right:0;
 margin-left: auto;
 margin-right: auto;
 margin-top:0px;
 width:900px;
}
h3{
 font-family: helvetican;
 font-size:25px;
}
h4{
 font-family: helvetican;
 font-size:20px;
}
#table{
 position:relative;
 left: 19px;
 top: 160px;
 width:858px;
 height:auto;
 background-image: url("images/divbg2.png");
 background-repeat: repeat-y;
}
#main{
 font-family: helvetican;
 position:relative;
 left:180px;
 width:675px;
 height:auto;
 padding-left: 20px;
}
#nav{
 font-family: helvetican;
 font-size: 18px;
 position: absolute;
 top: 165px;
 left:26px;
 width:166px;
 height:300px;
 overflow:hidden;
}
#footer{
 position: absolute;
 left:0;
 right:0;
 margin-left: auto;
 margin-right: auto;
 margin-top:0px; 
}

</style>
      

<div id="container">
<img src="images/accountpage.png" id="header">
    <div id="table">
        <div id="main">
	
	  <h3>Welcome <?php echo $_SESSION['user_firstname']. " ".$_SESSION['user_lastname']." from ".$_SESSION['user_city'].", ".$_SESSION['user_state']; ?></h3>
	  <?php	
      //if (isset($_GET['msg'])) {
	  //echo "<div class=\"error\">$_GET[msg]</div>";
	  //}
	  echo "Your GPA is ".$_SESSION['user_gpa']."<br>You're interested in ".$_SESSION['user_field'];
	  ?>
	</div>
        
        <img src="images/footer2.png" id="footer">
    </div>
    <div id="nav">
        <?php 
/*********************** MYACCOUNT MENU ****************************
This code shows my account menu only to logged in users. 
Copy this code till END and place it in a new html or php where
you want to show myaccount options. This is only visible to logged in users
*******************************************************************/
if (isset($_SESSION['user_id'])) {?>
      <h4>Links</h4><br>
      <a href="myaccount.php">My Account</a><br>
      <a href="logout.php">Logout</a><br>
      <a href="seematches.html">See your matches</a>
      	  	  <?php } ?>
    </div>
</div>

</body>
</html>
