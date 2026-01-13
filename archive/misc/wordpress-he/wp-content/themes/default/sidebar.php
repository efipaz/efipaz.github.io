	<div id="sidebar">
		<ul>

		
			<li>
			<?php /* If this is a 404 page */ if (is_404()) { ?>
			<?php /* If this is a category archive */ } elseif (is_category()) { ?>
			<p>אלו פוסטים מארכיון הנושא &rsquo;<?php single_cat_title(''); ?>&lsquo;.</p>
			
			<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
			<p>אלו פוסטים מהארכיון של הבלוג <a href="<?php bloginfo('home'); ?>/"><?php echo bloginfo('name'); ?></a> 
			מהיום <?php the_time('l, d בF, Y'); ?>.</p>
			
			<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
			<p>אלו פוסטים מהארכיון של הבלוג <a href="<?php bloginfo('home'); ?>/"><?php echo bloginfo('name'); ?></a>
			מהחודש <?php the_time('F, Y'); ?>.</p>

      <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
			אלו פוסטים מהארכיון של הבלוג <a href="<?php bloginfo('home'); ?>/"><?php echo bloginfo('name'); ?></a>
			מהשנה <?php the_time('Y'); ?>.</p>
			
		 <?php /* If this is a monthly archive */ } elseif (is_search()) { ?>
			<p>אלו תוצאות החיפוש <strong>&rdquo;<?php echo wp_specialchars($s); ?>&ldquo;</strong>
			בארכיון של הבלוג &rdquo;<a href="<?php echo bloginfo('home'); ?>/"><?php echo bloginfo('name'); ?></a>&ldquo;.
			אם לא הצלחת למצוא את מה שרצית, אולי אחד מהלינקים הבאים יעזרו לך יותר.</p>

			<?php /* If this is a monthly archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
			<p>אלו פוסטים מהארכיון של הבלוג <a href="<?php echo bloginfo('home'); ?>/"><?php echo bloginfo('name'); ?></a>.</p>

			<?php } ?>
			</li>

	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) { ?>


			<li>
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
				<?php wp_list_cats('sort_column=name&optioncount=1&hierarchical=0'); ?>
				</ul>
			</li>

			<?php /* If this is the frontpage */ if ( is_home() || is_page() ) { ?>				
				<?php get_links_list(); ?>
				
				<li><h2>כלים</h2>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<li><a href="<?php bloginfo('rss2_url'); ?>" title="שידור תכני האתר באמצעות RSS 2.0">פוסטים ב-<abbr title="Really Simple Syndication">RSS</abbr></a></li>
					<li><a href="<?php bloginfo('comments_rss2_url'); ?>" title="שידור התגובות באמצעות RSS 2.0">תגובות ב-<abbr title="Really Simple Syndication">RSS</abbr></a></li>
					<li><a href="http://www.trans.co.il/wp/" title="‬‫‫הבלוג הזה פועל על וורדפרס בעברית, מערכת בלוגים אישית.">וורדפרס בעברית</a></li>
					<?php wp_meta(); ?>
				</ul>
				</li>
			<?php } ?>

			<?php } ?>			
		</ul>
	</div>