<?php
    session_start();
	require_once "config.php"; 
	
	
	if(!isset($_SESSION["nic"])){
		header("location: /login.php");
		die();
	}

	$userNIC = $_SESSION['nic'];

	$check=0;

	
	$name="";
	$id="";
	
	
	$Object = new DateTime();  
	date_default_timezone_set("Asia/Colombo");
$DateAndTime = $Object->format("d-m-Y h:i:s a"); 

	
	
   $searchQuery1="Select doc_id,doc_name FROM doctors";
     $hosQuery="Select distinct doc_hospital FROM doctors";
	   $specQuery="Select distinct doc_specialization FROM doctors";
			$result=mysqli_query($link,$searchQuery1);
			$spec=mysqli_query($link,$specQuery);
			$hos=mysqli_query($link,$hosQuery);
	
   
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		
		$specialization=$_POST['Specialization'];	
        $hospital=$_POST['hospital'];

		$_SESSION['special']=$specialization;
		$_SESSION['hospital']=$hospital;

        if(isset($_POST['search']))
		{
			 if($hospital=="")
			{
				echo '<script type ="text/JavaScript">';  
                echo 'alert("Please Select a Hospital First!")';  
				
                echo '</script>'; 
			}
			 else if($specialization=="")
			{
				echo '<script type ="text/JavaScript">';  
                echo 'alert("Please Select a Specialization First!")';  
				
                echo '</script>'; 
			}
			
			if($specialization!="Any" && $hospital!="Any")
			{
				$searchQuery2="Select doc_id,doc_name FROM doctors WHERE doc_hospital='".$hospital."' and doc_specialization='".$specialization."'";
	$result=mysqli_query($link,$searchQuery2);
	if(mysqli_num_rows($result)==0){
		$result=mysqli_query($link,$searchQuery1);
		
		echo '<script type ="text/JavaScript">';  
                echo 'alert("No Doctors under this criteria!")';  
				
                echo '</script>'; 
	}
			}
			
		

		}			
		
	
	
		
			
		
		
	if(isset($_POST['book'])){
		$bookeddate=$_POST['date'];
		$fulldata=$_POST['doctor'];
		
		   $name = substr($fulldata, strpos($fulldata, "_") + 1);
		   if($fulldata=="")
			{
				echo '<script type ="text/JavaScript">';  
                echo 'alert("Please Select an Doctor First!")';  
				
                echo '</script>'; 
			}
			if($bookeddate=="")
			{
				echo '<script type ="text/JavaScript">';  
                echo 'alert("Please Select a Date and Time First!")';  
				
                echo '</script>'; 
				
			}
       
		if($fulldata!="" && $bookeddate!="")
		{
			$docid=(int) filter_var($fulldata, FILTER_SANITIZE_NUMBER_INT);  
		    
			$checkQuery="Select apn_id from appointments where doc_id='".$docid."' and (timediff('".$bookeddate."',apn_time)<'00:30:00' and timediff('".$bookeddate."',apn_time)>'-00:30:00')";
			$check=-1;
			if($tableresult=mysqli_query($link,$checkQuery))
			{
				$rowcount=mysqli_num_rows($tableresult);
				
				if($rowcount==0)
				{
					$check=0;
				}
				
			}
			
			
	
			if($check==-1)
			{
				echo '<script type ="text/JavaScript">';  
                echo 'alert("Sorry Selected Time has Already been Booked!")';  
				
                echo '</script>';
			}
			
			else
			{
				$insertQuery="Insert into appointments(apn_time,usr_id,doc_id) values('".$bookeddate."','".$userNIC."','".$docid."')";
			if (mysqli_query($link, $insertQuery)) {
            
			echo '<script type ="text/JavaScript">';  
                echo 'alert("Your appointment has been successfully created ! Thank You")';  
				
                echo '</script>'; 
            } else {
            echo "/Error: " . $sql . "<br>" . mysqli_error($link);
			}
			
			
}
		}
		else{
			
			
		}
	}
	}
	if(array_key_exists('logout', $_POST)) {
  $_SESSION["loggedin"]=false;
  header("location: login.php");
  exit;
}
	
?>
<html>
<head>
<title>Make Appointments</title>
<style>
body {
  background-image: url("bg.webp");
  background-size: 100%;
  background-repeat: no-repeat;
}
form{
margin: 0 auto;
width:500px;
}
#logout
{
	position: absolute;
right:420;
}
#home
{
	position: absolute;
right:320;
}

#cancel
{
position: absolute;
right:120;
}

#about
{
position: absolute;
right:10;
}

#doctor
{
width:150px;
}
#hospital
{
width:150px;
}
#Specialization
{
width:150px;
}
#date
{
width:150px;
}
#search
{
width:150px;
}
#book
{
	width:150px;
}
#head{
	font-size:4vmax;
}

</style>

<script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">

</script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" href="/styles.css">
</head>
<body>

<p id='head' class='text-center'>Make Appointments</p>
<p style="font-size:2vmin" class='text-center'>Select hospital and specialization and click Search to list available doctors</p>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

<div class="container-fluid">
	<div class="text-center"> 

		<label for='hospital'>Select a hospital</label><br>
		<select name="hospital" id="hospital" name="hospital">
		<option selected="" value="" hidden><?php echo $_SESSION['hospital'] ?></option>
		<option value="Any" >Any</option>
		<?php while($row=mysqli_fetch_assoc($hos)):; ?>
		<option><?php echo $row['doc_hospital'];?></option>
		<?php endwhile;?>
		</select>

		<br><br>

		<label for='Specialization'>Select a specilization</label><br>
		<select name="Specialization" id="Specialization" name="Specialization">
		<option value="" hidden><?php echo $_SESSION['special'] ?></option>
		<option value="Any" >Any</option>
		<?php while($row=mysqli_fetch_assoc($spec)):; ?>
		<option><?php echo $row['doc_specialization'];?></option>
		<?php endwhile;?>
		</select>

		<br><br>

		<button type="submit" id="search" name="search" onclick="validate()" class="btn btn-primary mb-3">Search</button>
		<br>
		
		<label for='doctor'>Select a doctor</label><br>
		<select id="doctor" name="doctor" >
		<option selected value="">Doctor Name</option>
		<?php while($row=mysqli_fetch_assoc($result)):; ?>
		<option><?php echo $row['doc_id']."_".$row['doc_name'];?></option>
		<?php endwhile;?>
		</select>
		<br><br>

		<div class="row d-flex justify-content-center">
		<label for='date'>Select a date and time</label><br>
		<input type="datetime-local" value="<?php echo $DateAndTime; ?>" class="form-control" name="date" id="date" >
		
		</div>
		<br>

		<button type="submit" id="book" name="book"  class="btn btn-primary mb-3">Book</button>

	</div>

	<div class="mx-auto"> 
		<div class="d-grid gap-2 col-6 mx-auto">
			<button class="btn btn-primary" type="button" onclick="location.href='/my-apnmts.php'">My Appointments</button>
  			<button class="btn btn-primary" type="button" onclick="location.href='/user-panel.php'">My Account</button>
			<button class="btn btn-danger" type="button" onclick="location.href='/logout.php'">Logout</button>
		</div>
	</div>
</div>

</form>
</body>
</html>