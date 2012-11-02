<?php
	session_start();
	unset($_SESSION['LoggedIn']);
	unset($_SESSION['username']);
?>
<meta http-equiv="refresh" content="0;index.php">
