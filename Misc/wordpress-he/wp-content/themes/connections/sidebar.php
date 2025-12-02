<ul>
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) { ?>

	<?php if(is_home()) { ?>
	<li id="about">
		<h2>אודות האתר</h2>
		<ul>
			<li><?php bloginfo('description'); ?></li>
		</ul>
	</li>
	<?php } ?>
	
	<li id="pages">
		<h2>עמודים</h2>
		<ul>
			<?php wp_list_pages('sort_column=menu_order&depth=1&title_li=');    ?>
		</ul>
	</li>

	<li id="categories">
		<h2>נושאים</h2>
		<ul>
			<?php wp_list_cats('sort_column=name&optioncount=1');    ?>
		</ul>
	</li>
	
	<li id="search">
		<h2><label for="s">חיפוש בבלוג</label></h2>
			<form class="non-widget" id="searchform" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<div style="text-align:center">
					<p><input type="text" name="s" id="s" size="15" /></p>
					<p><input type="submit" name="submit" value="חיפוש" /></p>
				</div>
			</form>
	</li>
	
	<?php if(is_home()) { ?>
	
	<li id="links">
		<h2>קישורים</h2>
		<ul>
		<?php
			if ($wpdb->get_results("SELECT cat_id, cat_name FROM $wpdb->linkcategories")) {
				foreach ($wpdb->get_results("SELECT cat_id, cat_name FROM $wpdb->linkcategories") as $cat) {
					// Handle each category.
						// Display the category name
						echo '	<li id="linkcat-' . $cat->cat_id . '"><h3>' . $cat->cat_name . "</h3>\n\t<ul>\n";
						// Call get_links() with all the appropriate params
						get_links($cat->cat_id,'<li>',"</li>","\n", TRUE, 'name', FALSE, FALSE, -1, FALSE);
					// Close the last category
					echo "\n\t</ul>\n</li>\n";
				}
			}
		?>
		</ul>
	</li>
	
	<?php } ?>
	
	<li id="meta">
		<h2>כלים</h2>
		<ul>
			<?php wp_register(); ?>
			<li><?php wp_loginout(); ?></li>
			<li><a href="<?php bloginfo('rss2_url'); ?>" title="שידור תכני האתר באמצעות RSS 2.0">פוסטים ב-<abbr title="Really Simple Syndication">RSS</abbr></a></li>
			<li><a href="<?php bloginfo('comments_rss2_url'); ?>" title="שידור התגובות באמצעות RSS 2.0">תגובות ב-<abbr title="Really Simple Syndication">RSS</abbr></a></li>
			<li><a href="http://www.trans.co.il/wp/" title="‬‫‫הבלוג הזה פועל על וורדפרס בעברית, מערכת בלוגים אישית.">וורדפרס בעברית</a></li>
			<?php wp_meta(); ?>
			
		</ul>		
	</li>

	<?php if (function_exists('wp_theme_switcher')) { ?>
	<li id="theme-switcher">
		<h2><?php _e('Themes:'); ?></h2>
		<?php wp_theme_switcher(); ?>
	</li>
	<?php } ?>
	
<?php } ?>
</ul>