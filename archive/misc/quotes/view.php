<?php
// ========= NO NEED TO EDIT THIS PAGE ========
session_start(); // do not remove
include('inc.php'); // include the functions defined in inc.php do not remove.
if ( !isset($_SESSION['quoteAdmin']['login']) )
{
      echo "<meta http-equiv='refresh' content='0;url=index.php?x=1'>";
}else{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>QuoteMe v<?php echo $ver; ?> View Quote List</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
      <link rel="stylesheet" type="text/css" href="style.css" >
</head>
<body>
<? showHeader($ver); // displays page header ?>
<?php echo showFileNames($dbFileName); ?>
<?php
if ($_GET['db']){ // Database Flat File
    $_SESSION['quoteAdmin']['filename'] = $_GET['db'];
}else{
    $_SESSION['quoteAdmin']['filename'] = $dbFileName[0];
}
if (!isset($_SESSION['quoteAdmin']['filename']) )
{
    $filename = $_SERVER['DOCUMENT_ROOT']."/".$dbFileName[0];
    $_SESSION['quoteAdmin']['filename'] = $filename;
}else{
   $filename = $_SERVER['DOCUMENT_ROOT']."/".$_SESSION['quoteAdmin']['filename'];
}
?>
<?php if ($_SESSION['quoteAdmin']['dbCount'] > 1){ ?>
<div class='whichDatabase'>You are working with the <b><?php echo $_SESSION['quoteAdmin']['filename']; ?></b> database.</div>
<?php } ?>
<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="view">
  <tr>
    <th width="25">Edit</th>
    <th>Quote</th>
    <th>Reference</th>
    <th>Link</th>
  </tr>
<?php
// format for flat file is: quote|reference|link	
        $lines = file($filename);
        $quoteArray = array();
        $quoteCount = 0; // exists to count events.  If no events (==0), a message is displayed
        $numLines = count ($lines);
			for ($i = 0; $i < $numLines; $i++)
			{
        $line = $lines[$i];
        $element = explode("|",$line);
        $theQuote = $element[0];
        $theReference = $element[1];
        $theLink = $element[2];
        $theQuotes[$i] = array('Quote' => $theQuote, 'Reference' => $theReference, 'Link' => $theLink);
        $quoteCount++; // increments only if an event is to be echoed.
			}
$_SESSION['quoteAdmin']['quotes'] = $theQuotes;
$quoteArray = $_SESSION['quoteAdmin']['quotes'];
$quoteArrayCount = count($quoteArray);
for ($j = 0 ; $j < $quoteArrayCount ; $j++ )
{
$myQuote = $quoteArray[$j];
if ( $j % 2 != 0 ){ // alternating color of each row in the table
      $rowStyle = 'background-color: #F2F2F2';
}else{ 
      $rowStyle ='background-color: #FFFFFF';
}
?>
  <tr style="<?php echo$rowStyle; ?>">
    <td width="25"><div align="center"><a href="manage.php?id=<?php echo $j; ?>"><img src="images/quote.gif" width="12" height="12" border=0></a></div></td>
    <td><div align="left"><?php echo stripslashes($myQuote['Quote']); ?></div></td>
    <td><div align="left"><?php echo $myQuote['Reference']; ?></div></td>
    <td><div align="left"><?php if (strlen($myQuote['Link']) > 5 ){echo substr($myQuote['Link'], 0, 40)."&hellip;";}else{ echo "None"; } ?></div></td>
  </tr>
<?php
}
?>
</table><br />
<table cellpadding=2 cellspacing=0 border=0 width=240>
<tr>
      <td width=120>
<table cellpadding="0" cellspacing="0" border="0" class="addBtn">
  <tr>
    <td width="25"><div align="center"><a href="manage.php?id=<?php echo $j; ?>"><img src='images/add.gif' width="18" height="12" border="0"></a></div></td>
    <td width="95"><a href="manage.php?id=<?php echo $j; ?>">Add Record</a></td>
  </tr>
</table>      
      </td>

      <td width=120>
<table cellpadding="0" cellspacing="0" border="0" class="addBtn">
<tr>
    <td width="25"><div align="center"><a href="logout.php"><img src='images/logout.gif' border="0"></a></div></td>
    <td width="95"><a href="logout.php">Log Out</a></td>
  </tr>
</table>      
      </td>
</tr>
</table>
<br />
<? showFooter(); // displays page footer ?>
</body>
</html>
<?php } // end login test ?>
