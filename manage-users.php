<?php
// Include config file
require_once "config.php";

$sql='SELECT * FROM users';
$result = mysqli_query($link, $sql);
$triedtodeleteAdmin=false;
$userNotFound=false;

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $nic = $_POST['NIC'];

    if($nic=='admin'){
        $triedtodeleteAdmin=true;
    }
    else {
        //Delete all records
        $sql='DELETE FROM health_records WHERE usr_id=?';
        $stmt = mysqli_prepare($link,$sql);
        mysqli_stmt_bind_param ($stmt,'s',$nic);
        mysqli_stmt_execute($stmt);

        //Delete all appointments
        $sql='DELETE FROM appointments WHERE usr_id=?';
        $stmt = mysqli_prepare($link,$sql);
        mysqli_stmt_bind_param ($stmt,'s',$nic);
        mysqli_stmt_execute($stmt);

        //Delete the user
        $sql= 'DELETE FROM users WHERE usr_id=?';
        $stmt = mysqli_prepare($link,$sql);
        mysqli_stmt_bind_param ($stmt,'s',$nic);
        mysqli_stmt_execute($stmt);
        try{
            if(!mysqli_stmt_execute($stmt)){
                $userNotFound=true;
            }
        }
        catch (Exception $e){
            
        }
    }

    header("location: /manage-users.php");

}

?>
<html>
    <head>
        <title>HealthlineClinic Manage Users</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="/styles.css">
        <style>
            body {
            width: 100%;
            height: auto;
            background-image: url('bg2.jpg');
            background-repeat: repeat-n;
            }
        </style>
    </head>

    <body>


    <div class="text-center">
        <p id="title">Manage Users<p>
        <p id="subtitle">Doctors/Nurse Use<p>

    </div>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

    <div class="mx-auto w-50" id="input-box">

    <div class="text-center">  

    <label for="NIC" class="form-label">Patient's NIC</label>
        <div class="text-center">
        <input type="text" class="form-control" name="NIC" id="NIC" autofocus required>

        
    <br>
    <button type="submit" class="btn btn-primary mb-3">Delete</button>

<?php 

    if ($triedtodeleteAdmin){
    echo"
    <br>
    <div class='alert alert-danger' role='alert'>
    User not found ! Please check NIC
       </div>
    ";
    }

echo"<br>
<div class='container-fluid'>
<table class='table table-sm table-dark table-bordered ' id='data_tbl'>
  <thead>
    <tr>
      <th scope='col' style='text-align: center'>NIC</th>
      <th scope='col' style='text-align: center'>Name</th>
      <th scope='col' style='text-align: center'>Registered On</th>
    </tr>
  </thead>
  <tbody>";
  while($row = mysqli_fetch_array($result))
  {
  echo "<tr>";
  echo "<td style='text-align: center'>" . $row['usr_id'] . "</td>";
  echo "<td style='text-align: center'>" . $row['usr_email'] . "</td>";
  echo "<td style='text-align: center'>" . $row['member_since'] . "</td>";

  echo "</tr>";
  }
  echo"
  </tr>
  </tbody>
</table>
</div>
"; 

?>

    </div>

    </form>

    <div class="text-center">
        <br>
        <a class="btn btn-primary mb-3" href="/clinic-panel.php" role="button" >Clinic Panel</a>
    </div>
<script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</script>

    </body>

</html>