<?php
// Include config file
require_once "config.php";
$sql='SELECT * FROM health_records INNER JOIN users ON health_records.usr_id=users.usr_id';
$result = mysqli_query($link, $sql);

$show_table='yes';//dont show table until user enters ID

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $sql='SELECT * FROM health_records INNER JOIN users ON health_records.usr_id=users.usr_id WHERE health_records.usr_id="'.$_POST['NIC'].'" ';

    $show_table='yes';


try{
    $result = mysqli_query($link, $sql);
}
catch (Exception $e){
    $errorMsg='Patient Not Found ! Please check NIC !';
    $show_table='no';//dont show table if the sql returns an error
}

    $NIC=$_POST['NIC']; 

}

?>
<html>
    <head>
        <title>HealthlineClinic Record View</title>
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
        <p id="title">View Past Records<p>
        <p id="subtitle">Doctors/Nurse Use<p>

    </div>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

    <div class="mx-auto w-75" id="input-box">

    <div class="text-center">  

    <label for="NIC" class="form-label">Patient's NIC</label>
        <div class="text-center">
        <input type="text" class="form-control" name="NIC" id="NIC" autofocus required>

        <!-- Search result table -->
<?php 
if ($show_table=='yes'){
echo"<br>
<div class='container-fluid'>
<table class='table table-sm table-dark table-bordered ' id='data_tbl'>
  <thead>
    <tr>
      <th scope='col' style='text-align: center'>#</th>
      <th scope='col' style='text-align: center'>NIC</th>
      <th scope='col' style='text-align: center'>Name</th>
      <th scope='col' style='text-align: center'>Time</th>
      <th scope='col' style='text-align: center'>Data</th>
    </tr>
  </thead>
  <tbody>";
  while($row = mysqli_fetch_array($result))
  {
  echo "<tr>";
  echo "<td style='text-align: center'>" . $row['rec_id'] . "</td>";
  echo "<td style='text-align: center'>" . $row['usr_id'] . "</td>";
  echo "<td style='text-align: center'>" . $row['usr_name'] . "</td>";
  echo "<td style='text-align: center'>" . $row['rec_time'] . "</td>";
  echo "<td style='text-align: center'>" . $row['record_data'] . "</td>";

  echo "</tr>";
  }
  echo"
  </tr>
  </tbody>
</table>
</div>
"; }
?>

    <br>
    <button type="submit" class="btn btn-primary mb-3">Search</button>
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