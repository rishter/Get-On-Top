<?php
include 'datalink.php';
page_protect();
?>

<html>
<head>
	<title>Your matches! Get On Top</title>
</head>
<body>
<?php
$result = mysql_query("SELECT `Company`,`City`,`State`,`GPA`,`Professional Field` FROM employer_users") or die (mysql_error()); 
echo "Here are your matches!<br />";
while($row = mysql_fetch_array($result))
  {
	if($_SESSION['user_gpa'] >= $row['GPA'] && $_SESSION['user_field'] == $row['Professional Field']){
		echo $row['Company'] . " in " . $row['City'] . ", " . $row['State'];
		echo "<br />";
	}
  }
?>
</body>