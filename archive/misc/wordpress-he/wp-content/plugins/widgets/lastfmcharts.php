<?php
/*
Plugin Name: מצעדים מ-Last.fm
Description: ווידג'ט לבר הצדדי שמציג נתונים אודות המוזיקה לה האזנת בזמן האחרון, לפי last.fm.
Author: יוחנן שולפן, תרגום על ידי רן יניב הרטשטיין
Version: 1.5
Author URI: http://www.trans.co.il/wp
*/

function widget_jsCharts_init() {

	if ( !function_exists('register_sidebar_widget') )
		return;

	function widget_jsCharts($args) {
		
		extract($args);

		// Options
		$options = get_option('widget_jsCharts');
		$user = $options['user'];
		$title = $options['title'];
		$type = $options['type'];
		$style = $options['style'];

		// Sidebar Output
		echo $before_widget . $before_title . $title . $after_title;
		$url_parts = parse_url(get_bloginfo('home'));
		echo '<div style="margin-top:5px;text-align:center;"><a border="0" href="http://www.last.fm/user/'.$user.'/" target="_blank"><img src="http://imagegen.last.fm/'.$style.'/'.$type.'/'.$user.'.gif"></a></div>';
		echo $after_widget;
	}

	function widget_jsCharts_control() {

		$options = get_option('widget_jsCharts');
		if ( !is_array($options) )
			$options = array('title'=>'', 'type'=>'המצעד שלי מ-Last.fm');
		if ( $_POST['jsCharts-submit'] ) {

			$options['user'] = strip_tags(stripslashes($_POST['jsCharts-user']));
			$options['title'] = strip_tags(stripslashes($_POST['jsCharts-title']));
			$options['type'] = strip_tags(stripslashes($_POST['jsCharts-type']));
			$options['style'] = strip_tags(stripslashes($_POST['jsCharts-style']));
			update_option('widget_jsCharts', $options);
		}

		$user = htmlspecialchars($options['user'], ENT_QUOTES);
		$title = htmlspecialchars($options['title'], ENT_QUOTES);
		$type = htmlspecialchars($options['type'], ENT_QUOTES);
		$type = htmlspecialchars($options['style'], ENT_QUOTES);
		
		// Widget control form
		echo '<p style="text-align:right;"><label for="jsCharts-user">שם משתמש: <input style="width: 200px;" id="jsCharts-user" name="jsCharts-user" type="text" value="'.$user.'" /></label></p>';
		echo '<p style="text-align:right;"><label for="jsCharts-title">כותרת: <input style="width: 200px;" id="jsCharts-title" name="jsCharts-title" type="text" value="'.$title.'" /></label></p>';
		echo '<p style="text-align:right;"><label for="jsCharts-type">סוג המצעד: <select style="width: 200px; id="jsCharts-title" name="jsCharts-type" size="1"><option value="recenttracks">שירים אחרונים</option><option value="artists">אמנים להם האזנתי בשבוע האחרון</option><option value="track">שירים להם האזנתי בשבוע האחרון</option><option value="oartists">אמנים אהובים</option><option value="otracks">שירים אהובים</option></select></label></p>';
		echo '<p style="text-align:right;"><label for="jsCharts-style">סגנון תצוגה: <select style="width: 200px; id="jsCharts-style" name="jsCharts-style" size="1"><option value="greybox">Greybox</option><option value="minimalLight">Minimal Light</option><option value="asimpleblue5">A Simple Blue 5</option></select></label></p>';
		echo '<input type="hidden" id="jsCharts-submit" name="jsCharts-submit" value="1" />';
	}
	
	register_sidebar_widget('מצעדים מ-Last.fm', 'widget_jsCharts');

	// Widget control form, size is 300*150px.
	register_widget_control('מצעדים מ-Last.fm', 'widget_jsCharts_control', 300, 150);
}

add_action('plugins_loaded', 'widget_jsCharts_init');

?>