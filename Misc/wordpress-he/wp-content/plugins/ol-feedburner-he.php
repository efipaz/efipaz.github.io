<?php
/*
Plugin Name: Feedburner
Plugin URI: http://www.orderedlist.com/articles/wordpress_feedburner_plugin/
Description: מעביר את כל הפידים אל Feedburner, בלי שהקוראים יצטרכו לשנות את הכתובת או להרשם מחדש.
Author: סטיב סמית', תרגום על ידי רן יניב הרטשטיין
Author URI: http://www.orderedlist.com/
Version: 2.02
*/ 

$data = array(	
								'redirect' => false,
								'feedburner_url' => '',
								'random_source_url' => 'feedburner_' . rand(111111,999999)
						);
								
add_option('feedburner_settings',$data,'אפשרויות Feedburner');

$feedburner_settings = get_option('feedburner_settings');

if ($feedburner_settings['step1']) {
	add_filter('mod_rewrite_rules','add_feedburner_feed');
}

if ($feedburner_settings['step2']) {
	add_filter('mod_rewrite_rules','add_feedburner_redirect');
}

function ol_add_feedburner_options_page() {
	if (function_exists('add_options_page')) {
		add_options_page('FeedBurner', 'FeedBurner', 8, basename(__FILE__), 'ol_feedburner_options_subpanel');
	}
}

function add_feedburner_feed($rules) {
	global $feedburner_settings;
	$home_root = parse_url(get_settings('home'));
	$home_root = trailingslashit($home_root['path']);
	$new_rules = '# Redirect FeedBurner to your own Feed' . "\n";
	$new_rules .= 'RewriteBase ' . $home_root . "\n";
	$new_rules .= 'RewriteRule ^' . $feedburner_settings['random_source_url'] . '/?$' . ' ' . $home_root . 'feed/ [R,L]' . "\n";
	$new_rules .= 'RewriteCond %{HTTP_USER_AGENT} ^FeedBurner.*$' . "\n";
	$new_rules .= 'RewriteCond %{REQUEST_FILENAME} !-f' . "\n";
	$new_rules .= 'RewriteCond %{REQUEST_FILENAME} !-d' . "\n";
	$new_rules .= 'RewriteRule . ' . $home_root . 'index.php [L]' . "\n";
	$new_rules .= '# Feed Redirect Rules will go here';
	$rules = str_replace('RewriteBase ' . $home_root, $new_rules, $rules);
	return $rules;
}

function add_feedburner_redirect($rules) {
	global $feedburner_settings;
	$home_root = parse_url(get_settings('home'));
	$home_root = trailingslashit($home_root['path']);
	$new_rules = '# These Rules redirect all feed Traffic to FeedBurner' . "\n";
	$new_rules .= 'RewriteBase ' . $home_root . "\n";
	$new_rules .= 'RewriteCond %{QUERY_STRING} ^feed=(feed|rdf|rss|rss2|atom)$' . "\n";
	$new_rules .= 'RewriteRule ^(.*)$ ' . $feedburner_settings['feedburner_url'] . ' [R,L]' . "\n";
	$new_rules .= 'RewriteRule ^(feed|rdf|rss|rss2|atom)/?(feed|rdf|rss|rss2|atom)?/?$ ' . $feedburner_settings['feedburner_url'] . ' [R,L]' . "\n";
	$new_rules .= 'RewriteRule ^wp-(feed|rdf|rss|rss2|atom).php ' . $feedburner_settings['feedburner_url'] . ' [R,L]' . "\n";
	$new_rules .= '# These are the standard WordPress Rules';
	$rules = str_replace('# Feed Redirect Rules will go here', $new_rules, $rules);
	return $rules;
}

function ol_feedburner_options_subpanel() {
	global $feedburner_settings, $_POST, $wp_rewrite;
	?>
	<div class="wrap">
	<?php
	
		if ($_POST['feedburner_url'] != '') { 
			$feedburner_settings['feedburner_url'] = $_POST['feedburner_url'];
			$feedburner_settings['step2'] = 1;
			update_option('feedburner_settings',$feedburner_settings);
		} elseif ($_POST['complete'] == 'true') {
			$feedburner_settings['complete'] = 1;
			update_option('feedburner_settings',$feedburner_settings);
		}
			
	
	  if ($_POST['deactivate'] == 'true') {
			$feedburner_settings['step1'] = 0;
			$feedburner_settings['step2'] = 0;
			$feedburner_settings['complete'] = 0;
			update_option('feedburner_settings',$feedburner_settings);
			
			remove_filter('mod_rewrite_rules','add_feedburner_redirect');
			remove_filter('mod_rewrite_rules','add_feedburner_feed');
			
			$home_path = get_home_path();

			generate_page_rewrite_rules();

			if ( (!file_exists($home_path.'.htaccess') && is_writable($home_path)) || is_writable($home_path.'.htaccess') )
				$writable = true;
			else
				$writable = false;
			
			save_mod_rewrite_rules();
			
			echo '<h2>להפסיק את ההעברה ל-FeedBurner</h2><p>';
			if ($writable)
				echo ('מבנה הקישורים עודכן. ההעברה ל-FeedBurner הופסקה.');
			else {
				echo ('צריך לעדכן את הקובץ <bdo dir="ltr">.htaccess</bdo> עם השורות הבאות:'); 
				echo '<textarea rows="5" style="width: 98%;" name="rules">' . $wp_rewrite->mod_rewrite_rules() . '</textarea>';
			}
			echo '</p>';
			
		} elseif ($feedburner_settings['complete'] == 1) {
			echo '<h2>ההעברה ל-FeedBurner פעילה</h2><p>הפידים שלך מועברים ל-FeedBurner מהכתובת <strong>' . $feedburner_settings['feedburner_url'] . '</strong>.</p>';
			echo '<p><form action="" method="post"><input type="hidden" name="deactivate" value="true" /><input type="submit" value="להפסיק את ההעברה ל-Feedburner" /></form></p>';
			
		} elseif ($feedburner_settings['step1'] == 0 || (!$_POST['redirect'] && $feedburner_settings['step2'] == 0)) {
			$feedburner_settings['step1'] = 1;
			update_option('feedburner_settings',$feedburner_settings);
			add_filter('mod_rewrite_rules','add_feedburner_feed');
			
			$home_path = get_home_path();

			generate_page_rewrite_rules();

			if ( (!file_exists($home_path.'.htaccess') && is_writable($home_path)) || is_writable($home_path.'.htaccess') )
				$writable = true;
			else
				$writable = false;
			
			save_mod_rewrite_rules();
			
			echo '<h2>שלב 1: עדכון מבנה הקישורים הקבועים ל-Feedburner.</h2><p>';
			if ($writable)
				echo ('מבנה הקישורים הקבועים עודכן.');
			else {
				echo ('צריך לעדכן את הקובץ <bdo dir="ltr">.htaccess</bdo> עם השורות הבאות:');
				echo '<textarea rows="5" style="width: 98%;" name="rules">' . $wp_rewrite->mod_rewrite_rules() . '</textarea>';
			}
			echo '</p>';
			echo '<h2>שלב 2: עדכון כתובת הפיד ב-FeedBurner</h2>';
			echo '<p>אם עוד לא עשית את זה, עכשיו זה הזמן <a href="http://www.feedburner.com/">לפתוח חשבון ב-Feedburner</a>. זו הכתובת אליה יש להפנות את Feedbuner כמקור הפיד:</p><p><strong dir="ltr">' . get_option('siteurl') . '/' . $feedburner_settings['random_source_url'] . '/</strong></p>
			<p>אחרי הגדרת החשבון ב-FeedBurner, צריך להדביק כאן את הכתובת של הפיד החדש שיצרת ב-Feedburner (למשל, <bdo dir="ltr">http://feeds.feedburner.com/myaccount/</bdo>) 
			וללחוץ על הכפתור כדי להתחיל להעביר את כל הפידים שלך ל-Feedburner.</p>
			<p><form action="" method="post"><input type="hidden" name="redirect" value="true" />כתובת הפיד ב-Feedburner: <input type="text" name="feedburner_url" value="' . htmlentities($feedburner_settings['feedburner_url']) . '" size="45" /></p><p><input type="submit" value="סיימתי להגדיר את החשבון ב-Feedburner. אפשר להתחיל להעביר את הפידים" /></form></p>';
		} elseif ($feedburner_settings['step2'] == 1) {
			add_filter('mod_rewrite_rules','add_feedburner_redirect');
			
			$home_path = get_home_path();

			generate_page_rewrite_rules();

			if ( (!file_exists($home_path.'.htaccess') && is_writable($home_path)) || is_writable($home_path.'.htaccess') )
				$writable = true;
			else
				$writable = false;
			
			save_mod_rewrite_rules();
			
			echo '<h2>שלב 3: עדכון מבנה הקישורים להעברה ל-Feedburner</h2><p>';
			if ($writable) {
				$feedburner_settings['complete'] = 1;
				update_option('feedburner_settings',$feedburner_settings);
				echo 'מבנה הקישורים עודכן.  מעכשיו, כל הפידים שלך יעברו דרך Feedburner! <a href="' . get_option('siteurl') . '/feed/">וידוא העברת הפידים</a>.';
			 } else {
				echo ('צריך לעדכן את הקובץ <bdo dir="ltr">.htaccess</bdo> עם השורות הבאות:');
				echo '<textarea rows="5" style="width: 98%;" name="rules">' . $wp_rewrite->mod_rewrite_rules() . '</textarea>';
				echo '</p><p><form action="" method="post"><input type="hidden" name="complete" value="true" /><input type="submit" value="עדכנתי את הקובף" /></form>';
			}
			echo '</p>';
		}

}



add_action('admin_menu', 'ol_add_feedburner_options_page');

?>