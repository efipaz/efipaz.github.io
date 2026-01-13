<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
<head profile="http://gmpg.org/xfn/1">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; ארכיון <?php } ?> <?php wp_title(); ?></title>
<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->

<link rel="stylesheet" type="text/css" media="print" href="<?php echo get_settings('siteurl'); ?>/print.css" />

<style type="text/css" media="screen">
@import url( <?php bloginfo('stylesheet_url'); ?> );
</style>

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

<div id="container">

<div id="header">
<h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
</div>

<?php get_sidebar(); ?>

<hr />

<div id="content">

<?php if ($posts) : foreach ($posts as $post) : start_wp(); ?>

<div class="date"><?php the_date(); ?></div>

<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="קישור קבוע לפוסט: <?php the_title(); ?>"><?php the_title(); ?></a></h2>

<div class="meta">תחת הנושאים <?php the_category(',') ?> &#8212; <?php the_author() ?> בשעה <?php the_time() ?> <?php edit_post_link('(לערוך)'); ?></div>

<div class="storycontent">
<?php the_content('(המשך...)'); ?>
</div> 

<div class="feedback">
<?php wp_link_pages(); ?>
<?php comments_popup_link('אין תגובות',  'תגובה אחת', '% תגובות'); ?>
</div>

	<!--
	<?php trackback_rdf(); ?>
	-->
	
<?php comments_template(); ?>

<?php endforeach; else: ?>
<p>לא מצאתי שום דבר כזה.</p>
<?php endif; ?>

<div class="navigation">
				<div class="alignright"><?php next_posts_link('&laquo; פוסטים ישנים יותר') ?></div>
				<div class="alignleft"><?php previous_posts_link('פוסטים חדשים יותר &raquo;') ?></div>
</div>

<div id="footer"><br />עיצוב על ידי <a href="http://www.vlad-design.de">ולאדימיר סימוביק</a> והתאמה לעברית על ידי <a href="http://www.trans.co.il/">רן יניב הרטשטיין</a><br />
אתר זה פועל על <a href="http://www.trans.co.il/wp">וורדפרס בעברית</a></div>

</div>

</div>

</body>
</html>