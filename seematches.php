<?php
include 'datalink.php';
?>

<html>
<head>
	<title>Your matches! Get On Top</title>
</head>
<body>
<?php
$result = mysql_query("SELECT `Company`,`City`,`State`,`Professional Field` FROM employer_users") or die (mysql_error()); 
$num = mysql_num_rows($result);
echo $num;
?>
</body>