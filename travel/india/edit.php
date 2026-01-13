<?php
include_once 'tools.php';
if (!isset ($_SESSION))
{
	session_start();
}
$cart_items = "";
if(isset ($_COOKIE['cartitems']))
{
	$cart_items = md5_decrypt($_COOKIE['cartitems']);
}
else
{
	$URL = "myCart.php";
	header ("Location: $URL");
}
if($cart_items == "")
{
	$URL = "myCart.php";
	header ("Location: $URL");
}
$edit_image = "";
if(isset ($_REQUEST['image']))
{
	$edit_image = ($_REQUEST['image']);
}
else
{
	$URL = "myCart.php";
	header ("Location: $URL");
}
if($edit_image == "")
{
	$URL = "myCart.php";
	header ("Location: $URL");
}
$edit_size = "";
if(isset ($_REQUEST['size']))
{
	$edit_size = ($_REQUEST['size']);
}
else
{
	$URL = "myCart.php";
	header ("Location: $URL");
}
if($edit_size == "")
{
	$URL = "myCart.php";
	header ("Location: $URL");
}
$edit_quantity = "";
if(isset ($_REQUEST['quantity']))
{
	$edit_quantity = ($_REQUEST['quantity']);
}
else
{
	$URL = "myCart.php";
	header ("Location: $URL");
}
if($edit_quantity == "")
{
	$URL = "myCart.php";
	header ("Location: $URL");
}
echo "
<head>
	<title> Efi Paz Edit Page</title>
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
    <div class='LeftTitle'> <a href='index.php'>Light Of India</a>: Edit cart item</div>
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
<div id='wrapper'>
<div align='center'>
	<br><br><br>
	<form action='update.php' method='POST'>
		<input type='hidden' name='image' value='".$edit_image."'>
		<input type='hidden' name='size' value='".$edit_size."'>
		Original Quantity: &nbsp;&nbsp;&nbsp;&nbsp; ".$edit_quantity." <br><br>
		&nbsp;&nbsp;&nbsp;&nbsp;Desired quantity: &nbsp;&nbsp;&nbsp;&nbsp;
		<input type='text' name='quantity' value='".$edit_quantity."' maxlength='3' size='3'
				style='color: #99ccff;BACKGROUND-COLOR: #555555;' border='0'>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type='submit' id='updatequanity' name='updatequanity' value='Update'>
		<br><br>
		<a href='myCart.php'>Back to my cart</a>
	</form>
</div>
</div>
</body>
</html>
";
?>