<?php
// ========= NO NEED TO EDIT THIS PAGE ========
session_start(); // do not remove
include('inc.php'); // include the functions defined in inc.php do not remove.
if ($_POST['login'] == "yes") // checking login status
{
      $loginStatus = checkUserPass($_POST['user'], $_POST['pass']);
      if (!$loginStatus)
      {
            echo "<meta http-equiv='refresh' content='0;url=index.php?x=3'>";
      }else{
            echo "<meta http-equiv='refresh' content='0;url=view.php'>";
      }
}else{
if ( !isset($_SESSION['quoteAdmin']['login']) )
{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>QuoteMe v<?php echo $ver; ?> Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
      <link rel="stylesheet" type="text/css" href="style.css" >
</head>
<body onload="document.login.user.focus();">
<? showHeader($ver); // displays page header ?>
<form name=login method=POST action="<?php echo $_SERVER['PHP_SELF']; ?>">
<table border=0 cellpadding=2 cellspacing=0 width=300 class='login'>
<?php
if (isset($_GET['x'])) showError($_GET['x']);
?>
      <tr>
            <td>&nbsp</td>
            <td><div style="font-weight:bold;">Login</div></td>
      </tr>
      <tr>
            <td>Username:</td>
            <td><input type=text name="user"></td>
      </tr>
      <tr>
            <td>Password:</td>
            <td><input type=password name="pass"></td>
      </tr>
      <tr>
            <td><input type=hidden name="login" value='yes'></td>
            <td><input type=submit name="submit" value="Login"></td>
      </tr>
</table>
</form>
<br />
<? showFooter(); // displays page footer ?>
</body>
</html>
<?php
}else{
      echo "<meta http-equiv='refresh' content='0;url=view.php'>";
} // End if logged in test
}
?>
