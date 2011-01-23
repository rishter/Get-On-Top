<?php
include 'datalink.php';
page_protect();
$q=$_GET["q"];

$result = mysql_query("SELECT `Company`,`City`,`State`,`GPA`,`Professional Field` FROM employer_users") or die (mysql_error()); 

echo "<table border='1'>
<tr>
<th>Company Name</th>
<th>City</th>
<th>State</th>
</tr>";

while($row = mysql_fetch_array($result))
  {
	if($_SESSION['user_gpa'] >= $row['GPA'] && $_SESSION['user_field'] == $row['Professional Field']){
		echo "<tr>";
  		echo "<td>" . $row['Company'] . "</td>";
  		echo "<td>" . $row['City'] . "</td>";
  		echo "<td>" . $row['State'] . "</td>";
  		echo "</tr>";
	}
  }
echo "</table>";

/*
echo "Here are your matches!<br />";
while($row = mysql_fetch_array($result))
  {
	if($_SESSION['user_gpa'] >= $row['GPA'] && $_SESSION['user_field'] == $row['Professional Field']){
		echo $row['Company'] . " in " . $row['City'] . ", " . $row['State'];
		echo "<br />";
	}
  }*/
?>