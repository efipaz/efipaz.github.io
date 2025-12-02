<?php
include_once 'tools.php';
if (!isset ($_SESSION))
{
	session_start();
}
$mail_content = "";
if(isset($_REQUEST['content']))
{
	$mail_content = $_REQUEST['content'];
}
$email = "";
if(isset($_REQUEST['email']))
{
	$email = $_REQUEST['email'];
}
$name = "";
if(isset($_REQUEST['name']))
{
	$name = $_REQUEST['name'];
}
$phone = "";
if(isset($_REQUEST['phone']))
{
	$phone = $_REQUEST['phone'];
}
$country = "";
if(isset($_REQUEST['country']))
{
	$country = $_REQUEST['country'];
}
if($mail_content == "" || $email == "" || $name == "" || $phone == "" || $country == "")
{
	echo "
		<p>some data is missing to finish the checkout operation. go back to <a href='checkout.php'>checkout</a></p>
	";
}
else
{
	$details = "Hi Efi,\r\n my name is ".$name." and I would like to order the following photos:\r\n";
	$details = $details.$mail_content;
	$details = $details."\r\n\r\nMy additonal information is:\r\n";
	$details = $details."E-mail: ".$email."\r\n";
	$details = $details."Phone: ".$phone."\r\n";
	$details = $details."Country: ".$country."\r\n";
	$details = $details."Thank you,\r\n ".$name;
	$details_client = "This mail confirms that you order photos by e-mail in Light Of India belongs to efipaz.com\r\n";
	$details_client = $details_client."Note: do not reply to this email. My e-mail for any question is efipaz@gmail.com\r\n";
	$details_client = $details_client."This is a copy of the mail sent to me:\r\n\r\n";
	$details_client = $details_client."---------------------------------------------------------------\r\n";
	$details_client = $details_client.$details;
	$details_client = $details_client."\r\n---------------------------------------------------------------\r\n\r\n";
	$details_client = $details_client."Thank you for ordering,\r\n";
	$details_client = $details_client."Efi Paz\r\n";
	$details_client = $details_client."efipaz.com";
	//mail to Efi
	mail_it($details, "Order photos at Light Of India", "LightOfIndia@efipaz.com", "amitfrid@gmail.com");
	//mail to client
	mail_it($details_client, "Confirmation mail: order photos at Light Of India", "LightOfIndia@efipaz.com", $email);
	//clean cookie
	setcookie('cartitems', '', time() - 1);
	$URL = "thankYouMail.php?name=".$name;
	header ("Location: $URL");
}
function mail_it($content, $subject, $from, $recipient) {
       mail($recipient, $subject, $content, "From: ".$from."\r\nX-Mailer: PHP/".phpversion());
}
?>