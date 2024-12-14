<?php
session_start();

$name=$_SESSION['usr_name'];
$nic=$_SESSION['nic'];
$member=$_SESSION['joinDate'];
$email=$_SESSION['email'];

//gender radio button auto select

$male = '';
$female = '';
if ($_SESSION['sex']=='M') {
  $male='checked="checked"';
}
else if ($_SESSION['sex']=='F'){
 $female='checked="checked"';
}


//sql les go
if(array_key_exists('save', $_POST)){
require_once "config.php";
$new_name=$_POST['name'];
$new_email=$_POST['email'];
$new_age=$_POST['age'];
$new_tele=$_POST['tele'];
$new_sex=$_POST['sex'];
$new_address=$_POST['address'];
$new_country=$_POST['country'];


$update_query="UPDATE users SET usr_email=?,usr_name=?,usr_tp=?,usr_gender=?,usr_address=?,usr_age=?,usr_country=? WHERE usr_id=?";


$stmt = mysqli_prepare($link, $update_query);//prepare
mysqli_stmt_bind_param($stmt, "ssssssss", $new_email,$new_name,$new_tele,$new_sex,$new_address,$new_age,$new_country,$nic);//bind email got from login.php

// Attempt to execute the prepared statement
if(mysqli_stmt_execute($stmt)){
  // Store result
  header("location: user-panel.php");
  exit;
}
}
?>

<htmL>
    <head>
        <title>Edit User Data</title>
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
        <h1 id="heading">Edit User Data</h1>
        <h3 class='text-center'></h3><br><br><br>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="container">
                <div class="row"><!--1st detail-->
                  <div class="col-md-4"></div>

                  <div class="col-md-3">
                    <label class="details">Name</label>
                
                  </div>

                  <div class="col-md-4">
                    <input type="text" name="name" id="name" class="details2" value="<?php echo $name?>" required>
                
                  </div>

                  <div class="col-md-4"></div>
                </div><br>

                <div class="row"><!--2nd detail-->
                  <div class="col-md-4"></div>

                  <div class="col-md-3">
                    <label class="details">Email </label>
                
                  </div>

                  <div class="col-md-4">
                  <input type="text" name="email" id="email" class="details2" value="<?php echo $email?>" required>
                
                  </div>

                  <div class="col-md-4"></div>
                </div><br>

                <div class="row"><!--3rd detail-->
                  <div class="col-md-4"></div>

                  <div class="col-md-3">
                    <label class="details">Age</label>
                
                  </div>

                  <div class="col-md-4">
                  <input type="number" min="1" max="120" name="age" id="age" class="details2" 
                  value="<?php
                  if($_SESSION['age']!="unknown"){
                    echo $_SESSION['age'];
                  }?>" 
                  required>
                
                  </div>

                  <div class="col-md-4"></div>
                </div><br>

                <div class="row"><!--4th detail-->
                  <div class="col-md-4"></div>

                  <div class="col-md-3">
                    <label class="details">Sex</label>
                
                  </div>

                  <div class="col-md-4">
                  <input type="radio" class="details" id="male" name="sex" value="M"
                  required <?php echo $male //show checked="checked" if the database return a M ?> >Male
                  <input type="radio" class="details" id="female" name="sex" value="F" required <?php echo $female //show checked="checked" if the database return a F ?> >Female
                
                  </div>

                  <div class="col-md-4"></div>
                </div><br>

                <div class="row"><!--5th detail-->
                  <div class="col-md-4"></div>

                  <div class="col-md-3">
                    <label class="details">Contact</label>
                
                  </div>

                  <div class="col-md-4">
                  <input type="tel" class="details" id="tele" name="tele" placeholder="07xxxxxxxx" pattern="[0]{1}[0-9]{9}" 
                  value="<?php if($_SESSION['tele']!="none"){
                  echo $_SESSION['tele'];
                  }?>" 
                  required>
                  </div>

                  <div class="col-md-4"></div>
                </div><br>

                <div class="row"><!--6th detail-->
                  <div class="col-md-4"></div>

                  <div class="col-md-3">
                    <label class="details">Address</label>
                
                  </div>

                  <div class="col-md-4">
                  <input type="text" class="details" id="address" name="address" rows="4" cols="50" maxlength="200" 
                  value="<?php if($_SESSION['address']!="unknown"){
                  echo $_SESSION['address'];
                  }?>"
                  required>
                
                  </div>

                  <div class="col-md-4"></div>
                </div><br>

                <div class="row"><!--7th detail-->
                  <div class="col-md-4"></div>

                  <div class="col-md-3">
                    <label class="details">Country</label>
                
                  </div>

                  <div class="col-md-4">
                  <input type="text" value="Sri-Lanka" class="details" name="country">
                
                  </div>

                  <div class="col-md-4"></div>
                </div><br>

                <div class="row"><!--8th detail-->
                  <div class="col-md-4"></div>

                  <div class="col-md-3">
                    <label class="details">Member Since</label>
                
                  </div>

                  <div class="col-md-4">
                  <input disabled type="text" value="<?php echo $member?>" class="details">
                
                  </div>

                  <div class="col-md-4"></div>
                </div><br>
            </div>
            <br>
            <center><input type="submit" class="btn btn-primary mb-3" name="save" value="Save">
            <a href="user-panel.php" class="btn btn-primary mb-3" name="delete">Go Back Without Saving</a>
            <br><br>
            <a href="delete-user.php" class="btn btn-danger mb-3" name="delete">Delete My Account</a>
        </form>  
    </body>
</htmL>