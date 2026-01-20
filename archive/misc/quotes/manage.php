<?php
// ========= NO NEED TO EDIT THIS PAGE ========
session_start(); // do not remove
$message = ""; // declaring message var to hold add/remove/update message
if (isset($_SESSION['quoteAdmin']['login']) ) // checking login status
{
include('inc.php'); // do not remove
$id = $_GET['id']; // gets Quote ID from URL
// ===== Begin: Do Not Edit the code below =====
if ($_POST['action'] == "update") // update/add record code
{
      if ($_POST['Submit'] == "Submit")
      {
            $message = "Update Successful";
      }elseif ($_POST['Submit'] == "Add"){
            $message = "Record Added";
      }
      $_SESSION['quoteAdmin']['quotes'][$id] = array('Quote' => $_POST['Quote'], 'Reference' => $_POST['Reference'], 'Link' => $_POST['Link']);
      $filename = $_SERVER['DOCUMENT_ROOT']."/".$_SESSION['quoteAdmin']['filename'];
      $fp = fopen($filename, "w+")or die ("Cannot open file '$filename'");
      $count = count($_SESSION['quoteAdmin']['quotes']);
      for( $i = 0 ; $i < $count ; $i++ )
      {
            $myData = $_SESSION['quoteAdmin']['quotes'][$i];
            $thisData .= implode("|", $myData);
            $thisData .= "|\n";
      }
      fwrite($fp, $thisData);
}else if ($_POST['action'] == "remove"){ // remove record code
      $message = "Record Deleted";
      $_SESSION['quoteAdmin']['quotes'][$id] = array();
      $filename = $_SERVER['DOCUMENT_ROOT']."/".$_SESSION['quoteAdmin']['filename'];
      $fp = fopen($filename, "w+")or die ("Cannot open file '$filename'");
      $count = count($_SESSION['quoteAdmin']['quotes']);
      for( $i = 0 ; $i < $count ; $i++ )
      {
            $myData = $_SESSION['quoteAdmin']['quotes'][$i];
            if ( count($myData) > 0 )
            {
            $thisData .= implode("|", $myData);
            $thisData .= "|\n";
            }
      }  
      fwrite($fp, $thisData);
}
//Button Label
$itemCount = count($_SESSION['quoteAdmin']['quotes'][$id]);
if ( $itemCount == 0 )
{
      $buttonLabel = "Add";
      $radioLabel = "Add";
      $otherRadio = 0;
}else{
      $buttonLabel = "Submit";
      $radioLabel = "Update";
      $otherRadio = 1;
}
// ===== End: Do Not Edit =====
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>QuoteMe v<?php echo $ver; ?> Manage Quote</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
      <link rel="stylesheet" type="text/css" href="style.css" >
<style>
.results td{
      font-family: sans-serif;
      font-size: 12px;
}
</style>
</head>

<body>
<? showHeader($ver); // displays page header ?>
<?php
// begin do not edit
$quoteArray = $_SESSION['quoteAdmin']['quotes'];
$quoteArrayCount = count($quoteArray);
for ($j = $id ; $j <= $id ; $j++ )
{
  $myQuote = $quoteArray[$j];
// end do not edit
?>
<?php
if (strLen($message) > 1)
{
  echo "<div style='color:red;'>".$message."</div>"; // displays update/add/remove confirmation message
}
?>
<?php if ($_SESSION['quoteAdmin']['dbCount'] > 1){ ?>
<div class='whichDatabase'>You are working with the <b><?php echo $_SESSION['quoteAdmin']['filename']; ?></b> database.</div>
<?php } ?>
<form action="<?php echo $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']; ?>" name="edit" method="POST">
<table width="100%"  border="0" cellspacing="2" cellpadding="2" class="results">
              <tr>
                <td width="70" valign="top"><div align="left">Quote:</div></td>
                <td><div align="left"><textarea name="Quote" cols=50 rows=5 ><?php echo stripslashes($myQuote['Quote']); ?></textarea></div></td>
              </tr>
              <tr>
                <td valign="top"><div align="left">Reference:</div></td>
                <td><input type=text name="Reference" size=100 value="<?php echo $myQuote['Reference']; ?>"></td>
              </tr>
              <tr>
                <td width="70" valign="top"><div align="left">Link:</div></td>
                <td><div align="left"><input type=text name="Link" size=100 value="<?php echo $myQuote['Link'];?>"></div></td>
              </tr>
              <tr>
                <td><input type=Submit name="Submit" value="<?php echo $buttonLabel; ?>"></td>
                <td><input type="radio" name="action" value="update" checked> <?php echo $radioLabel; ?><?php if ($otherRadio == 1){?>&nbsp;<input type="radio" name="action" value="remove">Remove<?}?></td>
              </tr>
            </table>
<?php 
}
?>
</form><br />
<table cellpadding="0" cellspacing="0" border="0" class="addBtn">
<tr>
    <td width="25"><div align="center"><a href="view.php"><img src='images/list.png' border="0"></a></div></td>
    <td width="95"><a href="view.php">View Quotes</a></td>
  </tr>
</table>
<br />
<? showFooter(); // displays page footer ?>
</body>
</html>
<?php
}else{
      // redirect to login if user is not already logged in.
      echo "<meta http-equiv='refresh' content='0;url=index.php?x=1'>";
}
?>
