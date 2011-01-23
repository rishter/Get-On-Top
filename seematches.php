<html>
<head>
	<title>MATCHES!</title>
</head>
<body>
<?php
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
</html>