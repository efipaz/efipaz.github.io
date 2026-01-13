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
echo "
<head>
	<title> Efi Paz Checkout Page</title>
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
if($cart_items == "")
{
	echo "
		<p>
		Your cart is currently empty. Nothing to checkout.&nbsp;&nbsp;<a href='galleries.php'>back to galleries</a>
		</p>
		";
}
else
{
	$cart_items_array = explode('##', $cart_items);
	$mail_content = "";
	$index = 1;
	$total_price = 0;
	$total_quantity = 0;
	foreach($cart_items_array as $key => $val)
	{
		$val_array = explode('#', $val);
		if(count($val_array) == 3)
		{
			$image = $val_array[0];
			$quantity = $val_array[1];
			$photo_size = get_size_from_price($val_array[2]);
			$sum = $val_array[1] * $val_array[2];
			$mail_content = $mail_content.$index.") ".$image.", QUANTITY: ".$quantity.",  SIZE: ".$photo_size." cm, PRICE: ".$sum."$\r\n";
			$total_quantity = $total_quantity + $val_array[1];
			$total_price = $total_price + $sum;
			++$index;
		}
	}
	if($total_quantity > 1)
	{
		$total_price = $total_price * 0.8;
		$mail_content = $mail_content." TOTAL PRICE: ".$total_price."$ (after 20% discount)";
	}
	else
	{
		$mail_content = $mail_content." TOTAL PRICE: ".$total_price."$";
	}
	echo "
	<div id='wrapper'>
		<div align='center'>
		<br>
		<table width='770' align='center' border='0' cellspacing='3' cellpadding='3'>
		<tr><td align='left'><b>Please provide your details:</b></td></tr>
		<form action='checkoutAction.php' method='POST'>
		<input type='hidden' name='content' value='".$mail_content."'>
			<tr>
			<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;Name:</td>
			<td align='left'>
			<input type='text' name='name' value='' maxlength='25' size='25'
					style='color:#99ccff;BACKGROUND-COLOR: #555555;'>
			</td>
			</tr>
			<tr>
				<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;E-mail:</td>
				<td align='left'>
				<input type='text' name='email' value='' maxlength='25' size='25'
						style='color:#99ccff;BACKGROUND-COLOR: #555555;'>
				</td>
			</tr>
			<tr>
				<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;Primary phone:</td>
				<td align='left'>
				<input type='text' name='phone' value='' maxlength='25' size='25'
						style='color:#99ccff;BACKGROUND-COLOR: #555555;'>
				</td>
			</tr>
			<tr>
				<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;Country:</td>
				<td align='left'>
				<input type='text' name='country' value='' maxlength='25' size='25'
						style='color:#99ccff;BACKGROUND-COLOR: #555555;'>
				</td>
			</tr>
			<tr>
				<td align='center' colspan='2'>
							<input type='submit' id='checkout' name='checkout' value='Order'>
				</td>
			</tr>
		</form>
		</table>
		</div>
	</div>
";
}
echo "
</body>
</html>
";
?>
