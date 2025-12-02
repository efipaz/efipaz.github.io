<?php

if (! isset($wp_did_header)):
if ( !file_exists( dirname(__FILE__) . '/wp-config.php') ) {
	if ( strstr( $_SERVER['PHP_SELF'], 'wp-admin') ) $path = '';
	else $path = 'wp-admin/';
    die("לא מצאתי את הקובץ <code>wp-config.php</code>. אני צריכה את זה לפני שנתחיל. רוצה עוד עזרה? <a href='http://wordpress.org/docs/faq/#wp-config'>פה יש הרבה</a>. אפשר ליצור קובץ <code>wp-config.php</code> <a href='{$path}setup-config.php'> עם הטופס הזה</a>, אבל זה לא עובד בכל המקרים. הדרך הבטוחה ביותר היא ליצור את הקובץ ידנית.
");
    /* WPH - properly wraped Hebrew error message */
}

$wp_did_header = true;

require_once( dirname(__FILE__) . '/wp-config.php');

wp();
gzip_compression();

require_once(ABSPATH . WPINC . '/template-loader.php');

endif;

?>