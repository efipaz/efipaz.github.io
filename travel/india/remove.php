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
$remove_image = "";
if(isset ($_REQUEST['image']))
{
	$remove_image = ($_REQUEST['image']);
}
else
{
	$URL = "myCart.php";
	header ("Location: $URL");
}
if($remove_image == "")
{
	$URL = "myCart.php";
	header ("Location: $URL");
}
$remove_size = "";
if(isset ($_REQUEST['size']))
{
	$remove_size = ($_REQUEST['size']);
}
else
{
	$URL = "myCart.php";
	header ("Location: $URL");
}
if($remove_size == "")
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
	if(strcmp($item_array[0],$remove_image) == 0 && strcmp($item_array[1], $remove_size) == 0)
	{
		//remove this line
		$array_left = array_slice($cart_array, 0, $index);
		$array_right = array_slice($cart_array, intval($index)+1);
		$cart_array = array_merge($array_left, $array_right);
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
$URL = "myCart.php?remove_message=1";
header ("Location: $URL");
?>