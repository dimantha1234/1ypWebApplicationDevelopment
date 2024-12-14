<?php
// Initialize the session
session_start();
 
// Unset all of the session variables
$_SESSION = array();
 
// Destroy the session.
session_unset();
session_destroy();
session_regenerate_id();

$_SESSION['nic']='loggedout';
 
// Redirect to login page
header("location: /");


exit;
?>

