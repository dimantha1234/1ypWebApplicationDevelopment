<?php
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: user-panel.php");
    exit;
}
$pass_mismatch="";
$userexists=false;
require_once "config.php"; //make connections to the db

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name=$_POST['name'];
    $NIC=$_POST['NIC'];
    $password=$_POST['password'];
    $confirm_password=$_POST['confirm_password'];
    $hashed_password="";

    if($password!=$confirm_password){ //show error when passwords do no match
        $pass_mismatch="Passwords do no match !";
    }
    
    

    if (empty($pass_mismatch)){//continue when passwords match
        $insertQuery="INSERT INTO users (usr_name,usr_id,usr_pwd) VALUES (?,?,?)";

        $stmt = mysqli_prepare($link, $insertQuery);//prepare sql thingy
        mysqli_stmt_bind_param($stmt, "sss", $name,$NIC,$hashed_password);//bind the variables

        $hashed_password=password_hash($password , PASSWORD_DEFAULT); //use default hashing algorithm

        try{
            if(mysqli_stmt_execute($stmt)){
            // Redirect to login page if the execution was OK !
            header("location: login.php");
            }
        }
        catch (Exception $e){
            $userexists=true;
        }
 
    }

}

?>

<html>
    <head>
        <title>HealthlineClinic Sign Up</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="/styles.css">
        <style>
            body {
            width: 100%;
            height: auto;
            background-image: url('bg2.jpg');
            background-repeat: no-repeat;
            }
        </style>
    </head>

    <body>
    

<form id="login-signup" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

<div class="container-fluid">
    <p id="title" class="text-center">Welcome to Healthline Clinic</p>
    <p id="subtitle" class="text-center">Sign up now !</p>

    <div class="text-center">  
        <label for="name" class="col-sm-2 col-form-label">Name</label>
        <div class="text-center">
        <input type="text" class="form-control" name="name" id="name" autofocus required>
        </div>
    </div>

    <div class="text-center">  
        <label for="NIC" class="col-sm-2 col-form-label">NIC</label>
        <div class="text-center">
        <input type="text" class="form-control" name="NIC" id="NIC" autofocus required>
        </div>
    </div>
    
    <div class="text-center">
        <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
    <div class="text-center">
        <input type="password" class="form-control" id="inputPassword" name="password" required>
    </div>

    <div class="text-center">
        <label for="inputPassword" class="col-sm-2 col-form-label">Confirm</label>
    <div class="text-center">
        <input type="password" class="form-control" id="inputPassword" name="confirm_password" required>
    </div>

    <?php
     if ($pass_mismatch!=""){
         echo"
         <br>
         <div class='alert alert-danger' role='alert'>"; 
         echo $pass_mismatch . "
            </div>
         ";
     }
     if ($userexists){
        echo"
        <br>
        <div class='alert alert-danger' role='alert'>
        User with this NIC already exists !
           </div>
        ";
    }
     ?>

    
    <table>
    <tr>
    <td>
        <br>
        <button type="submit" class="btn btn-primary mb-3">Sign-Up Now</button>
    </td>
    <td>
        <br>
        <a class="btn btn-primary mb-3" href="login.php" role="button" >Login</a>
    </td>
    </tr>
  </div>
</form>



<script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</script>

    </body>

</html>