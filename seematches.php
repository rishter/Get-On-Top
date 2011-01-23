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

echo "<table border='1'>
<tr>
<th>Company Name</th>
<th>City</th>
<th>State</th>
</tr>";

$result = mysql_query("SELECT `Company`,`City`,`State`,`GPA`,`Professional Field` FROM employer_users") or die (mysql_error()); 
while($row = mysql_fetch_array($result))
  {
	if($_SESSION['user_gpa'] >= $row['GPA'] && $_SESSION['user_field'] == $row['Professional Field']){
		echo "<tr>";
  		echo "<td>" . $_SESSION['Company'] . "</td>";
  		echo "<td>" . $_SESSION['City'] . "</td>";
  		echo "<td>" . $_SESSION['State'] . "</td>";
  		echo "</tr>";
	}
  }
?>
</body>
</html>