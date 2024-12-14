<?php
session_start();

$name="";
$tele="";
$country="";
$address="";
$age="";
$member="";
$sex="";
$email="";


if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  $nic=$_SESSION['nic'];
}

require_once "config.php";
$query="SELECT usr_name,usr_email,usr_tp,usr_address,usr_gender,usr_age,member_since,usr_country FROM users WHERE usr_id=?";
$stmt = mysqli_prepare($link, $query);//prepare
mysqli_stmt_bind_param($stmt, "s", $nic);//bind email got from login.php

// Attempt to execute the prepared statement
if(mysqli_stmt_execute($stmt)){
  // Store result
  mysqli_stmt_store_result($stmt);
  
  // Check if username exists, if yes then verify password
  if(mysqli_stmt_num_rows($stmt) == 1){//only continue if the result only has one row (one user)   
      mysqli_stmt_bind_result($stmt,$name,$email,$tele,$address,$sex,$age,$member,$country);//get variables from the sql result to a variable named $hashed_password
      mysqli_stmt_fetch($stmt);
      }
}

if(array_key_exists('edit', $_POST)){
  $_SESSION['usr_name']=$name;
  $_SESSION['joinDate']=$member;
  $_SESSION['age']=$age;
  $_SESSION['tele']=$tele;
  $_SESSION['sex']=$sex;
  $_SESSION['address']=$address;
  $_SESSION['email']=$email;
  header("location: editUser-panel.php");
  exit;
}


if(array_key_exists('logout', $_POST)) {
  $_SESSION["loggedin"]=false;
  header("location: login.php");
  exit;
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
          label.details2{
            color: lightblack;
            font-size: 20px;
          }
        </style>
      </head>
    <body>
        <h1 id="heading">My Account</h1>
        <h3 class='text-center'>This is your account data. Change or update if neccessary</h3><br><br><br>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="container ">
                <div class="row"><!--1st detail-->
                  <div class="col-md-4"></div>

                  <div class="col-md-3">
                    <label class="details">Name</label>
                
                  </div>

                  <div class="col-md-4">
                    <label class="details2"><?php echo $name; ?></label>
                
                  </div>

                  <div class="col-md-4"></div>
                </div><br>

                <div class="row"><!--2nd detail-->
                  <div class="col-md-4"></div>

                  <div class="col-md-3">
                    <label class="details">NIC</label>
                
                  </div>

                  <div class="col-md-4">
                    <label class="details2"><?php echo $nic; ?></label>
                
                  </div>
                  
                  <div class="col-md-4"></div>
                </div><br>

                <div class="row"><!--email-->
                  <div class="col-md-4"></div>

                  <div class="col-md-3">
                    <label class="details">Email</label>
                
                  </div>

                  <div class="col-md-4">
                    <label class="details2"><?php echo $email; ?></label>
                
                  </div>
                  
                  <div class="col-md-4"></div>
                </div><br>

                <div class="row"><!--3rd detail-->
                  <div class="col-md-4"></div>

                  <div class="col-md-3">
                    <label class="details">Age</label>
                
                  </div>

                  <div class="col-md-4">
                    <label class="details2"><?php echo $age; ?></label>
                
                  </div>

                  <div class="col-md-4"></div>
                </div><br>

                <div class="row"><!--4th detail-->
                  <div class="col-md-4"></div>

                  <div class="col-md-3">
                    <label class="details">Sex</label>
                
                  </div>

                  <div class="col-md-4">
                    <label class="details2"><?php echo $sex; ?></label>
                
                  </div>

                  <div class="col-md-4"></div>
                </div><br>

                <div class="row"><!--5th detail-->
                  <div class="col-md-4"></div>

                  <div class="col-md-3">
                    <label class="details">Contact</label>
                
                  </div>

                  <div class="col-md-4">
                    <label class="details2"><?php echo $tele; ?></label>
                
                  </div>

                  <div class="col-md-4"></div>
                </div><br>

                <div class="row"><!--6th detail-->
                  <div class="col-md-4"></div>

                  <div class="col-md-3">
                    <label class="details">Address</label>
                
                  </div>

                  <div class="col-md-4">
                    <label class="details2"><?php echo $address; ?></label>
                
                  </div>

                  <div class="col-md-4"></div>
                </div><br>

                <div class="row"><!--7th detail-->
                  <div class="col-md-4"></div>

                  <div class="col-md-3">
                    <label class="details">Country</label>
                
                  </div>

                  <div class="col-md-4">
                    <label class="details2"><?php echo $country; ?></label>
                
                  </div>

                  <div class="col-md-4"></div>
                </div><br>

                <div class="row"><!--8th detail-->
                  <div class="col-md-4"></div>

                  <div class="col-md-3">
                    <label class="details">Member Since</label>
                
                  </div>

                  <div class="col-md-4">
                    <label class="details2"><?php echo $member; ?></label>
                
                  </div>

                  <div class="col-md-4"></div>
                </div><br>
            </div>
            <br>
            <center><input type="submit" class="btn btn-primary mb-3" name="edit" value="Edit">
            <?php if($_SESSION['user_role']=='admin'){
              echo "<a class='btn btn-primary mb-3' href='/clinic-panel.php' role='button'>Back</a></center>";
            } 
            else echo "<a class='btn btn-primary mb-3' href='/appointment.php' role='button'>Back</a></center>";

            ?>
            
        </form>  
    </body>
</htmL>