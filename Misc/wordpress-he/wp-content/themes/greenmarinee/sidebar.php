
<!-- begin sidebar -->
<div id="sidebar">

	<ul>
	
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) { ?>
	

		<li id="the-pages">
			<h2>העמודים</h2>
				<ul>
					<?php wp_list_pages('title_li='); ?>
				</ul>
		</li>
			
		<li id="the-search">

			<h2>החיפוש</h2>
				<p class="searchinfo">חיפוש בארכיון האתר</p>
				<div id="search">
					<div id="search_area">
						<form id="searchform" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
							<input class="searchfield" type="text" name="s" id="s" value="" title="המילים לחיפוש" />
							<input class="submit" type="submit" name="submit" value="" title="חיפוש" />
						</form>
					</div>
				</div>
		</li>
			
		<li id="the-links">
			<h2>הקישורים</h2>
				<ul>
					<?php get_links('-1', '<li>', '</li>', '', 0, 'name', 0, 0, -1, 0); ?>
				</ul>
		</li>
				

		<li id="the-archives">
			<h2>המחסן</h2>
			<ul>
		 		<?php wp_get_archives('type=monthly'); ?>
 			</ul>
		</li>
 					
		<li id="the-categories">
			<h2>הנושאים</h2>
				<ul>
					<?php wp_list_cats(); ?>
				</ul>	
		</li>
		
		<li id="the-meta">
			<h2>המידע</h2>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<li><a href="http://www.trans.co.il/wp/" title="פועל על WordPress בעברית - מערכת כתיבה אישית">WordPress בעברית</a></li>
					<li><a href="<?php bloginfo('comments_rss2_url'); ?>" title="תגובות ב-RSS">תגובות ב-<abbr title="Really Simple Syndication">RSS</abbr>&rlm;</a></li>
					<li><a href="<?php bloginfo('rss2_url'); ?>" title="פוסטים ב-RSS">פוסטים ב-<abbr title="Really Simple Syndication">RSS</abbr>&rlm;</a></li>
					<?php wp_meta(); ?>
				</ul>
		</li>
				

	<?php } ?>
</div>

<!-- end sidebar -->
