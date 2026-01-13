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
<?php wp_get_archives('type=monthly&format=link'); ?>
<?php //comments_popup_script(); // off by default ?>
<?php wp_head(); ?>
</head>
<body>

<div id="container">

<div id="header">
<h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
</div>

<div id="navi">
<div id="sidebar">

<h2>ראשי</h2>
<ul>
<li><a href="<?php bloginfo('url'); ?>">עמוד ראשי</a></li>
<?php wp_list_pages('sort_column=menu_order&title_li='); ?>
</ul>

<h2>נושאים</h2>
<ul>
<?php wp_list_cats('sort_column=name&optioncount=1'); ?>
</ul>

<h2>ארכיון</h2>
<ul>
<?php wp_get_archives('type=monthly&show_post_count=1'); ?>
</ul>

<h2><label for="s">חיפוש</label></h2>	
<form id="searchform" method="get" action="<?php echo $PHP_SELF; ?>">
<div>
<input type="text" name="s" id="s" size="17" class="navi-search" /><br />
<input type="submit" name="submit" value="חיפוש" class="search-button" />
</div>
</form>

<h2>קישורים</h2>
<ul>
<?php wp_get_links(1); ?>
</ul>

<h2>כלים</h2>
<ul>
<?php wp_register(); ?>
<li><?php wp_loginout(); ?></li>

<li><a href="<?php bloginfo('comments_rss2_url'); ?>" title="תגובות ב-RSS">תגובות <abbr title="Really Simple Syndication">RSS</abbr>&rlm;</a></li>

<li><a href="<?php bloginfo('rss2_url'); ?>" title="פוסטים ב-RSS">פוסטים <abbr title="Really Simple Syndication">RSS</abbr>&rlm;</a></li>

<li><a href="http://validator.w3.org/check/referer" title="עמוד זה תואם לתקן XHTML 1.0 Transitional"><abbr title="eXtensible HyperText Markup Language">XHTML</abbr> תקני</a></li>

<li><a href="http://gmpg.org/xfn/"><abbr title="XHTML Friends Network">XFN</abbr></a></li>

<li><a href="http://www.trans.co.il/wp/" title="פועל על WordPress בעברית, מערכת כתיבה אישית">WordPress בעברית</a></li>
<?php wp_meta(); ?>
</ul>

<?php if (function_exists('wp_theme_switcher')) { ?>
<h2>עיצובים</h2> 
<?php wp_theme_switcher(); ?>
<?php } ?>
</div>
</div>

<hr />

<div id="content">

<?php if ($posts) : foreach ($posts as $post) : start_wp(); ?>

<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="קישור קבוע לפוסט: <?php the_title(); ?>"><?php the_title(); ?></a></h2>

<div class="storycontent">
<?php the_content(__('(עוד...)')); ?> <?php edit_post_link('(לערוך)'); ?>
</div> 

	<!--
	<?php trackback_rdf(); ?>
	-->
	

<?php endforeach; else: ?>
<p>לא מצאתי שום דבר כזה.</p>
<?php endif; ?>

<div class="center">
				<div class="alignright"><?php next_posts_link('&laquo; פוסטים ישנים יותר') ?></div>
				<div class="alignleft"><?php previous_posts_link('פוסטים חדשים יותר &raquo;') ?></div>
</div>

<div id="footer"><br />עיצוב על ידי <a href="http://www.vlad-design.de">ולאדימיר סימוביק</a> והתאמה לעברית על ידי <a href="http://www.trans.co.il/">רן יניב הרטשטיין</a><br />
אתר זה פועל על <a href="http://www.trans.co.il/wp">וורדפרס בעברית</a></div>

</div>

</div>

</body>
</html>