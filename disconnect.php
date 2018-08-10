<?php
session_start();
$_SESSION = array(); //removing session's variables
//session_unset(); // removing session's variables //obsolete
setcookie('authentified', "", time()-3600); // negative time do not preserve cookies after closing 
session_destroy(); // unseting the session
header("Location:homePage.php"); // redirect to homePage.php
?>
