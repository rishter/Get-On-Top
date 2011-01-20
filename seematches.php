<?php
include 'datalink.php';
?>

<html>
<head>
	<title>Your matches! Get On Top</title>
</head>
<body>
<?php
$result = mysql_query("SELECT `Company`,`City`,`State`,`GPA`,`Professional Field` FROM employer_users") or die (mysql_error()); 
echo "Here are your matches!";
echo "Your gpa is ".$_SESSION['user_gpa'];
while($row = mysql_fetch_array($result))
  {
	if($_SESSION['user_gpa'] >= $row['GPA']){
		echo $row['Company'] . " in " . $row['City'] . ", " . $row['State'] . " in the field of " . $row['Professional Field'];
		echo "<br />";
	}
  }
?>
</body>