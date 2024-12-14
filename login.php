<?php
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    if($_SESSION['user_role']=='admin'){
        header("location: clinic-panel.php");
        exit;
    }
    header("location: appointment.php");
    exit;
}


$_SESSION['user_role']='';

require_once "config.php"; //make connections to the db

$pass_wrong="";
$user_not_found="";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $NIC=$_POST['NIC'];
    $password=$_POST['password'];
    $hashed_password="";
    $email="";
    
    $sqlFindUser="SELECT usr_pwd,usr_role FROM users WHERE usr_id=?";//get hashed pwd from db using user id (email)
    $stmt = mysqli_prepare($link, $sqlFindUser);//prepare
    mysqli_stmt_bind_param($stmt, "s", $NIC);

    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
        // Store result
        mysqli_stmt_store_result($stmt);
        
        // Check if username exists, if yes then verify password
        if(mysqli_stmt_num_rows($stmt) == 1){//only continue if the result only has one row (one user)   
            mysqli_stmt_bind_result($stmt, $hashed_password,$role);//get the hashed password from the sql result to a variable named $hashed_password

            if(mysqli_stmt_fetch($stmt)){
                if(password_verify($password, $hashed_password)){
                    $_SESSION["loggedin"] = true; //set session var to true , so untill user logs out , this session keeps alive
                    $_SESSION['user_role'] = $role;
                    $_SESSION['nic'] = $NIC;
                    $_SESSION['special']='Select Specialization';
                    $_SESSION['hospital']='Select Hospital';
                    header("location: login.php");
                }
            }
        }
        else $user_not_found="User not found ! Please signup.";

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
            background-repeat: repeat-n;
            }
        </style>
    </head>
<body>
    
<form id="login-signup" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

<div class="container-fluid">
    
    <p id="title" class="text-center">Welcome to Healthline Clinic</p>
    <p id="subtitle" class="text-center">Login now to make appointments</p>


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

    <?php
     if ($pass_wrong!=""){
         echo"
         <br>
         <div class='alert alert-danger' role='alert'>"; 
         echo $pass_wrong . "
            </div>
         ";
     }
     ?>

    <?php
     if ($user_not_found!=""){
         echo"
         <br>
         <div class='alert alert-danger' role='alert'>"; 
         echo $user_not_found . "
            </div>
         ";
     }
     ?>     
    
    <table>
    <tr>
    <td>
        <br>
        <button type="submit" class="btn btn-primary mb-3">Login</button>
    </td>
    <td>
        <br>
        <a class="btn btn-primary mb-3" href="sign-up.php" role="button" >Sign-Up Now</a>
    </td>
    <td>
        <br>
        <a class="btn btn-primary mb-3" href="/" role="button" >Home</a>
    </td>
    </tr>
  </div>
</form>



<script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</script>

    </body>

</html>