<?php 
function activate(){
    include 'datalink.php';

foreach($_GET as $key => $value) {
	$get[$key] = filter($value);
}

/******** EMAIL ACTIVATION LINK**********************/
if(isset($get['user']) && !empty($get['activ_code']) && !empty($get['user']) && is_numeric($get['activ_code']) ) {

$err = array();
$msg = array();

$user = mysql_real_escape_string($get['user']);
$activ = mysql_real_escape_string($get['activ_code']);

//check if activ code and user is valid
$rs_check = mysql_query("select id from users where md5_id='$user' and activation_code='$activ'") or die (mysql_error()); 
$num = mysql_num_rows($rs_check);
  // Match row found with more than 1 results  - the user is authenticated. 
    if ( $num <= 0 ) { 
	$err[] = "Sorry no such account exists or activation code invalid.";
	//header("Location: activate.php?msg=$msg");
	//exit();
	}

if(empty($err)) {
// set the approved field to 1 to activate the account
$rs_activ = mysql_query("update users set approved='1' WHERE 
						 md5_id='$user' AND activation_code = '$activ' ") or die(mysql_error());
$msg[] = "Thank you. Your account has been activated.";
//header("Location: activate.php?done=1&msg=$msg");						 
//exit();
 }
}

/******************* ACTIVATION BY FORM**************************/
if ($_POST['doActivate']=='Activate')
{
$err = array();
$msg = array();

$user_email = mysql_real_escape_string($_POST['user_email']);
$activ = mysql_real_escape_string($_POST['activ_code']);
//check if activ code and user is valid as precaution
$rs_check = mysql_query("select id from users where user_email='$user_email' and activation_code='$activ'") or die (mysql_error()); 
$num = mysql_num_rows($rs_check);
  // Match row found with more than 1 results  - the user is authenticated. 
    if ( $num <= 0 ) { 
	$err[] = "Sorry no such account exists or activation code invalid.";
	//header("Location: activate.php?msg=$msg");
	//exit();
	}
//set approved field to 1 to activate the user
if(empty($err)) {
	$rs_activ = mysql_query("update users set approved='1' WHERE 
						 user_email='$user_email' AND activation_code = '$activ' ") or die(mysql_error());
	$msg[] = "Thank you. Your account has been activated.";
 }
//header("Location: activate.php?msg=$msg");						 
//exit();
}

}	

?>