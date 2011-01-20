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
while($row = mysql_fetch_array($result))
  {
  echo $row['Company'] . " in " . $row['City'] . ", " . $row['State'] . " in the field of " . $row['Professional Field'];
  echo "<br />";
  }
?>
</body>