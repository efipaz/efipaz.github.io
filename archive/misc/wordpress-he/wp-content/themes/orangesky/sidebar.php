</div>

<div id="sidebar">

		<ul>
			
			<?php /* If this is a 404 page */ if (is_404()) { ?>
			<?php /* If this is a category archive */ } elseif (is_category()) { ?>
			<li><h2>ארכיון</h2><p>אלו פוסטים מארכיון הנושא &rsquo;<?php single_cat_title(''); ?>&lsquo;.</p></li>
			
			<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
			<li><h2>ארכיון</h2><p>אלו פוסטים מהארכיון של הבלוג &rdquo;<a href="<?php bloginfo('home'); ?>/"><?php echo bloginfo('name'); ?></a>&ldquo; מהיום <?php the_time('l, d בF, Y'); ?>.</p></li>
			
			<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
			<li><h2>ארכיון</h2><p>אלו פוסטים מהארכיון של הבלוג &rdquo;<a href="<?php bloginfo('home'); ?>/"><?php echo bloginfo('name'); ?></a>&ldquo; מהחודש <?php the_time('F, Y'); ?>.</p></li>

			<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
			<li><h2>ארכיון</h2><p>אלו פוסטים מהארכיון של הבלוג &rdquo;<a href="<?php bloginfo('home'); ?>/"><?php echo bloginfo('name'); ?></a>&ldquo; מהשנה <?php the_time('Y'); ?>.</p></li>
			
			<?php /* If this is a monthly archive */ } elseif (is_search()) { ?>
			<li><h2>ארכיון</h2><p>אלו תוצאות החיפוש <strong>&rdquo;<?php echo wp_specialchars($s); ?>&ldquo;</strong> בארכיון של הבלוג &rdquo;<a href="<?php echo bloginfo('home'); ?>/"><?php echo bloginfo('name'); ?></a>&ldquo;. אם לא הצלחת למצוא את מה שרצית, אולי אחד מהלינקים הבאים יעזרו לך יותר.</p></li>

			<?php /* If this is a monthly archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
			<li><h2>ארכיון</h2><p>אלו פוסטים מהארכיון של הבלוג &rdquo;<a href="<?php echo bloginfo('home'); ?>/"><?php echo bloginfo('name'); ?></a>&ldquo;.</p></li>

			<?php } ?>

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) { ?>
			
			<li>
				<h2>חיפוש</h2>
				<?php include (TEMPLATEPATH . '/searchform.php'); ?>
			</li>
					

			<?php wp_list_pages('title_li=<h2>עמודים</h2>' ); ?>

			<li><h2>ארכיון</h2>
				<ul>
				<?php wp_get_archives('type=monthly'); ?>
				</ul>
			</li>

			<li><h2>נושאים</h2>
				<ul>
				<?php list_cats(0, '', 'name', 'asc', '', 1, 0, 1, 1, 1, 1, 0,'','','','','') ?>
				</ul>
			</li>

			<?php /* If this is the front page */ if ( is_home() || is_page() ) { ?>
				<?php get_links_list(); ?>

				<?php if (function_exists('wp_theme_switcher')) { ?>
				<li><h2>עיצובים</h2>
				<?php wp_theme_switcher(); ?>
				</li>
				<?php } ?>
				
				<li><h2>כלים</h2>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<li><a href="<?php bloginfo('comments_rss2_url'); ?>" title="תגובות ב-RSS">תגובות ב-<abbr title="Really Simple Syndication">RSS</abbr>&rlm;</a></li>
				<li><a href="<?php bloginfo('rss2_url'); ?>" title="פוסטים ב-RSS">פוסטים ב-<abbr title="Really Simple Syndication">RSS</abbr>&rlm;</a></li>
					<li><a href="http://www.trans.co.il/wp/" title="פועל על WordPress בעברית, מערכת כתיבה אישית">WordPress בעברית</a></li>
					<?php wp_meta(); ?>
				</ul>
				</li>
			<?php } ?>
			
		<?php } ?>
			
		</ul>
	</div>

