<?php get_header(); ?>

	<div id="content" class="widecolumn">
				
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
		<div class="navigation">
			<div class="alignright"><?php previous_post_link('&laquo; %link') ?></div>
			<div class="alignleft"><?php next_post_link('%link &raquo;') ?></div>
		</div>
	
		<div class="post" id="post-<?php the_ID(); ?>">
			<h2><a href="<?php echo get_permalink() ?>" rel="bookmark" title="‫קישור קבוע לפוסט &rsquo;<?php the_title(); ?>&lsquo;"><?php the_title(); ?></a></h2>
	
			<div class="entrytext">
				<?php the_content('<p class="serif">לקרוא את שאר הפוסט &raquo;</p>'); ?>
	
				<?php link_pages('<p><strong>עמודים:</strong> ', '</p>', 'number'); ?>
	
				<p class="postmetadata alt">
					<small>
						הפוסט הזה נכתב ביום <?php the_time('l, d בF Y') ?>,
						בשעה <?php the_time() ?>, 							
						והוא שייך לנושא <?php the_category(', ') ?>.
						
						את כל התגובות והטראקבאקים אפשר לקרוא ב-<?php comments_rss_link('RSS 2.0'); ?>&rlm;.

						<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Both Comments and Pings are open ?>
							אפשר <a href="#respond">להגיב על הפוסט</a> כאן בבלוג הזה, או לשלוח <a href="<?php trackback_url(display); ?>">טראקבאק</a> מבלוג אחר.&rlm;
						
						<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Only Pings are Open ?>
							אפשר לשלוח לפוסט הזה <a href="<?php trackback_url(display); ?> ">טראקבאק</a> מבלוג אחר.&rlm;
								
						<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Comments are open, Pings are not ?>
							אפשר <a href="#respond">להגיב על הפוסט הזה</a> כאן בתחתית העמוד.&rlm;
			
						<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Neither Comments, nor Pings are open ?>
							הפוסט הזה סגור לתגובות כרגע.&rlm;			
						
						<?php } edit_post_link('לערוך את הפוסט הזה.','',''); ?>
						
						
					</small>
				</p>
	
			</div>
		</div>
		
	<?php comments_template(); ?>
	
	<?php endwhile; else: ?>
	
		<p>לא מצאתי את מה שחיפשת.</p>
	
<?php endif; ?>
	
	</div>

<?php get_footer(); ?>
