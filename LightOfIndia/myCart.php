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
$remove_message = "";
if(isset ($_REQUEST['remove_message']))
{
	$remove_message = $_REQUEST['remove_message'];
}
$update_message = "";
if(isset ($_REQUEST['update_message']))
{
	$update_message = $_REQUEST['update_message'];
}
$rep = array("-","@","_");

function getAtomicImageName ($filename)
{
	$current_image_hir_array = explode("/", $filename);
	$count_hir_array = count($current_image_hir_array);
	$current_title_atomic_full = $current_image_hir_array[$count_hir_array-1];
	$atomic = substr($current_title_atomic_full, 0, strlen($current_title_atomic_full) - 4);
	$atomic = str_replace("-", " ", $atomic);
	$atomic = str_replace("@", " ", $atomic);
	$atomic = str_replace("_", " ", $atomic);
	return trim($atomic);
}
echo "
<html>
<head>
	<title> Efi Paz View Cart Page</title>
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
	";
	if($cart_items == "")
	{
		echo "
			<p>
			Your cart is currently empty.&nbsp;&nbsp;<a href='galleries.php'>back to galleries</a>
			</p>
		";
	}
	else
	{
		if($remove_message == '1')
		{
			echo "Item was removed.&nbsp;&nbsp;&nbsp;&nbsp;<a href='myCart.php'>Remove this message</a>";
			echo "<br>";
		}
		else if($update_message == '1')
		{
			echo "Item was updated.&nbsp;&nbsp;&nbsp;&nbsp;<a href='myCart.php'>Remove this message</a>";
			echo "<br>";
		}

		$cart_items_array = explode('##', $cart_items);
		echo "
		<h3 align='center'>Your Photos Shopping Cart</h3>
		<br>
		<table width='770' align='center' border='0' cellspacing='0' cellpadding='0'>
		<tr>
		<td></td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;<b>Id</b></td>
		<td><b>Name</b></td>
		<td><b>Quantity</b></td>
		<td><b>Photo Size</b></td>
		<td><b>Price</b></td>
		<td></td>
		<td></td>
		</tr>
		<tr>
		   <td colspan='8'><hr class='divider' width='100%' size='2' noshade /></td>
		</tr>
		";
		$id = 1;
		$total_price = 0;
		$total_quantity = 0;
		foreach($cart_items_array as $key => $val)
		{
			$val_array = explode('#', $val);
			if(count($val_array) == 3)
			{
				$image_atomic = getAtomicImageName($val_array[0]);
				$sum_photos = $val_array[2] * $val_array[1];
				$photo_size = get_size_from_price($val_array[1]);
				echo "
				<tr>
				<td valign='middle'><img src='$val_array[0]' width='60' height='40' border='1' alt='".$image_atomic."'></td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;".$id."&nbsp;&nbsp;&nbsp;&nbsp;</td><td>".$image_atomic."</td><td>&nbsp;&nbsp;&nbsp;".$val_array[2]."</td><td>".$photo_size." cm</td><td>".$sum_photos."$</td>
				<td><a href='edit.php?image=".$val_array[0]."&size=".$val_array[1]."&quantity=".$val_array[2]."'>edit</a></td><td>&nbsp;&nbsp;&nbsp;&nbsp;<a href='remove.php?image=".$val_array[0]."&size=".$val_array[1]."'>remove</a></td>
				</tr>
				<tr>
				   <td colspan='8'><hr class='divider' width='100%' size='1' noshade /></td>
				</tr>
				";
			$total_quantity = $total_quantity + $val_array[2];
			$total_price = $total_price + $sum_photos;
			++$id;
			}
		}
		if($total_quantity > 1)
		{
			$total_price = $total_price * 0.8;
		}
		echo "
			<tr><td></td><td></td><td></td><td>&nbsp;</td><td></td><td></td></tr>
			";
			if($total_quantity > 1)
			{
			echo "<tr><td></td><td></td><td></td><td></td><td><b>Total Price:&nbsp;</b></td><td><b>".$total_price."$</b>  (after 20% discount)</td></tr>";
			}
			else
			{
				echo "<tr><td></td><td></td><td></td><td></td><td><b>Total Price:&nbsp;</b></td><td><b>".$total_price."$</b></td></tr>";
			}
			echo "
			<tr><td></td><td></td><td></td><td>&nbsp;</td><td></td><td></td></tr>
			<tr><td></td><td></td><td></td><td>&nbsp;</td><td></td><td></td></tr>
			<tr><td></td><td></td><td></td><td>&nbsp;</td><td></td><td></td></tr>
			<tr>
				<td colspan='3'>&nbsp;</td>
				<td><a href='galleries.php'>Back to galleries</a></td>
				<td></td>
				<td><a href='checkout.php'><b>Checkout</b></a></td>
				<td colspan='3'></td>
			</tr>
			</table>
		";
	}
	echo "
	</div>
</div>
</body>
</html>
";
?>