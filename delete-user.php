<?php
session_start();
$pass_wrong="";

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    $nic=$_SESSION['nic'];
  }

  if(array_key_exists('delete', $_POST)){//delete
    $password=$_POST['password'];
    $hashed_password="";
    require_once "config.php";

    $sqlFindUser="SELECT usr_pwd FROM users WHERE usr_id=?";//get hashed pwd from db using user id (email)
    $stmt = mysqli_prepare($link, $sqlFindUser);//prepare
    mysqli_stmt_bind_param($stmt, "s", $nic);

    if(mysqli_stmt_execute($stmt)){
        // Store result
        mysqli_stmt_store_result($stmt);
        
        // Check if username exists, if yes then verify password
        if(mysqli_stmt_num_rows($stmt) == 1){//only continue if the result only has one row (one user)   
            mysqli_stmt_bind_result($stmt, $hashed_password);//get the hashed password from the sql result to a variable named $hashed_password

            if(mysqli_stmt_fetch($stmt)){
                if(password_verify($password, $hashed_password)){

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

                    //delete the user
                    $delete_query="DELETE from users  WHERE usr_id=?";
                    $stm = mysqli_prepare($link, $delete_query);//prepare
                    mysqli_stmt_bind_param($stm, "s",$nic);//bind email got from login.php
                    if(mysqli_stmt_execute($stm)){
                    // Store result
                    $_SESSION["loggedin"]=false;
                    header("location: login.php");
                    exit;
                 }
                }
                else{ 
                    $pass_wrong="Your password was incorrect. Please check and try again";
                }
            }
        }
    }
    
}
if(array_key_exists('back', $_POST)){//back
    header("location: editUser-panel.php");
  }
?>

<htmL>
    <head>
        <title>User Panel</title>
        <!-- Latest compiled and minified CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <style>
          #heading{
            padding: 40px;
            margin:0;
            text-align: center;
            background: transparent;
            color: black;
            font-size: 4vmax;
            font-weight:bolder;
          }
          body{
            background: url(bg.webp);
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
          }
          label.details{
            color: black;
            font-size: 20px;
            font-weight:500px;
          }
        </style>
      </head>
    <body>
        <h1 id="heading">User Panel</h1><br><br><br>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="container-fluid">
                

                <div class="row"><!--1st detail-->
                  <div class="col-md-4"></div>

                  <div class="col-md-3">
                    <label class="details">NIC </label>
                
                  </div>

                  <div class="col-md-4">
                  <input type="text" name="nic" id="nic" class="details2" value="<?php echo $nic?>" disabled required>
                
                  </div>

                  <div class="col-md-4"></div>
                </div>
                <div class="row"><!--1st detail-->
                  <div class="col-md-4"></div>

                  <div class="col-md-3">
                    <label class="details">Reason</label>
                
                  </div>

                  <div class="col-md-4">
                  <select name="reason" id="reason" class="details">
                    <option>No exact reason</option>
                    <option>Found a better app</option>
                    <option>Service is bad</option>
                    <option>Personal reason</option>
                </select>
                
                  </div>

                  <div class="col-md-4"></div></div>
                  <div class="row"><!--1st detail-->
                  <div class="col-md-4"></div>

                  <div class="col-md-3">
                    <label class="details">Password </label>
                
                  </div>

                  <div class="col-md-4">
                  <input type="password" name="password" id="password" class="details2">
                
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

                  <div class="col-md-4"></div>
                </div>
                </div><br>

                
            <br>
            <center><input type="submit" class="btn btn-primary mb-3" name="back" value="Back">
            <input type="submit" class="btn btn-primary mb-3" name="delete" onClick="confirm('do you really want to delete your account')" value="Delete Account"></center>
        </form>  
    </body>
</htmL>