<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/1">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<title>
		<?php if ( is_404() )
			echo 'שגיאה 404 - לא מצאתי';
		elseif ( is_search() )
		{
			echo 'תוצאות החיפוש &#8220;'.$s.'&#8221; &raquo; ';
		}
		else
			wp_title(' ');
		
		if(wp_title(' ', false)) echo ' &raquo; ';
		bloginfo('name'); ?>
	</title>

	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats please -->

	<style type="text/css" media="screen">@import url( <?php bloginfo('stylesheet_url'); ?> );</style>	
	
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
		
	<link rel="index" href="<?php bloginfo(’url’); ?>" />

	<?php 
	
		/* meta links */
	if(!is_home()) { 
	        echo '<link rel="start" href="' . get_bloginfo('siteurl') . '" title="Home" />' . "\n"; 
	    } 

	    $firstpost = @$wpdb->get_row("SELECT ID, post_title FROM $wpdb->posts WHERE post_status = 'publish' ORDER BY post_date ASC LIMIT 1"); 
	    if($firstpost) { 
	        $first_title = strip_tags(str_replace('"', '', $firstpost->post_title)); 
	        echo '<link rel="first" href="' . get_permalink($firstpost->ID) . '" title="' . $first_title. '" />' . "\n"; 
	    } 

	    $lastpost = @$wpdb->get_row("SELECT ID, post_title FROM $wpdb->posts WHERE post_status = 'publish' ORDER BY post_date DESC LIMIT 1"); 
	    if($lastpost) { 
	        $last_title = strip_tags(str_replace('"', '', $lastpost->post_title)); 
	        echo '<link rel="last" href="' . get_permalink($lastpost->ID) . '" title="' . $last_title. '" />' . "\n"; 
	    }
	
	    if(is_single()) { 
	        global $wpdb, $wp_query; 
	        $post = $wp_query->post; 

	        $wpdb->hide_errors(); // hide errors on invalid post queries 

	        $prev_post = get_previous_post(); 
	        if($prev_post) { 
	            $prev_title = strip_tags(str_replace('"', '', $prev_post->post_title)); 
	            echo '<link rel="prev" href="' . get_permalink($prev_post->ID) . '" title="' . $prev_title. '" />' . "\n"; 
	        } 

	        $next_post = get_next_post(); 
	        if($next_post) { 
	            $next_title = strip_tags(str_replace('"', '', $next_post->post_title)); 
	            echo '<link rel="next" href="' . get_permalink($next_post->ID) . '" title="' . $next_title. '" />' . "\n"; 
	        } 

	        $wpdb->show_errors(); // turn errors back on 

	    } 
	
	?>


	<?php wp_get_archives('type=monthly&format=link'); ?>

	<?php wp_head(); ?>
</head>

<body>
<div id="rap">
<div id="header">
	<ul id="topnav">
		<li><a href="/contact/" id="navContact" title="יצירת קשר" accesskey="c">קשר</a></li> |
		<li><a href="/archives/" id="navArchives" title="ארכיון הבלוג" accesskey="r">ארכיון</a> | </li>
		<li><a href="/about/" id="navAbout" title="אודות הבלוג" accesskey="a">אודות</a> | </li>
		<li><a href="<?php bloginfo('url'); ?>" id="navHome" title="העמוד הראשי - 'פוסטים אחרונים" accesskey="h">ראשי</a></li>
	</ul>
	<h1><a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></h1>		
	<div id="desc"><?php bloginfo('description');?></div>
</div>
