<?php
include 'datalink.php';
page_protect();
?>
<html>
<head>
	<title>Get On Top::Matches</title>
</head>
<body>
<?php
echo "Here are your matches!<br />";
echo "Your gpa is ".$_SESSION['user_gpa'];
$result = mysql_query("SELECT `Company`,`City`,`State`,`GPA`,`Professional Field` FROM employer_users") or die (mysql_error()); 
while($row = mysql_fetch_array($result))
  {
	if($_SESSION['user_gpa'] >= $row['GPA'] && $_SESSION['user_field'] == $row['Professional Field']){
		echo $row['Company'] . " in " . $row['City'] . ", " . $row['State'];
		echo "<br />";
	}
  }
?>
</body>
</html>