<?php
/* Database credential settings. Load everytime to make a connection on pages that needs database connectivity */

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'id18643062_healthline');
define('DB_PASSWORD', '+o]ITN522Opap<|k');
define('DB_NAME', 'id18643062_healthlineclinic');
 
/* Attempt to connect to MySQL database */

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if($link == false){
    echo ("<h1 class='text-center'> Database Error ! </h1>");
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
// Check connection

?>
