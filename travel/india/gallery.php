<?php
include_once 'EXIF/EXIF.php';
include_once 'tools.php';
if (!isset ($_SESSION))
{
	session_start();
}
	//print_r($_COOKIE);
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
$image_info_link=1;
if($image_info == 1)
{
	$image_info_link=0;
}
$image_cart=0;
if(isset($_REQUEST['cart']))
{
	$image_cart = $_REQUEST['cart'];
}
$image_cart_link=1;
if($image_cart == 1)
{
	$image_cart_link=0;
}
$added_message = 0;
if(isset($_REQUEST['cartmessage']))
{
	$added_message = $_REQUEST['cartmessage'];
}
$category_array = explode('~', $category);
$main_category = $category_array[0];
$sub_category = $category_array[1];

echo "
<html>
<head>
	<title> Efi Paz Gallery Page</title>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	<meta http-equiv='Content-Style-Type' content='text/css'>
	<meta name='Author' content='Efi Paz'>
	<meta name='Keywords' content='Paz'>
	<meta name='Description' content='Efi Paz'>
	<link rel='stylesheet' href='index.css' type='text/css' media='screen'>

	<script language='JavaScript' type='text/JavaScript'>
		function updatePrice(form)
		{
			var quant = Math.round(form.quantity.value);
			var item_price = form.photo_size.options[form.photo_size.selectedIndex].value;
			form.sum_input.value = (quant * item_price);
		}
		function disableButton(button)
		{
		  var btnname = button.name;
		  document.getElementById(btnname).disabled = true;
		}
	</script>
</head>
<body>
";
$_REQUEST['main_title'] = "Light Of India";
$_REQUEST['sub_title'] = str_replace('_',' ',$main_category);
include_once "header.php";
$dirpath = "pictures";
$current_dir = $dirpath."/".$main_category."/".$sub_category;
$dh = opendir($current_dir);
$fs = Array();
$fs2 = Array();
$replacables = array("-","@");
while (false !== ($file = readdir($dh)))
{
	if(!is_dir("$current_dir/$file"))
	{
		$fs[] = $current_dir."/".$file;
	}
}
natsort($fs);
foreach($fs as $key => $val)
{
	$fs2[] = $val;
}
closedir($dh);
$count_images = count($fs2);
$last_image_index = $count_images - 1;
if($image_index > $last_image_index)
{
	$image_index = 0;
}
$next_image_index = $image_index + 1;
if($next_image_index > $last_image_index)
{
	$next_image_index = 0;
}
$prev_image_index = $image_index - 1;
if($prev_image_index < 0)
{
	$prev_image_index = $last_image_index;
}
$current_image_hir_array = explode("/", $fs2[$image_index]);
$count_hir_array = count($current_image_hir_array);
$current_title_atomic_full = $current_image_hir_array[$count_hir_array-1];
$current_image_title = substr($current_title_atomic_full, 0, strlen($current_title_atomic_full) - 4);
//show this image
echo "
<div id='wrapper'>
	<div align='center'>
		<a name='start'></a>
		";
		if($added_message == '1')
		{
			echo "<br><div align='center'>Item(s) were added to your cart&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href='gallery.php?category=".$category."&image=".$image_index."&info=".$image_info."&cart=".$image_cart."'>Remove this message</a>
				&nbsp;|&nbsp;
				<a href='myCart.php'>View my cart</a>
				</div>";
		}
		echo "
		<br>
		<table width='770' bgcolor='#333333' align='center' border='0' cellspacing='0' cellpadding='10'>
		<tr align='center' valign='top'>
		<td colspan='2' align='center' valign='top'>
		<img class='imggallery2' id='MainImage' src='".$fs2[$image_index]."' alt='".str_replace($replacables,' ',$current_image_title)."'></td>

		</tr>
		<tr><td valign='middle' align='center'>
";
$current_index = 0;
$current_title = 1;
$starting_point = 0;
$end_point = 14;
$count_fs2 = count($fs2);
if($image_index > 7)
{
	$starting_point = $image_index - 7;
	$end_point = $image_index + 7;
	if($end_point > ($count_fs2-1))
	{
		$end_point = $count_fs2-1;
		$starting_point = $end_point - 14;
	}
}


foreach($fs2 as $key => $theImage)
{
	if($current_index < $starting_point)
	{
		$current_index = $current_index + 1;
		$current_title = $current_title + 1;
		continue;
	}
	if($current_index > $end_point)
	{
		break;
	}
	if($current_index != $image_index)
	{
	echo "
		&nbsp;&nbsp;<a href='gallery.php?category=".$category."&image=".$current_index."#start'><font size='small'>
		".$current_title."</a>
	";
	}
	else
	{
	echo "
		&nbsp;&nbsp;<a href='gallery.php?category=".$category."&image=".$current_index."#start'>
		<font color='#FFC800' size='small'>".$current_title."</font></a>
	";
	}
	$current_index = $current_index + 1;
	$current_title = $current_title + 1;
}
if(($current_index - 1) < ($count_fs2 - 1))
{
	echo "
		&nbsp;...&nbsp;<a href='gallery.php?category=".$category."&image=".($count_fs2-1)."#start'><font size='small'>
		".$count_fs2."</a>&nbsp;&nbsp;&nbsp;&nbsp;
	";
}
else
{
	echo "
		&nbsp;&nbsp;&nbsp;&nbsp;
	";
}
echo "
<a href='gallery.php?category=".$category."&image=0#start'><img src='images/first.gif' border='0' /></a>
<a href='gallery.php?category=".$category."&image=".$prev_image_index."#start'><img src='images/prev.gif' border='0' /></a>
<a href='gallery.php?category=".$category."&image=".$next_image_index."#start' id='next_anchor'><img src='images/next.gif' border='0' /></a>
<script language='JavaScript' type='text/JavaScript'>
	document.getElementById('next_anchor').focus();
</script>
<a href='gallery.php?category=".$category."&image=".$last_image_index."#start'><img src='images/last.gif' border='0' /></a><br>
		</td></tr>
";
echo "
	</table>
</div>
</div>
<br>
<div align='center'>
		<table width='770' bgcolor='#333333' align='center' border='0' cellspacing='3' cellpadding='3'>
		<tr align='center' valign='middle'>
		<td colspan='2' align='left' valign='middle'>
		&nbsp;&nbsp;&nbsp;
		";
		if($image_info == '0')
		{
		echo "
		<a href='gallery.php?category=".$category."&image=".$image_index."&info=".$image_info_link."&cart=".$image_cart."#details'>
			<img src='images/open.gif'>
		</a>
		";
		}
		else
		{
		echo "
		<a href='gallery.php?category=".$category."&image=".$image_index."&info=".$image_info_link."&cart=".$image_cart."'>
					<img src='images/closed.gif'>
		</a>
		";
		}
		echo "
		&nbsp;<a name='details'>Image Details</a>
		</td>
		</tr>
		";
		if($image_info == '1')
		{
			$myImage = $fs2[$image_index];
			echo "
			<tr>
			<td colspan='2' align='center' valign='middle'>
			";
			echo Interpret_EXIF_to_HTML(get_EXIF_JPEG($myImage), $myImage);
			echo "
			</td></tr>
			";
		}
		echo "
		</table>
</div>
<br><br><br>
";
$_REQUEST['counter'] = "0";
include_once 'footer.php';
echo "
</body>
</html>
";
?>