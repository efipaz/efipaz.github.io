<?php
/*
==== Begin Editable Functions =====
*/
function checkUserPass($theUser, $thePass)
{
/*
The purpose of the checkUserPass function is to validate the login
To personalize your username and password, change the variables below:
$myUsername = "ENTER YOUR DESIRED USERNAME";
$myPassword = "ENTER YOUR DESIRED PASSWORD";
*/
      $myUsername = "efipaz"; // CHANGE TO YOUR USERNAME
      $myPassword = "tequila"; // CHANGE TO YOUR PASSWORD
      $userCompare = strcmp($theUser, $myUsername);
      $passCompare = strcmp($thePass, $myPassword);
      if ( ($userCompare == 0) && ($passCompare == 0) )
      {
            $_SESSION['quoteAdmin']['login'] = 1;
            return true;
      }else{
            return false;
      }
}

$dbFileName = array("quote/quotes.txt");
/*
The variable $dbFileName is an array of the paths to the quote databases.  The example above indicates that the database files are in the same directory as the script.  If you put them in a different directory, say quotes/, then this variable would look like:
$dbFileName = array("quotes/political.db","quotes/religious.db");
if you want to pull from one database, the array should look like:
$dbFileName = array("political.db");
*/

function outputLine($theQuote, $theRef, $theLink)
{
/*
The purpose of the outputLine function is to echo the quote to your web page as a <div>.  This can be placed in a table or across the top or bottom of the page,etc.
*/
// Don't edit this if as it determines if there is a link that should be displayed.
      if ( strlen($theLink) > 5 )
      {
            $myLink = "<a href='".$theLink."' target='_blank'>".$theRef."</a>";
      }else{
            $myLink = $theRef;
      }
// stripslases removes \ characters that php places next to protected chars like apostrophes.  For example can't becomes can\'t. Don't edit this line.
      $myQuote = stripslashes($theQuote);
      $quoteHTML = "<div align='center'>".$myQuote." - ".$myLink."</div>";
      return $quoteHTML;
}

function outputTable($theQuote, $theRef, $theLink)
{
/*
The purpose of the outputTable function is to echo the quote to your web page as a Table.  You can define the table's parameters in this code.
*/
// Don't edit this if as it determines if there is a link to be displayed
      if ( strlen($theLink) > 5 )
      {
            $myLink = "<a href='".$theLink."' target='_blank'>".$theRef."</a>";
      }else{
            $myLink = $theRef;
      }
// stripslases removes \ characters that php places next to protected chars like apostrophes.  For example can't becomes can\'t. Don't edit this line.
      $myQuote = stripslashes($theQuote);
      $quoteHTML = "<table border=1 width=850px align='center'><tr><td bgcolor=#E7E7E7><div align='center'>".$myQuote." - ".$myLink."</div></td></tr></table>";
      return $quoteHTML;
}
/*
==== End Editable Functions =====
*/

function showFileNames($dbFileName)
{
/*
The purpose of this function is to produce a menu of Quote Databases if you are working with more than one DB using the Admin Tool.  No need to edit.
*/
  $count = count($dbFileName);
  $_SESSION['quoteAdmin']['dbCount'] = $count; 
  if ($count > 1)
  {
    $outputMenu = "<div class='dbFileNames'>Databases: ";
    for ($i = 0 ; $i < $count ; $i++)
    {
      $outputMenu .= "<a href='view.php?db=".$dbFileName[$i]."'>".$dbFileName[$i]."</a>";      
      if ($i < $count - 1) $outputMenu .= " | ";
    }
      $outputMenu .= "</div><br />";
  }else{
      $outputMenu = "";
  }
  echo $outputMenu;
}

$ver = "4.1"; // current version of this script.  Don't change this variable.

function showHeader($ver)
{
/*
Displays the page header in the quote management tool
*/
      echo "<div class='header'>QuoteMe v".$ver."</div><br />";
}

function showFooter()
{
/*
Displays the page footer in the quote management tool
*/
      echo "<div class='footer'>&copy; Copyright ".date('Y')." <a href='http://www.clarksco.com'>Clark Consulting</a></div>";
}

function showError($theNum)
{
/*
Displays messages on the login screen
*/
      if ($theNum == 1){
            echo "<div style='color: red; font-weight: bold;'>You must login</div>";
      }elseif($theNum == 2){
            echo "<div style='color: red; font-weight: bold;'>You have been logged out</div>";
      }elseif($theNum == 3){
            echo "<div style='color: red; font-weight: bold;'>Login Failed</div>";
      }
}
?>
