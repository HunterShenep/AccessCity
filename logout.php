<?php
session_start();
session_unset('session');
session_destroy();
$_SESSION = array();

die("<meta http-equiv=\"refresh\" content=\"0; URL='login.php'\" />");

?>
