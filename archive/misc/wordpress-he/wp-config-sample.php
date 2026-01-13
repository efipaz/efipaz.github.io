<?php
// ** MySQL settings ** //
define('DB_NAME', 'wordpress');		// שם בסיס הנתונים (Name of the database)
define('DB_USER', 'username');		// שם משתמש עם הרשאות מלאות בבסיס הנתונים (Username on database)
define('DB_PASSWORD', 'password');	// ...והסיסמה שלו (Username's password)
define('DB_HOST', 'localhost');		// ברוב המקרים לא צריך לשנות את זה (Database host - usualy you don't need to change this)

// כדי להפעיל כמה התקנות של וורדפרס מבסיס נתונים אחד, אפשר להגדיר
// לכל התקנה קידומת טבלאות אחרת. לא צריך לשנות את זה אם זו ההתקנה היחידה.
// רק מספרים, אותיות, או קווים תחתונים בבקשה!
// Prefix added to tables, for installing multiple blogs on same database.
// Only numbers (0-9), letters (a-z) or underscores (_) please!
$table_prefix  = 'wp_';

// השורה הבאה בוחרת את שפת הממשק של וורדפרס. במקרה זה, היא 
// מפעילה את התרגום לעברית. יש לציין שחלקים רבים מוורדפרס 
// לא עוברים דרך הקובץ הזה, וישארו בעברית (או באנגלית) גם אם יבחר קובץ אחר.
// WordPress localization file, for changing the interface language. 
define ('WPLANG', 'he_IL');

// לא כדאי לשנות את כל השאר
// Don't change anything after this

define('ABSPATH', dirname(__FILE__).'/');
require_once(ABSPATH.'wp-settings.php');
?>