<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

	<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; ארכיון <?php } ?> <?php wp_title(); ?></title>
	
	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->

	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
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


	<style type="text/css" media="screen">
	
	/* BEGIN IMAGE CSS */
	/*	כדי שהעיצוב יעבוד בלי קשר למיקום הקבצים של שאר המערכת, כל
		ההפניות לתמונות נעשות כאן, עם משתנים של פהפ. כדי לעבור 
		לעיצוב שמבוסס על צבעים בלבד, מספיק למחוק את (השורות הבאות 
		(למרות שלא יזיק גם למחוק את התמונות */
		
	body { background: url("<?php bloginfo('stylesheet_directory'); ?>/images/kubrickbgcolor.jpg"); }	
	<?php /* Checks to see whether it needs a sidebar or not */ if ((! $withcomments) && (! is_single())) { ?>
		#page { background: url("<?php bloginfo('stylesheet_directory'); ?>/images/kubrickbg.jpg") repeat-y top; border: none; }
	<?php } else { // No sidebar ?>
		#page { background: url("<?php bloginfo('stylesheet_directory'); ?>/images/kubrickbgwide.jpg") repeat-y top; border: none; } 
	<?php } ?>

	#header { background: url("<?php bloginfo('stylesheet_directory'); ?>/images/kubrickheader.jpg") no-repeat bottom center; }
	#footer { background: url("<?php bloginfo('stylesheet_directory'); ?>/images/kubrickfooter.jpg") no-repeat bottom; border: none;}

	/*	העיצוב משתנה קצת עם התמונות - הגודל וכו'. החלק
		.הזה מטפל בזה. אם אין תמונות, אפשר למחוק אותו */
		
	#header 	{ margin: 0 !important; margin: 0 1px 0 0; padding: 1px; height: 198px; width: 758px; }
	#headerimg 	{ margin: 7px 9px 0; height: 192px; width: 740px; } 

	/*	התמונה שמופיעה בכותרת היא
		/images/personalheader.jpg
		כדי להחליף את התמונה, צריך רק להחליף את 
		הקובץ, למשהו בגודל 760 על 200 פיקסלים
		.לפחות. כל דבר מעבר לזה יחתך ולא יוצג */
	/*
	#headerimg { background: url('<?php bloginfo('stylesheet_directory'); ?>/images/personalheader.jpg') no-repeat top;}
	*/

</style>

<?php wp_head(); ?>
</head>
<body>
<div id="page">


<div id="header">
	<div id="headerimg">
		<h1><a href="<?php echo get_settings('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
		<div class="description"><?php bloginfo('description'); ?></div>
	</div>
</div>
<hr />
