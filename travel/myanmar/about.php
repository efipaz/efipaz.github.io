<?php
//read the about.txt file
$about_handle = fopen('texts/about.txt', 'rb');
$about_buffer = fread($about_handle, 2048);
flush();
fclose($about_handle);
//read the FAQ.txt file
$faq_handle = fopen('texts/faq.txt', 'rb');
$faq_buffer = fread($faq_handle, 4096);
flush();
fclose($faq_handle);

echo "
<html>
<head>
	<title> Efi Paz About Page</title>
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
    <div class='LeftTitle'> <a href='index.php'>Burma</a>: about
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
<div id='wrapper'>
		<div align='center'>
			<br>
			<table width='965'  align='center' border='0' cellspacing='0' cellpadding='0'>
   				<tr align='center' valign='middle'>
   					<td align='left' width='48%' valign='top'>
				<div id='gallerycommenttext'>
				<table width='463' border='0' cellspacing='0' cellpadding='0'>
					<tr><td align='left'><img src='images/efi.jpg' border='0'></td></tr>
					<tr><td>&nbsp;</td></tr>
					<tr><td valign='bottom'>
						".$about_buffer."
					</td></tr>
				</table>
				</div>
					</td>
					<td align='left' width='4%' valign='top'>&nbsp;&nbsp;</td>
					<td align='right'  width='48%' valign='top'>
				<div id='gallerycommenttext'>
				<table width='463' border='0' cellspacing='0' cellpadding='0'>
					<b> Frequently Asked Questions</b>
					<br>
					".$faq_buffer."
				</table>
				</div>
					</td></tr></table>
		</div>
</div>
";
$_REQUEST['counter'] = "0";
include_once 'footer.php';
echo "
</body>
</html>
";
?>