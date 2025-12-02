<?php
include_once 'tools.php';
if (!isset ($_SESSION))
{
	session_start();
}
$category = "~";
if(isset($_REQUEST['category']))
{
	$category = $_REQUEST['category'];
}
$image_index = 0;
if(isset($_REQUEST['image']))
{
	$image_index = $_REQUEST['image'];
}
$image_info=0;
if(isset($_REQUEST['info']))
{
	$image_info = $_REQUEST['info'];
}
$image_cart=0;
if(isset($_REQUEST['cart']))
{
	$image_cart = $_REQUEST['cart'];
}
//get the order
$photo_size = 0;
if(isset($_REQUEST['photo_size']))
{
	$photo_size = $_REQUEST['photo_size'];
}
$quantity = 0;
if(isset($_REQUEST['quantity']))
{
	$quantity = $_REQUEST['quantity'];
}
$image_name = "";
if(isset($_REQUEST['image_name']))
{
	$image_name = $_REQUEST['image_name'];
}
if($photo_size == 0 || $quantity == 0 || $image_name == "")
{
	$URL = "gallery.php?category=".$category."&image=".$image_index."&info=".$image_info."&cart=".$image_cart."&cartmessage=0";
	header ("Location: $URL");

}
$cart_items = "";
if(isset ($_COOKIE['cartitems']))
{
	$cart_items = md5_decrypt($_COOKIE['cartitems']);
}
//add new item
if(strcmp($cart_items, "") != 0)
{
	$cart_array = explode("##", $cart_items);
	$found = FALSE;
	$index = 0;
	foreach($cart_array as $key => $val)
	{
		$item_array = explode("#", $val);
		if(strcmp($item_array[0],$image_name) == 0 && strcmp($item_array[1], $photo_size) == 0)
		{
			$item_array[2] = intval($quantity) + intval($item_array[2]);
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
	else
	{
		$cart_items = $cart_items."##".$image_name."#".$photo_size."#".$quantity;
	}
}
else
{
	$cart_items = $image_name."#".$photo_size."#".$quantity;
}
setcookie('cartitems', md5_encrypt($cart_items), time() + 86400);
$URL = "gallery.php?category=".$category."&image=".$image_index."&info=".$image_info."&cart=".$image_cart."&cartmessage=1";
header ("Location: $URL");
?>