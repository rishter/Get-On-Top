
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
echo "</table>";

?>

<html>
<head>
	<title>Your matches! Get On Top</title>
	<script type="text/javascript">
	function showEmp(str)
	{
	if (str=="")
	  {
	  document.getElementById("txtHint").innerHTML="";
	  return;
	  } 
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","seematches.php?q="+str,true);
	xmlhttp.send();
	}
	</script>
</head>
<body>
	<form>
	<select name="emp" onchange="showEmp(this.value)">
	<option value="">Show your matches?</option>
	<option value="1">Show Them.</option>
	</select>
	</form>
	<br />
	<div id="txtHint"><b>Employers will be listed here.</b></div>
<?php
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
</body>
</html>