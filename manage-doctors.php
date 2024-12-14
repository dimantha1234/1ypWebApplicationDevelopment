<?php
// Include config file
require_once "config.php";

$sql='SELECT * FROM doctors';
$result = mysqli_query($link, $sql);
$triedtodeleteAdmin=false;
$userNotFound=false;

if($_SERVER["REQUEST_METHOD"] == "POST"){

if(isset($_POST['delete'])){
    $dno = $_POST['dno'];

    //Delete all appointments related to doctor
    $sql='DELETE FROM appointments WHERE doc_id=?';
    $stmt = mysqli_prepare($link,$sql);
    mysqli_stmt_bind_param ($stmt,'s',$dno);
    mysqli_stmt_execute($stmt);

    //Delete all records
    $sql='DELETE FROM doctors WHERE doc_id=?';
    $stmt = mysqli_prepare($link,$sql);
    mysqli_stmt_bind_param ($stmt,'s',$dno);
    mysqli_stmt_execute($stmt);

    try{
        mysqli_stmt_execute($stmt);
    }
    catch (Exception $e){
        
    }
}

if(isset($_POST['add'])){
   $name=$_POST['name'];
   $special=$_POST['special'];
   $hosp=$_POST['hospital'];
   $tp=$_POST['tp'];


   if($name!='' && $special!='' && $hosp!=''){
    $addqury="INSERT INTO `doctors` ( `doc_name`, `doc_tp`, `doc_specialization`, `doc_hospital`) VALUES
	(?,?,?,?)";

    try{
    $stmt=mysqli_prepare($link,$addqury);
    mysqli_stmt_bind_param($stmt, "ssss", $name,$tp,$special,$hosp);
    mysqli_stmt_execute($stmt);
    }
    catch (Exception $e){

    }
   }
    }

    header("location: /manage-doctors.php");

}

?>
<html>
    <head>
        <title>HealthlineClinic Manage Doctors</title>
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
        <p id="title">Manage Doctors<p>
        <p id="subtitle">Doctors/Nurse Use<p>
    </div>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

    <div class="mx-auto w-50" id="input-box">

    <div class="text-center">
        
    <label for="name" class="form-label">Doctor Name</label>
    <div class="text-center">
        <input type="text" class="form-control" name="name" id="name" autofocus>
    </div>

    <label for="special" class="form-label">Specialization</label>
    <div class="text-center">
        <input type="text" class="form-control" name="special" id="special" autofocus>
    </div>

    <label for="hospital" class="form-label">Doctor Hospital</label>
    <div class="text-center">
        <input type="text" class="form-control" name="hospital" id="hospital" autofocus>
    </div>

    <label for="to" class="form-label">Doctor Telephone Number</label>
    <div class="text-center">
        <input type="text" class="form-control" name="tp" id="tp" autofocus>
    </div>
    <br>
    <button type="submit" name="add" class="btn btn-primary mb-3">Add</button>

    <br>
    <label for="dno" class="form-label">Doctor Number To Delete</label>
    <div class="text-center">
        <input type="text" class="form-control" name="dno" id="dno" autofocus>
    </div>
   
    <br>
    <button type="submit" name="delete" class="btn btn-primary mb-3">Delete</button>

<?php 

echo"<br>
<div class='container-fluid'>
<table class='table table-sm table-dark table-bordered ' id='data_tbl'>
  <thead>
    <tr>
      <th scope='col' style='text-align: center'>No.</th>
      <th scope='col' style='text-align: center'>Name</th>
      <th scope='col' style='text-align: center'>Specialization</th>
      <th scope='col' style='text-align: center'>Hospital</th>
      <th scope='col' style='text-align: center'>TP</th>
    </tr>
  </thead>
  <tbody>";
  while($row = mysqli_fetch_array($result))
  {
  echo "<tr>";
  echo "<td style='text-align: center'>" . $row['doc_id'] . "</td>";
  echo "<td style='text-align: center'>" . $row['doc_name'] . "</td>";
  echo "<td style='text-align: center'>" . $row['doc_specialization'] . "</td>";
  echo "<td style='text-align: center'>" . $row['doc_hospital'] . "</td>";
  echo "<td style='text-align: center'>" . $row['doc_tp'] . "</td>";

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