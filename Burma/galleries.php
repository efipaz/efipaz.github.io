<?php
echo "
<html>
<head>
	<title> Efi Paz Galleries Page</title>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	<meta http-equiv='Content-Style-Type' content='text/css'>
	<meta name='Author' content='Efi Paz'>
	<meta name='Keywords' content='Paz'>
	<meta name='Description' content='Efi Paz'>
	<link rel='stylesheet' href='index.css' type='text/css' media='screen'>

	<script language='JavaScript' type='text/JavaScript'>
	function preloadImages()
	{
	  var d=document;
	  if(d.images)
	  {
	  	if(!d.MM_p)
	  	{
	  		d.MM_p=new Array();
	  	}
	    var i,j=d.MM_p.length,a=preloadImages.arguments;
	    for(i=0; i<a.length; i++)
	    {
	    	d.MM_p[j]=new Image;
	    	d.MM_p[j++].src=a[i];
	    }
	  }
	}

	function swapImage()
	{
	  var i,j=0,x,a=swapImage.arguments;
	  document.MM_sr=new Array;
	  for(i=0;i<(a.length-2);i+=3)
	  {
	  	 if ((x=findObj(a[i]))!=null)
	  	 {
	  	 	document.MM_sr[j++]=x;
	  	 	if(!x.oSrc)
	  	 	{
	  	 		x.oSrc=x.src;
	  	 	}
	  	 	x.src=a[i+2];}
	  }
	}

	function findObj(n, d)
	{
	  var p,i,x;
	  if(!d) d=document;
	  if((p=n.indexOf('?'))>0&&parent.frames.length)
	  {
	    d=parent.frames[n.substring(p+1)].document;
	    n=n.substring(0,p);
	  }
	  if(!(x=d[n])&&d.all)
	  {
	  	x=d.all[n];
	  }
	  for (i=0;!x&&i<d.forms.length;i++)
	  {
	  	x=d.forms[i][n];
	  }
	  for(i=0;!x&&d.layers&&i<d.layers.length;i++)
	  {
	  	x=findObj(n,d.layers[i].document);
	  }
	  if(!x && d.getElementById)
	  {
	  	x=d.getElementById(n);
	  }
	  return x;
	}
	</script>
</head>
";
function getSessionVariable($strParam) {
	global $HTTP_SESSION_VARS;
	if(!isset($_SESSION)) {
			session_start();
	}
	if (isset($_SESSION)) {
		if (isset($_SESSION[$strParam])) {
			return $_SESSION[$strParam];
		} else {return false;}
	} else if (isset($HTTP_SESSION_VARS)) {
		if (isset($HTTP_SESSION_VARS[$strParam])) {
			return $HTTP_SESSION_VARS[$strParam];
		} else {return false;}
	}
}

function my_bcmod( $x, $y )
{
   // how many numbers to take at once? carefull not to exceed (int)
   $take = 5;
   $mod = '';

   do
   {
       $a = (int)$mod.substr( $x, 0, $take );
       $x = substr( $x, $take );
       $mod = $a % $y;
   }
   while ( strlen($x) );

   return (int)$mod;
}
function jsspecialchars($s) {
   return preg_replace('/([^ !#$%@()*+,-.\x30-\x5b\x5d-\x7e])/e',
       "'\\x'.(ord('\\1')<16? '0': '').dechex(ord('\\1'))",$s);
}
function natSortKey(&$arrIn)
{
   $key_array = array();
   $arrOut = array();

   foreach ( $arrIn as $key=>$value ) {
       $key_array[]=$key;
   }
  natsort( $key_array);
  foreach ( $key_array as $key=>$value ) {
     $arrOut[$value]=$arrIn[$value];
  }
  $arrIn=$arrOut;
}
$checkout_done = "";
if(isset($_REQUEST['checkout_done']))
{
	$checkout_done = $_REQUEST['checkout_done'];
}
//$top_level_dir[] = getSessionVariable('top_level_directories');
//$second_level_dir[] = getSessionVariable('second_level_directories');
$dirpath = "pictures";
$dh = opendir($dirpath);
//read first level dirs
$top_level = Array();
$second_level = Array();
$fs = Array();
$fs_firsts = Array();
while (false !== ($dir = readdir($dh)))
{
	 if (is_dir("$dirpath/$dir") && $dir != "." && $dir != "..")
	 {
		$top_level[] = $dirpath."/".$dir;
		//read second level dirs
		$subdh = opendir($dirpath."/".$dir);
		while (false !== ($subdir = readdir($subdh)))
		{
			if(is_dir("$dirpath/$dir/$subdir") && $subdir != "." && $subdir != "..")
			{
				$second_level[] = $dirpath."/".$dir."/".$subdir;
				//read list of files in the second level directory
				$subsubdh = opendir($dirpath."/".$dir."/".$subdir);
				//$first = true;
				$fs_local = Array();
				while (false !== ($file = readdir($subsubdh)))
				{
					if(!is_dir("$dirpath/$dir/$subdir/$file"))
					{
						//if($first == true)
						//{
					//$fs_firsts[] = $dirpath."/".$dir."/".$subdir."/".$file;
					//		$first = false;
					//	}
					$fs[] = $dirpath."/".$dir."/".$subdir."/".$file;
					$fs_local[] = $file;
					}
				}
				natsort($fs_local);
				foreach($fs_local as $key => $val)
				{
					$theFirst = $val;
					break;
				}
				$fs_firsts[] = $dirpath."/".$dir."/".$subdir."/".$theFirst;
				closedir($subsubdh);
			}
		}
		closedir($subdh);
	}
}
closedir($dh);
$top_level_size = count($top_level);
$second_level_size = count($second_level);
$string_iamges = "";
foreach($fs_firsts as $key => $oneFirst)
{
	$string_iamges .= "'".htmlentities($oneFirst)."',";
}
$string_iamges = htmlentities(substr($string_iamges, 0 , strlen($string_iamges) - 1));
echo "
	<body onload=preloadImages(".$string_iamges.")>
	<table width='100%' border='0' cellspacing='0' cellpadding='0'>
	  <tr>
	    <td height='16' valign='top' width='300' class='linkstext'>
	    <div class='LeftTitle'> <a href='index.php'>Burma</a>: galleries</div>
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
	";
	if(checkout_done == '1')
	{
		echo "
		<br>
		your order has been set. A copy of the order mail has been sent to you. Thank you. &nbsp;&nbsp;<a href='galleries.php'>Remove</a>
		";
	}
	echo "
	<br>
		<table width='965'  align='center' border='0' cellspacing='0' cellpadding='0'>
   				<tr align='center' valign='middle'>
   					<td align='left' width='48%' valign='top'>
";
$count3 = 0;
foreach($top_level as $value)
{
	$split = explode('/', $value);
	$desc_path = $value.'/description.txt';
	$desc_value ='';
	if(file_exists($desc_path))
	{
		$desc_handler = fopen($desc_path,'r');
		$desc_value = fread($desc_handler, filesize($desc_path));
		fclose($desc_handler);
	}
	//get the first file in the fist sub directory, to show by default
	$default_iamge = '';
	$count3++;
	$count = 0;
	foreach($second_level as $value3)
	{
		$split3 = explode('/', $value3);
		if($split3[1] == $split[1])
		{
			$count++;
			foreach($fs_firsts as $value4)
			{
				$split4 = explode('/', $value4);
				if($split4[1] == $split[1] && $split4[2]==$split3[2])
				{
					$default_image = $value4;
					break;
				}
			}
			$width = 100;
			if($count > 0)
			{
				$width = 100/$count;
			}
		}
	}
	echo "
	<div id='gallerycommenttext'>
	<strong>".str_replace('_',' ',$split[1])."</strong><br>".$desc_value."<br><br>
	<div align='center'><img class='galleryimage' name='".$split[1]."' src='".$default_image."' border='1' alt='".str_replace('_',' ',$split[1])."'/>
	</div>
	<br>
	<table width='100%' align='center' border='0' cellspacing='0' cellpadding='0'>
		<tr align='center' valign='middle'>
	";
	$count2 = 0;
	foreach($second_level as $value2)
	{
		$split2 = explode('/', $value2);
		$width="33%";
		if($split2[1] == $split[1])
		{
			if(my_bcmod($count2, 3) == '0')
			{
				echo "
				</tr><tr align='center' valign='middle'>
				";
			}
			$count2++;
			if(my_bcmod($count2, 3) == '0')
			{
				$width="34%";
			}
			$default_image_sub = '';
			foreach($fs_firsts as $value5)
			{
				$split5 = explode('/', $value5);
				if($split5[1] == $split2[1] && $split5[2] == $split2[2])
				{
					$default_image_sub = $value5;
					break;
				}
			}
			echo "
				<td align='center' width=".$width." valign='middle'>
					<a href='gallery.php?category=".urlencode($split2[1]."~".$split2[2])."&image=0#start' onmouseover=swapImage('".htmlentities($split[1])."','','".htmlentities($default_image_sub)."',1)>".str_replace('_',' ',$split2[2])."</a>
				</td>
			";
		}
	}
	echo "
		</tr>
	</table>
	</div>
	";
	$top_level_size_second = floor($top_level_size/2 + 0.5);
	if(my_bcmod($count3, $top_level_size_second) == '0')
	{
		echo "
		</td>
		<td align='left' width='4%' valign='top'></td>
		<td align='left'  width='48%' valign='top'>
		";
	}
}
echo "
						</td>
				</table>
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