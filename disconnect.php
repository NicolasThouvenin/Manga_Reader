<?php
session_start();
$_SESSION = array();
session_destroy();
setcookie('authentified', "", time()-3600);
header("Location:homePage.php");
?>