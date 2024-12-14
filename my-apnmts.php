<?php
session_start();
	require_once "config.php"; 
	$userNIC= $_SESSION['nic'];
	
	$select="SELECT * from appointments where usr_id='".$userNIC."'";
	$result=mysqli_query($link,$select);
	
	$tableresult=mysqli_query($link,$select);
	
	if($checkresult=mysqli_query($link,$select))
	{
		$rowcount=mysqli_num_rows($checkresult);
		if($rowcount==0)
		{
			echo"<p>Sorry you don't have any Appointments</p>";
	
            $value="hidden";
		}
		else
		{
			$value="visible";
			echo "
			<div class='container-fluid'>
			<table>";
	echo "<tr><th>Appointment ID</th><th>Date</th><th>NIC</th><th>Doctor ID</th></tr>";
	while($row=mysqli_fetch_array($tableresult)){
		echo"<tr><td>".htmlspecialchars($row['apn_id'])."</td><td>".htmlspecialchars($row['apn_time'])."</td><td>".htmlspecialchars($row['usr_id'])."</td><td>".htmlspecialchars($row['doc_id'])."</td></tr>";
	    
	}
	echo "</table> <div>";
	
		}
	}
	
	
	
	
	
	if(isset($_POST['delete'])){
		
		$apnid=$_POST['appointments'];
		if($apnid!="")
		{

			$deleteQuery="DELETE  from appointments WHERE apn_id='".$apnid."'";
		if (mysqli_query($link,$deleteQuery)) {
            echo "/Appointment Cancelled Successfully";
			 
            } else {
            echo "/Error: " . $sql . "<br>" . mysqli_error($link);
		}
		
	}
	else
	{
		  echo '<script type ="text/JavaScript">';  
echo 'alert("Please Select an Appointment First!")';  
echo '</script>'; 
	}
	echo "<meta http-equiv='refresh' content='0'>";
	}
	
	
	
	
	if(array_key_exists('logout', $_POST)) {
  $_SESSION["loggedin"]=false;
  header("location: login.php");
  exit;
}
?>

<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<style>
p{
	position:fixed;
	left: 550px;
	color:black;
	top: 300px;
	font-size: 32px;
}
body {
  background-image: url("bg.webp");
  background-size: 100%;
}
table{
  border: 1px solid;
  border-collapse: collapse;
  position: fixed;
  right: 10px;
top: 50;
text-align: right;
width: 1000px;
}
th, td {
	border: 1px solid;
border-collapse: collapse;
  background-color: #96D4D4;
  text-align: right;
}
#delete
{
	visibility:<?php echo "$value"?>;
	position: fixed;
	height: 30px;
  top: 50;
  left: 215;
  width: 200px;
}
#appointments
{
	visibility:<?php echo "$value"?>;
	position: fixed;
  top: 50;
  left: 10;
  height: 30px;
  width: 200px;
}
#back
{
	position: fixed;
	height: 30px;
  width: 100px;
  right: 340px;
}
#home
{
	position: fixed;
	height: 30px;
  width: 100px;
  right: 230px;
}
#about
{
	position: fixed;
	height: 30px;
  width: 100px;
  right: 120px;
}
#logout
{
	position: fixed;
	height: 30px;
  width: 100px;
  right: 10px ;
}
</style>

<script>


</script>

<title>Delete Appointments</title>


</head>
<body>
<form method="post">
<button type="button" onclick="location.href='appointment.php'" class="btn btn-primary mb-3" id="back" name="back">Back</button>
<button type="button" onclick="location.href='/'" class="btn btn-primary mb-3" id="home" name="home">Home</button>
<button type="button" onclick="location.href='about.html'" class="btn btn-primary mb-3" id="about" name="about">About Us</button>
<button type="submit"  class="btn btn-primary mb-3" id="logout" name="logout" value="logout">Logout</button>
<select id="appointments" name="appointments" >
<option selected value="">Appointment ID</option>
<?php while($row=mysqli_fetch_array($result)):; ?>
<option><?php echo $row['apn_id'];?></option>
<?php endwhile;?>
</select>
<button type="submit" id="delete" name="delete" class="btn btn-primary mb-3" onclick='window.location.reload(true);'>Delete</button>
<br><br>
</form >

</body>
</html>