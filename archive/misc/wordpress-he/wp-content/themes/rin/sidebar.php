<div id="sidebar">

<ul>

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) { ?>

	<li><h2>אודות</h2>
		<ul>
			<li class="blog-description"><p><?php bloginfo('description'); ?></p></li>
		</ul>
	</li>
	
	<?php wp_list_pages('title_li=<h2>עמודים</h2>' ); ?>
	
	<li><h2>נושאים</h2>
		<ul>
			<?php list_cats() ?>
		</ul>
	</li>
	
	<li><h2>קישורים</h2>
		<ul>
			<?php get_links('-1', '<li>', '</li>', '<br />'); ?>
		</ul>
	</li>
	
	<li><h2>כלים</h2>
		<ul>
			<?php wp_register(); ?>
			<li><?php wp_loginout(); ?></li>
			<li><a href="<?php bloginfo('comments_rss2_url'); ?>" title="תגובות ב-RSS">תגובות ב-<abbr title="Really Simple Syndication">RSS</abbr>&rlm;</a></li>
			<li><a href="<?php bloginfo('rss2_url'); ?>" title="פוסטים ב-RSS">פוסטים ב-<abbr title="Really Simple Syndication">RSS</abbr>&rlm;</a></li>
			<li><a href="http://validator.w3.org/check/referer" title="עמוד זה תואם לתקן XHTML 1.0 Transitional"><abbr title="eXtensible HyperText Markup Language">XHTML</abbr> תקני</a></li>
			<li><a href="http://www.trans.co.il/wp/" title="‬‫‫הבלוג הזה פועל על וורדפרס בעברית, מערכת בלוגים אישית.">וורדפרס בעברית</a></li>
			<?php wp_meta(); ?>
		</ul>
	</li>

<?php } ?>

 </ul>
</div>


