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

$cart_array = explode("##", $cart_items);
$found = FALSE;
$index = 0;
foreach($cart_array as $key => $val)
{
	$item_array = explode("#", $val);
	if(strcmp($item_array[0],$edit_image) == 0 && strcmp($item_array[1], $edit_size) == 0)
	{
		$item_array[2] = $edit_quantity;
		$cart_array[$index] = implode("#", $item_array);
		$found = TRUE;
		break;
	}
	++$index;
}
if($found)
{
	$cart_items = implode("##", $cart_array);
}
setcookie('cartitems', md5_encrypt($cart_items), time() + 86400);
$URL = "myCart.php?update_message=1";
header ("Location: $URL");
?>