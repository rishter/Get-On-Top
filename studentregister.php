<?php 
include 'datalink.php';

$err = array();
					 
if($_POST['doRegister'] == 'Register') 
{ 
/******************* Filtering/Sanitizing Input *****************************
This code filters harmful script code and escapes data of all POST data
from the user submitted form.
*****************************************************************/
foreach($_POST as $key => $value) {
	$data[$key] = filter($value);
	//$data[$key] = $value;
}

/************************ SERVER SIDE VALIDATION **************************************/
/********** This validation is useful if javascript is disabled in the browswer ***/

if(empty($data['first_name']) || strlen($data['first_name']) < 4)
{
$err[] = "ERROR - Invalid first name. Please enter at least 3 or more characters for your first name";
//header("Location: register.php?msg=$err");
//exit();
}

if(empty($data['last_name']) || strlen($data['last_name']) < 4)
{
$err[] = "ERROR - Invalid last name. Please enter at least 3 or more characters for your last name";
//header("Location: register.php?msg=$err");
//exit();
}

if($data['environment'] == "")
{
$err[] = "ERROR - Please choose a preferred work environment";
//header("Location: register.php?msg=$err");
//exit();
}

if($data['field'] == "")
{
$err[] = "ERROR - Please choose a preferred field";
//header("Location: register.php?msg=$err");
//exit();
}

// Validate User Name
if (!isUserID($data['user_name'])) {
$err[] = "ERROR - Invalid user name. It can contain letters, number and underscore.";
//header("Location: register.php?msg=$err");
//exit();
}
if (!isUserID($data['user_name'])) {
$err[] = "ERROR - Invalid user name. It can contain letters, number and underscore.";
//header("Location: register.php?msg=$err");
//exit();
}

// Validate Email
if(!isEmail($data['usr_email'])) {
$err[] = "ERROR - Invalid email address.";
//header("Location: register.php?msg=$err");
//exit();
}
// Check User Passwords
if (!checkPwd($data['pwd'],$data['pwd2'])) {
$err[] = "ERROR - Invalid Password or mismatch. Enter 5 chars or more";
//header("Location: register.php?msg=$err");
//exit();
}
	  
$user_ip = $_SERVER['REMOTE_ADDR'];

// stores sha1 of password
$sha1pass = PwdHash($data['pwd']);


/************ USER EMAIL CHECK ************************************
This code does a second check on the server side if the email already exists. It 
queries the database and if it has any existing email it throws user email already exists
*******************************************************************/

$rs_duplicate = mysql_query("select count(*) as total from users where user_email='$usr_email' OR user_name='$user_name'") or die(mysql_error());
list($total) = mysql_fetch_row($rs_duplicate);

if ($total > 0)
{
$err[] = "ERROR - The username/email already exists. Please try again with different username and email.";
//header("Location: register.php?msg=$err");
//exit();
}
/***************************************************************************/

if(empty($err)) {

$sql_insert = "INSERT INTO `users`
  			(`first_name`, `last_name`, `user_name`, `user_email`,`pwd`,`field`,`city`,`stat`,`gpa`,`environment`,`date`
			)
		    VALUES
		    ('$data[first_name]','$data[last_name]','$data[user_name]','$data[usr_email]','$sha1pass','$data[field]','$data[city]','$data[stat]','$data[gpa]',
			'$data[environment]',now()
			)
			";
			
mysql_query($sql_insert) or die("Insertion Failed:" . mysql_error());

  header("Location: thankyou.php");  
  exit();
	 
	 } 
 }					 
?>


<html>
<head>
<title>Student Register :: Get On Top!</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jquery.validate.js"></script>

  <script>
  $(document).ready(function(){
    $.validator.addMethod("username", function(value, element) {
        return this.optional(element) || /^[a-z0-9\_]+$/i.test(value);
    }, "Username must contain only letters, numbers, or underscore.");

    $("#regForm").validate();
  });
  </script>

<link href="styles.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="5" class="main">
  <tr> 
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr> 
    <td width="160" valign="top"><p>&nbsp;</p>
      <p>&nbsp; </p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p></td>
    <td width="732" valign="top"><p>
	<?php 
	 if (isset($_GET['done'])) { ?>
	  <h2>Thank you</h2> Your registration is now complete and you can <a href="login.php">login here</a>";
	 <?php exit();
	  }
	?></p>
      <h3 class="titlehdr">Free Student Registration</h3>
      <p>Please register a free account, before you can be matched to a job. 
        Registration is quick and free! Please note that fields marked <span class="required">*</span> 
        are required.</p>
	 <?php	
	 if(!empty($err))  {
	   echo "<div class=\"msg\">";
	  foreach ($err as $e) {
	    echo "* $e <br>";
	    }
	  echo "</div>";	
	   }
	 ?> 
	 
	  <br>
      <form action="register.php" method="post" name="regForm" id="regForm" >
        <table width="95%" border="0" cellpadding="3" cellspacing="3" class="forms">
          <tr> 
            <td colspan="2">First Name<span class="required"><font color="#CC0000">*</font></span><br> 
              <input name="first_name" type="text" id="first_name" size="20" class="required"></td>
          </tr>
        <tr> 
            <td colspan="2">Last Name<span class="required"><font color="#CC0000">*</font></span><br> 
              <input name="last_name" type="text" id="last_name" size="20" class="required"></td>
          </tr>
          
          <tr> 
            <td>Field of Interest<span class="required"><font color="#CC0000">*</font></span> 
            </td>
		<td><select name="field" class="required" id="field">
                <option value="No option" selected>No Option</option>
                <option value="Agriculture and Related Sciences">Agriculture and Related Sciences</option>
                <option value="Arts, Visual and Performing">Arts, Visual and Performing</option>
                <option value="Business">Business</option>
                <option value="Communication and Journalism">Communication and Journalism</option>
                <option value="Computer and Information Sciences">Computer and Information Sciences</option>
                <option value="Education">Education</option>
                <option value="Engineering">Engineering</option>
                <option value="Health Professions and Clinical Sciences">Health Professions and Clinical Sciences</option>
                <option value="Law and Social Sciences">Law and Social Sciences</option>
                <option value="Liberal Arts and Humanities">Liberal Arts and Humanities</option>
                <option value="Public and Social Sciences">Public and Social Sciences</option>
                <option value="Science and Math">Science and Math</option>
                </select></td>
	  </tr>
	  	<td colspan="2">Environment<span class="required"><font color="#CC0000">*</font></span><br> 
        <input name="environment" type="text" id="environment" size="20" class="required"></td>
          <tr> 
            <td>GPA </td>
            <td><input name="gpa" type="text" id="gpa">
			</td>
          </tr>
          <tr> 
            <td colspan="2">City<span class="required"><font color="#CC0000">*</font></span><br> 
              <input name="city" type="text" id="city" size="20" class="required"></td>
          </tr>
          <tr> 
            <td colspan="2">State<span class="required"><font color="#CC0000">*</font></span><br> 
              <input name="stat" type="text" id="stat" size="5" class="required"></td>
          </tr>
          <tr> 
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="2"><h4><strong>Login Details</strong></h4></td>
          </tr>
          <tr> 
            <td>Username<span class="required"><font color="#CC0000">*</font></span></td>
            <td><input name="user_name" type="text" id="user_name" class="required username" minlength="5" > 
              <input name="btnAvailable" type="button" id="btnAvailable" 
			  onclick='$("#checkid").html("Please wait..."); $.get("checkavailability.php",{ cmd: "check", user: $("#user_name").val() } ,function(data){  $("#checkid").html(data); });'
			  value="Check Availability"> 
			    <span style="color:red; font: bold 12px verdana; " id="checkid" ></span> 
            </td>
          </tr>
          <tr> 
            <td>Your Email<span class="required"><font color="#CC0000">*</font></span> 
            </td>
            <td><input name="usr_email" type="text" id="usr_email3" class="required email"> 
              <span class="example">** Valid email please..</span></td>
          </tr>
          <tr> 
            <td>Password<span class="required"><font color="#CC0000">*</font></span> 
            </td>
            <td><input name="pwd" type="password" class="required password" minlength="5" id="pwd"> 
              <span class="example">** 5 chars minimum..</span></td>
          </tr>
          <tr> 
            <td>Retype Password<span class="required"><font color="#CC0000">*</font></span> 
            </td>
            <td><input name="pwd2"  id="pwd2" class="required password" type="password" minlength="5" equalto="#pwd"></td>
          </tr>
          <tr> 
            <td colspan="2">&nbsp;</td>
          </tr>
        </table>
        <p align="center">
          <input name="doRegister" type="submit" id="doRegister" value="Register">
        </p>
      </form>
	   
      </td>
    <td width="196" valign="top">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="3">&nbsp;</td>
  </tr>
</table>

</body>
</html>
