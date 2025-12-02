<?php
include_once 'EXIF/EXIF.php';
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
echo "
<html>
<head>
	<title> Efi Paz Favourites Page</title>
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
    <td height='16' valign='top' width='300' class='linkstext'>
    <div class='LeftTitle'> <a href='index.php'>Burma</a>: favorites
    </div>
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
$dirpath = "favorites";
$dh = opendir($dirpath);
$fs = Array();
while (false !== ($file = readdir($dh)))
{
	if(!is_dir("$dirpath/$file"))
	{
		$fs[] = $dirpath."/".$file;
	}
}
closedir($dh);
$count_images = count($fs);
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
$current_image_hir_array = explode("/", $fs[$image_index]);
$count_hir_array = count($current_image_hir_array);
$current_title_atomic_full = $current_image_hir_array[$count_hir_array-1];
$current_image_title = substr($current_title_atomic_full, 0, strlen($current_title_atomic_full) - 4);
//show this image
echo "
<div id='wrapper'>
	<div align='center'>
		<a name='start'></a>
		<br>
		<table width='770' bgcolor='#333333' align='center' border='0' cellspacing='0' cellpadding='10'>
		<tr align='center' valign='top'>
		<td colspan='2' align='center' valign='top'>
		<img class='imggallery2' id='MainImage' src='".$fs[$image_index]."' alt='".str_replace('-',' ',$current_image_title)."'></td></tr>
		<tr><td valign='middle' align='center'>
";
$current_index = 0;
$current_title = 1;
$starting_point = 0;
$end_point = 14;
$count_fs2 = count($fs);
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
foreach($fs as $theImage)
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
		&nbsp;&nbsp;<a href='favorites.php?image=".$current_index."#start'><font size='small'>
		".$current_title."</a>
	";
	}
	else
	{
	echo "
		&nbsp;&nbsp;<a href='favorites.php?image=".$current_index."#start'>
		<font color='#FFC800'>".$current_title."</font></a>
	";
	}
	$current_index = $current_index + 1;
	$current_title = $current_title + 1;
}
if(($current_index - 1) < ($count_fs2 - 1))
{
	echo "
		&nbsp;...&nbsp;<a href='gallery.php?category=".$category."&image=".($count_fs2-1)."#start'><font size='small'>
		".$count_fs2."&nbsp;&nbsp;&nbsp;&nbsp;</a>
	";
}
else
{
	echo "
		&nbsp;&nbsp;&nbsp;&nbsp;
	";
}
echo "
<a href='favorites.php?image=0#start'><img src='images/first.gif' border='0' /></a>
<a href='favorites.php?image=".$prev_image_index."#start'><img src='images/prev.gif' border='0' /></a>
<a href='favorites.php?image=".$next_image_index."#start'><img src='images/next.gif' border='0' /></a>
<a href='favorites.php?image=".$last_image_index."#start'><img src='images/last.gif' border='0' /></a><br>
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
		<a href='favorites.php?image=".$image_index."&info=".$image_info_link."#details'>
			<img src='images/open.gif'>
		</a>
		";
		}
		else
		{
		echo "
		<a href='favorites.php?image=".$image_index."&info=".$image_info_link."'>
					<img src='images/closed.gif'>
		</a>
		";
		}
		echo "
		<a name='details'>&nbsp;Image Details...</a>
		</td>
		</tr>
		";
		if($image_info == '1')
		{
			$myImage = $fs[$image_index];
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