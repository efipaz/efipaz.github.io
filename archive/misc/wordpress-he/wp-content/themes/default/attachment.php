<?php get_header(); ?>

	<div id="content" class="widecolumn">
				
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
		<div class="navigation">
			<div class="alignleft">&nbsp;</div>
			<div class="alignright">&nbsp;</div>
		</div>
<?php $attachment_link = get_the_attachment_link($post->ID, true, array(450, 800)); // This also populates the iconsize for the next line ?>
<?php $_post = &get_post($post->ID); $classname = ($_post->iconsize[0] <= 128 ? 'small' : '') . 'attachment'; // This lets us style narrow icons specially ?>
		<div class="post" id="post-<?php the_ID(); ?>">
			<h2><a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a> &raquo; <a href="<?php echo get_permalink() ?>" rel="bookmark" title="‫קישור קבוע: <?php the_title(); ?>"><?php the_title(); ?></a></h2>
			<div class="entrytext">
				<p class="<?php echo $classname; ?>"><?php echo $attachment_link; ?><br /><?php echo basename($post->guid); ?></p>

				<?php the_content('<p class="serif">לקרוא את שאר הפוסט &raquo;</p>'); ?>
	
				<?php link_pages('<p><strong>עמודים:</strong> ', '</p>', 'number'); ?>
	
				<p class="postmetadata alt">
					<small>
						הפוסט הזה נכתב ביום <?php the_time('l, d בF Y') ?>,
						בשעה <?php the_time() ?>, 
						והוא שייך לנושא <?php the_category(', ') ?>.
						את כל התגובות והטראקבאקים אפשר לקרוא ב-<a href="<?php bloginfo_rss('comments_rss2_url'); ?>">RSS 2.0</a>&rlm;.
								
						<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Both Comments and Pings are open ?>
							אפשר <a href="#respond">להגיב עליו</a> בבלוג הזה, או לשלוח <a href="<?php trackback_url(display); ?>">טראקבאק</a> מהבלוג שלך.&rlm;
						
						<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Only Pings are Open ?>
							אפשר לשלוח לפוסט הזה <a href="<?php trackback_url(display); ?> ">טראקבאק</a> מהאתר שלך.&rlm;
								
						<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Comments are open, Pings are not ?>
							אפשר לכתוב תגובה בתחתית העמוד, אבל אי אפשר כרגע לשלוח פינגים.&rlm;
			
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
