<?php
function setSessionVariable($strParam,$value) {
	global $HTTP_SESSION_VARS;
	if(!isset($_SESSION)) {
		session_start();
	}
	if (isset($_SESSION)) {
		$_SESSION[$strParam]=$value;
	} else if (isset($HTTP_SESSION_VARS)) {
		eval("global \$".$strParam.";");
		eval("\$".$strParam."=\"\";");
		eval("\$".$strParam."= \"".$value."\";");
		eval("session_register('".$strParam."');");
	}
}
$dirpath = "Wide";
$dh = opendir($dirpath);
//read first level dirs
//$top_level = Array();
//$second_level = Array();
$fs = Array();
//while (false !== ($dir = readdir($dh)))
//{
//	 if (is_dir("$dirpath/$dir") && $dir != "." && $dir != "..")
//	 {
//		$top_level[] = $dirpath."/".$dir;
//		//read second level dirs
//		$subdh = opendir($dirpath."/".$dir);
//		while (false !== ($subdir = readdir($subdh)))
//		{
//			if(is_dir("$dirpath/$dir/$subdir") && $subdir != "." && $subdir != "..")
//			{
//				$second_level[] = $dirpath."/".$dir."/".$subdir;
//				//read list of files in the second level directory
//				$subsubdh = opendir($dirpath."/".$dir."/".$subdir);
//				while (false !== ($file = readdir($subsubdh)))
//				{
//					if(!is_dir("$dirpath/$dir/$subdir/$file"))
//					{
//						$fs[] = $dirpath."/".$dir."/".$subdir."/".$file;
//					}
//				}
//				closedir($subsubdh);
//			}
//		}
//		closedir($subdh);
//	}
//}
while (false !== ($file = readdir($dh)))
{
	if(!is_dir("$dirpath/$file"))
	{
		$fs[] = $dirpath."/".$file;
	}
}
closedir($dh);
//choose a random file for presentation in the page
$count_images = count($fs);
$random_image_index = rand(0, $count_images - 1);
$the_image = $fs[$random_image_index];
//save the arrays in the session
//setSessionVariable('top_level_directories', $top_level);
//setSessionVariable('second_level_directories', $second_level);
//setSessionVariable('file_list', $fs);
//$_REQUEST['top_level_directories'] = $top_level;
//$_REQUEST['second_level_directories'] = $second_level;
//session_start();
//session_register("top_level");
//session_register("second_level");
//session_register("fs");
//$url = "galleries.php?top_level=$top_level&second_level=$second_level";
//read the home.txt file
$home_handle = fopen('texts/home.txt', 'rb');
$home_buffer = fread($home_handle, 2048);
flush();
fclose($home_handle);
$url = "galleries.php";
echo "
<html>
<head>
	<title> Efi Paz Home Page</title>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	<meta http-equiv='Content-Style-Type' content='text/css'>
	<meta name='Author' content='Efi Paz'>
	<meta name='Keywords' content='Paz'>
	<meta name='Description' content='Efi Paz'>
	<link rel='stylesheet' href='index.css' type='text/css' media='screen'>
</head>
<body>
";
$_REQUEST['main_title'] = "Light Of India";
$_REQUEST['sub_title'] = "Home";
include_once "header.php";
echo "
	<div id='wrapper'>
		<div align='center'>
			<br>
			<a href='".$url."'>
				<img class='imgrandom' src='".htmlentities($the_image)."' alt='Photographs'>
			</a>
		</div>
		<br><br>
		 <center>
			<div id='commenttext'>
				 <table width='770' border='0' cellspacing='0' cellpadding='2'>
					<tr><td>
					".$home_buffer."
					</td></tr>
				</table>
				<br>
				<table width='770' border='0' cellspacing='0' cellpadding='2'>
					<tr><td colspan='2'>
					<a href='favorites.php'>Favorites</a>
					</td>
					<td colspan='2'>
					quick glance of some of my favorite photos
					</td>
					</tr>
					<tr><td colspan='2'>
					<a href='galleries.php'>Galleries</a>
					</td>
					<td colspan='2'>
					The photo galleries arranged by subjects and categories
					</td>
					</tr>

				</table>
			</div>
			<p>
				Best viewed with 1024X768 resolution.<br><br>
			</p>
		</center>
	</div>
	";
	$_REQUEST['counter'] = "1";
	include_once 'footer.php';
	echo "
</body>
</html>
";
?>