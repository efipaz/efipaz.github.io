<?php
$name = "";
if(isset($_REQUEST['name']))
{
	$name = $_REQUEST['name'];
}
echo "
<html>
<head>
	<title> Efi Paz Thank You Mail Page</title>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	<meta http-equiv='Content-Style-Type' content='text/css'>
	<meta name='Author' content='Efi Paz'>
	<meta name='Keywords' content='Paz'>
	<meta name='Description' content='Efi Paz'>
	<link rel='stylesheet' href='index.css' type='text/css' media='screen'>
</head>
<body>
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td height='16' valign='top' class='linkstext'>
    <div class='LeftTitle'> <a href='index.php'>Light Of India</a>: My Cart</div>
    </td>
	<td height='16' valign='top' class='linkstext'>
	<div class='RightTitle'>
		<a href='index.php'>Home</a>
		&nbsp;&nbsp;
		<a href='galleries.php'>Galleries</a>
		&nbsp;&nbsp;
		<a href='favorites.php'>Favorites</a>
        &nbsp;&nbsp;
        <a href='about.php'>About</a>
        &nbsp;&nbsp;
        <a href='mailto:efipaz@gmail.com'>Email</a>
        &nbsp;&nbsp;
        <a href='http://efipaz.blogspot.com' target='_blank'>Our Blog</a>
		&nbsp;&nbsp;
    </div>
    </td>
  </tr>
</table>
";
echo "
<div id='wrapper'>
	<div align='center'>
	<br>
	".$name.", Your order has been sent by mail, and a confirmation e-mail was sent to you.<br>Thank you for ordering.<br><a href='galleries.php'>Back to galleries</a>
	";
?>