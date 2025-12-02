<?php
$main_title = "Efi Paz";
if(isset($_REQUEST['main_title']))
{
	$main_title = $_REQUEST['main_title'];
}
$sub_title = "";
if(isset($_REQUEST['sub_title']))
{
	$sub_title = $_REQUEST['sub_title'];
}
echo "
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td height='16' valign='top' width='300' class='linkstext'>
    <div class='LeftTitle'> <a href='index.php'>".$main_title."</a>: ".$sub_title."</div>
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
"
?>