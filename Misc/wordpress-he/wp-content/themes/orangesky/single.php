<?php get_header(); ?>

	<div id="content">
				
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
		<div class="navigation">
			<div class="alignright"><?php previous_post('&laquo; %','','yes') ?></div>
			<div class="alignleft"><?php next_post(' % &raquo;','','yes') ?></div>
		</div>
	
		<div class="post">
			<h2 class="postdate"><?php the_time('F j, Y') ?></h2>
			<h2 id="post-<?php the_ID(); ?>" class="posttitle"><a href="<?php echo get_permalink() ?>" rel="bookmark" title="קישור קבוע לפוסט: <?php the_title(); ?>"><?php the_title(); ?></a></h2>
	
			<div class="entry">
				<?php the_content('<p class="serif">המשך &raquo;</p>'); ?>
	
				<?php link_pages('<p><strong>עמודים:</strong> ', '</p>', 'number'); ?>
			</div>
	
				<p class="postmetadata">חתת הנושאים <?php the_category(', ') ?> | מאת <?php the_author() ?></p>
				
		</div>
					
				<ul class="commentdata">
					<li>
						<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Both Comments and Pings are open ?>
							אפשר <a href="#respond" title="לדלג לתחתית העמוד ולכתוב תגובה">לפרסם תגובה</a> באתר הזה, או 
							<a href="<?php trackback_url(display); ?>" title="הכתובת לשליחת טראקבאק">טראקבאק</a> מאתר אחר.
						
						<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Only Pings are Open ?>
							אי אפשר כרגע לפרסם תגובות, אבל אפשר לשלוח <a href="<?php trackback_url(display); ?> ">טראקבאק</a> מאתר אחר.

						<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Comments are open, Pings are not ?>
							אפשר לדלג לסוף העמוד בשביל <a href="#respond" title="skip to leave a comment">לכתוב תגובה</a>, אבל אי אפשר כרגע לשלוח טראקבאקים.

						<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Neither Comments, nor Pings are open ?>
							אי אפשר כרגע לפרסם תגובות או לשלוח טראקבאקים.			
						
						<?php } edit_post_link('(לערוך)','',''); ?>
					</li>
					<li>כתובת טראקבאק: <?php trackback_url(display); ?></li>
					<li><?php comments_rss_link('תגובות ב-RSS'); ?></li>
				</ul>
				<?php comments_template(); ?>
	
	<?php endwhile; else: ?>
	
		<p>לא מצאתי כאן שום דבר כזה.</p>
	
<?php endif; ?>
	
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>