<?php
define('WP_INSTALLING', true);

if (!file_exists('../wp-config-sample.php'))
    die("הקובץ 'wp-config-sample.php' לא נמצא. כדי ליצור קובץ הגדרות, צריך קודם להוריד מחדש את הקובץ wp-config-sample.pho מהקבצים המקוריים של ווררדפרס.
");
	/* WPH - properly wraped Hebrew error message */

if (file_exists('../wp-config.php')) 
	die("הקובץ 'wp-config.php' כבר קיים. כדי לשנות את ההגדרות שלו באמצעות הטופס הזה, צריך למחוק אותו קודם. יכול להיות שאפשר <a href='install.php'>להתחיל בהתקנה</a> כבר.
	");
	/* WPH - properly wraped Hebrew error message */ 

$configFile = file('../wp-config-sample.php');

if (!is_writable('../')) die("אין הרשאות כתיבה לתיקיה. צריך לשנות את הרשאות הכתיבה, או ליצור את קובץ ההגדרות ידנית.
");
/* WPH - properly wraped Hebrew error message */ 


if (isset($_GET['step']))
	$step = $_GET['step'];
else
	$step = 0;
header( 'Content-Type: text/html; charset=utf-8' );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>וורדפרס בעברית &rsaquo; יצירת קובץ הגדרות</title>
<?php /* WPH - Hebrew title */ ?> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style media="screen" type="text/css">
    <!--
	body {
		font-family: serif;
		/* WPH - font specificity */
		margin-left: 15%;
		margin-right: 15%;
	}
	
	.hebrew {
		unicode-bidi: embed;
		direction: rtl;
	}
	/* WPH - directionality */
	#logo {
		margin: 0;
		padding: 0;
		background-image: url(http://wordpress.org/images/logo.png);
		background-repeat: no-repeat;
		height: 60px;
		border-bottom: 4px solid #333;
	}
	#logo a {
		display: block;
		height: 60px;
	}
	#logo a span {
		display: none;
	}
	p, li {
		line-height: 140%;
	}
	input {
		unicode-bidi: embed;
		direction: ltr !important;
		text-align: left;
	}
	td {
		padding: 0 1.0em 3.0em;
	}
	td, th {
		vertical-align: top;
	}
	th {
		width: 8.0em;
	}
	tr td:last-child {
		font-size: 85%;
	}
	/* WPH - layout */
    -->
	</style>
</head>
<body>
	<div class="hebrew">
<h1 id="logo"><a href="www.trans.co.il/wp/"><span>וורדפרס בעברית</span></a></h1> 
<?php /* WPH - directionality, Hebrew titles */ ?> 
<?php

switch($step) {
	case 0:
?> 
<p>ברוכים הבאים לוורדפרס. לפני ההתקנה, אני צריכה קצת מידע על בסיס הנתונים. כדאי לברר את זה <em>לפני</em> שממשיכים.</p> 
<?php /* WPH - Unlocalized Hebrew texts */ ?> 
<ol> 
  <li>שם בסיס הנתונים</li> 
  <li>שם משתמש בבסיס הנתונים</li> 
  <li>הסיסמה של אותו משתמש</li> 
  <li>הכתובת (host) של בסיס הנתונים</li> 
  <li>קידומת לטבלאות (בשביל להפעיל כמה התקנות של וורדפרס מבסיס נתונים אחד) </li>
<?php /* WPH - Unlocalized Hebrew texts */ ?> 
</ol> 
<p><strong>אם אני לא אצליח ליצור את הקובץ - אין מה לדאוג. אפשר פשוט לפתוח את הקובץ  <code>wp-config-sample.php</code> בכל עורך טקסט, למלא את הנתונים לפי ההוראות, ולשמור אותו בשם <code>wp-config.php</code>. </strong></p>
<p>ברוב המקרים, מי שמארח את האתר שלך גם יתן לך את הפרטים האלה. אם עוד אין לך אותם - צריך לברר אותם, כאמור, לפני ההתקנה. אם הכל בסדר, <a href="setup-config.php?step=1">אפשר להמשיך</a>! </p>
<?php /* WPH - Unlocalized Hebrew texts */ ?> 
<?php
	break;

	case 1:
	?> 
</p> 
<form method="post" action="setup-config.php?step=2"> 
  <p>אלו הנתונים שאני צריכה:</p>
  <?php /* WPH - Unlocalized Hebrew texts */ ?> 
  <table> 
    <tr> 
      <th scope="row">1. שם בסיס הנתונים</th> 
	  <?php /* WPH - Unlocalized Hebrew texts */ ?> 
      <td><input name="dbname" type="text" size="45" value="wordpress" /></td> 
      <td>השם של בסיס הנתונים בו וורדפרס תשמור את הנתונים שלה.</td> 
      <?php /* WPH - Unlocalized Hebrew texts */ ?> 
    </tr> 
    <tr> 
      <th scope="row">2. שם משתמש בבסיס הנתונים</th> 
      <?php /* WPH - Unlocalized Hebrew texts */ ?> 
      <td><input name="uname" type="text" size="45" value="username" /></td> 
      <td>שם משתמש בבסיס נתונים עם הרשאות מלאות MySQL.</td> 
      <?php /* WPH - Unlocalized Hebrew texts */ ?> 
    </tr> 
    <tr> 
      <th scope="row">3. סיסמה</th> 
      <?php /* WPH - Unlocalized Hebrew texts */ ?> 
      <td><input name="pwd" type="text" size="45" value="password" /></td> 
      <td>הסיסמה של אותו משתמש.</td> 
      <?php /* WPH - Unlocalized Hebrew texts */ ?> 
    </tr> 
    <tr> 
      <th scope="row">4. הכתובת של בסיס הנתונים</th> 
      <?php /* WPH - Unlocalized Hebrew texts */ ?> 
      <td><input name="dbhost" type="text" size="45" value="localhost" /></td> 
      <td>ב-99% מהמקרים לא צריך לשנות את זה - אבל לפעמים כן (עם Dreamhost, למשל).</td> 
      <?php /* WPH - Unlocalized Hebrew texts */ ?> 
    </tr>
    <tr>
      <th scope="row">5. קידומת לטבלאות</th>
      <?php /* WPH - Unlocalized Hebrew texts */ ?> 
      <td><input name="prefix" type="text" id="prefix" value="wp_" size="45" /></td>
      <td>כדי להפעיל כמה התקנות של WP מבסיס נתונים אחד, אפשר להגדיר לכל התקנה קידומת טבלאות אחרת. לא צריך לשנות את זה אם זו ההתקנה היחידה.</td>
      <?php /* WPH - Unlocalized Hebrew texts */ ?> 
    </tr> 
  </table> 
  <input name="submit" type="submit" value="אישור" /> 
  <?php /* WPH - Unlocalized Hebrew texts */ ?> 
</form> 
<?php
	break;
	
	case 2:
	$dbname  = trim($_POST['dbname']);
    $uname   = trim($_POST['uname']);
    $passwrd = trim($_POST['pwd']);
    $dbhost  = trim($_POST['dbhost']);
	$prefix  = trim($_POST['prefix']);
	if (empty($prefix)) $prefix = 'wp_';

    // Test the db connection.
    define('DB_NAME', $dbname);
    define('DB_USER', $uname);
    define('DB_PASSWORD', $passwrd);
    define('DB_HOST', $dbhost);

    // We'll fail here if the values are no good.
    require_once('../wp-includes/wp-db.php');
	$handle = fopen('../wp-config.php', 'w');

    foreach ($configFile as $line_num => $line) {
        switch (substr($line,0,16)) {
            case "define('DB_NAME'":
                fwrite($handle, str_replace("wordpress", $dbname, $line));
                break;
            case "define('DB_USER'":
                fwrite($handle, str_replace("'username'", "'$uname'", $line));
                break;
            case "define('DB_PASSW":
                fwrite($handle, str_replace("'password'", "'$passwrd'", $line));
                break;
            case "define('DB_HOST'":
                fwrite($handle, str_replace("localhost", $dbhost, $line));
                break;
			case '$table_prefix  =':
				fwrite($handle, str_replace('wp_', $prefix, $line));
				break;
            default:
                fwrite($handle, $line);
        }
    }
    fclose($handle);
	chmod('../wp-config.php', 0666);
?> 
<p>זה הכל! סיימנו עם ההכנות, עכשיו אני יכולה להתחבר לבסיס הנתונים ולהתקין בו את וורדפרס. בזמנך החופשי, אפשר <a href="install.php">להתחיל בהתקנה!</a></p> 
<?php /* WPH - Unlocalized Hebrew texts */ ?> 
<?php
	break;

}
?> 
	</div>
	<?php /* WPH - directionality and layout */ ?> 
</body>
</html>
