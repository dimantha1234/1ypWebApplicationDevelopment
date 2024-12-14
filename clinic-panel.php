<?php
// Include config file
require_once "config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $sql='INSERT INTO health_records (usr_id,record_data) VALUES (?,?)';

    $stmt = mysqli_prepare($link, $sql);

    mysqli_stmt_bind_param($stmt, "ss", $NIC,$data);

    $NIC=$_POST['NIC'];
    $data=$_POST['data'];

    if($_POST['NIC']!=='' && $_POST['data']!=''){
    
       try{ 
           mysqli_stmt_execute($stmt);
        }
        catch(Exception $e) {

        }
    }
}

?>
<html>
    <head>
        <title>HealthlineClinic Panel</title>
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
        <p id="title">Clinic Administrator Panel<p>
        <p id="subtitle">Doctors/Nurse Use<p>
    </div>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

    <div class="mx-auto w-50" id="input-box">

    <div class="text-center">  
        <label for="NIC" class="form-label">Patient's NIC</label>
        <div class="text-center">
        <input type="text" class="form-control" name="NIC" id="NIC" autofocus required>
        <br>
            <div class="form-floating">
            <input type='textarea' class="form-control" placeholder="Enter data here" id="data" name="data" style="height: 100px" required></textarea>
            <label for="floatingTextarea2">Medical Diagnosis Data</label>
            </div>
        <br>
        <button type="submit" class="btn btn-primary mb-3">Save</button>
        <br>
        <a class="btn btn-primary mb-3" href="view-apnmts.php" role="button" >View Appointments</a>
        <a class="btn btn-primary mb-3" href="past-records.php" role="button" >View Past Records</a>

        </div>
    </div>

    </form>

    <div class="text-center">
        
        <a class="btn btn-primary mb-3" href="/user-panel.php" role="button" >Edit Admin Data</a>
        <a class="btn btn-primary mb-3" href="/manage-users.php" role="button" >Manage Users</a>
        <a class="btn btn-primary mb-3" href="/manage-doctors.php" role="button" >Manage Doctors</a>
        <br>
        <a class="btn btn-danger mb-3" href="logout.php" role="button" >Log Out</a>

    </div>
<script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</script>

    </body>

</html>