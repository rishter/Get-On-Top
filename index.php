<?php 
include 'datalink.php';

$err = array();

foreach($_GET as $key => $value) {
	$get[$key] = filter($value); //get variables are filtered.
}

if ($_POST['doLogin']=='Login')
{

foreach($_POST as $key => $value) {
	$data[$key] = filter($value); // post variables are filtered
}


$user_email = $data['usr_email'];
$pass = $data['pwd'];


if (strpos($user_email,'@') === false) {
    $user_cond = "user_name='$user_email'";
} else {
      $user_cond = "user_email='$user_email'";
    
}

	
$result = mysql_query("SELECT `id`,`pwd`,`first_name`,`last_name`,`gpa`,`field`,`city`,`stat`,`environment` FROM users WHERE 
           $user_cond
			AND `banned` = '0'
			") or die (mysql_error());
$num = mysql_num_rows($result);


    if ( $num > 0 ) { 
	
	list($id,$pwd,$first_name,$last_name,$gpa,$field,$city,$state,$env) = mysql_fetch_row($result);
		
	
	if ($pwd === PwdHash($pass,substr($pwd,0,9))) { 
	if(empty($err)){			

       session_start();
	   session_regenerate_id (true);
		$_SESSION['user_id']= $id;  
		$_SESSION['user_name'] = $user_name;
		$_SESSION['user_firstname'] = $first_name;
        $_SESSION['user_lastname'] = $last_name;
		$_SESSION['user_gpa'] = $gpa;
		$_SESSION['user_field'] = $field;
		$_SESSION['user_city'] = $city;
		$_SESSION['user_state'] = $state;
		$_SESSION['user_env'] = $env;
		$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
		
		$stamp = time();
		$ckey = GenKey();
		mysql_query("update users set `ctime`='$stamp', `ckey` = '$ckey' where id='$id'") or die(mysql_error());
		
		//set a cookie 
		
	   if(isset($_POST['remember'])){
				  setcookie("user_id", $_SESSION['user_id'], time()+60*60*24*COOKIE_TIME_OUT, "/");
				  setcookie("user_key", sha1($ckey), time()+60*60*24*COOKIE_TIME_OUT, "/");
				  setcookie("user_name",$_SESSION['user_name'], time()+60*60*24*COOKIE_TIME_OUT, "/");
				   }
		  header("Location: myaccount.php");
		 }
		}
		else
		{
		$err[] = "Invalid Login. Please try again with correct user email and password.";
		}
	} else {
		$err[] = "Error - Invalid login. No such user exists";
	  }		
}					 
?>

<html>
<head>
<title>Get On Top</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jquery.validate.js"></script>
  <script>
  $(document).ready(function(){
    $("#logForm").validate();
  });
  </script>
</head>

<body>

<style>

@font-face{
 font-family: HelveticaNeue;
 src: url("/HelveticaNeue-Light.ttf") format("truetype");
}
img{
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
#login{
 font-family: HelveticaNeue;
 position:relative;
 left: 500px;
 top:155px;
 width:375px;
 height:200px;
 overflow:hidden;
}
h3{
 font-family: HelveticaNeue;
 font-size:30px;
}
#register{
 position:relative;
 left: 500px;
 top:200px;
 width:375px;
 height:194px;
 overflow:hidden; 
}
.msg {
padding: 5px;
width: 600px;
margin: 2px;
color: #c00;
font: italic 13px  HelveticaNeue;
} 

</style>


<div id="container">
<img src="images/homepage.png">
    <div id="login">
    <h3>Login Users</h3>
            <?php
            /******************** ERROR MESSAGES*************************************************
            This code is to show error messages 
            **************************************************************************/
            if(!empty($err))  {
             echo "<div class=\"msg\">";
            foreach ($err as $e) {
                echo "$e <br>";
                }
            echo "</div>";	
            }
            /******************************* END ********************************/	  
            ?>
    <form action="index.php" method="post" name="logForm" id="logForm" >
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="loginform">
          <tr> 
            <td width="28%">Username / Email</td>
            <td width="72%"><input name="usr_email" type="text" class="required" id="txtbox" size="25"></td>
          </tr>
          <tr> 
            <td>Password</td>
            <td><input name="pwd" type="password" class="required password" id="txtbox" size="25"></td>
          </tr>
          <tr> 
            <td colspan="2"> <div align="center"> 
                <p> 
                  <input name="doLogin" type="submit" id="doLogin3" value="Login">
                </p>
              </div></td>
          </tr>
        </table>
    </div>
    <div id="register">
        lLorem ipsum dolor sit amet, consectetur adipiscing elit. Ut lobortis sodales mi, a imperdiet turpis egestas id. Nulla consequat, magna ut eleifend consectetur, felis nulla tristique lectus, quis suscipit purus magna quis est. Praesent faucibus tellus non leo pulvinar sed suscipit lectus laoreet. Fusce in justo eu lorem gravida vulputate. Vestibulum malesuada molestie est, eu ultrices sem auctor id. In pellentesque, felis id commodo varius, sem massa rhoncus justo, quis feugiat tellus nisi nec lectus. Morbi arcu odio, ultrices non iaculis sed, lacinia nec odio. Quisque ligula purus, commodo vitae semper volutpat, bibendum eu lacus. Proin hendrerit pellentesque nisl, eu vehicula risus dapibus id. Nunc lacinia ligula id ipsum tincidunt mattis lacinia velit lobortis. Phasellus vehicula odio eu nunc facilisis facilisis. Vivamus turpis mi, faucibus quis facilisis sed, facilisis in augue. Morbi tempor lacinia sollicitudin. Aliquam vitae turpis turpis, faucibus ullamcorper massa. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Integer sit amet pulvinar tellus. Duis et augue ligula. 
    </div>
</div>
    
   

</body>
</html>
