<?php
// ========= NO NEED TO EDIT THIS PAGE ========
// processes the logout by removing the login session variable
session_start();
unset($_SESSION['quoteAdmin']);
echo "<meta http-equiv='refresh' content='0;url=index.php?x=2'>";
?>
