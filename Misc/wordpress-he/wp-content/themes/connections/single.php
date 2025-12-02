<?php get_header()?>	
<div id="main">
	<div id="content">
	<!--- posts column content begin -->
		<?php if (have_posts()) { while (have_posts()) { the_post(); ?>
			<div class="post">
				<?php require('post.php'); ?>

		<div class="navigation">
			<div class="alignleft"><?php next_post_link('<small>(אחרי)</small> %link &raquo;') ?></div>
			<div class="alignright"><?php previous_post_link('&laquo; %link <small>(לפני)</small>') ?></div>
		</div>


				<div class="post-footer">&nbsp;</div>
				<?php comments_template(); // Get wp-comments.php template ?>
			</div>
		<?php } } else { ?>
			<p>לא מצאתי פה שום דבר כזה</p>
		<?php } ?>
	<!--- main content column content end -->
	</div>

<div id="sidebar">

<?php if (have_posts()) { ?>
<ul>
	<li id="archivedentry">
		<h2>פוסט מהארכיון</h2>
		<ul>
			<li><strong>תאריך הכתיבה:</strong></li>
			<li><?php the_time('l, M j, Y');?> <br />
				בשעה <?php the_time(); ?></li>
				
			<li><strong>נושאים:</strong></li>
			<li><?php the_category(', '); ?></li>
			<li><strong>אפשרויות:</strong></li>
			<li><?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) 
				{
					// Both Comments and Pings are open 
					echo ('אפשר <a href="#respond">להשאיר תגובה</a> בעמוד הזה, או לשלוח <a href="'); trackback_url(display); echo ('">טראקבאק</a> מהבלוג שלך. אפשר לעקוב אחרי הדיון אודות הפוסט הזה באמצעות '); comments_rss_link('פיד RSS'); echo ('. ');
				}
				elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status))
				{
					// Only Pings are Open 
					echo ('אפשר לשלוח <a href="'); trackback_url(display); echo ('">טראקבאק</a> מהבלוג שלך, ואפשר לעקוב אחרי הדיון אודות הפוסט הזה באמצעות '); comments_rss_link('פיד RSS'); echo ('. ');
				}
				elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status))
				{
					// Comments are open, Pings are not
					echo ('אפשר <a href="#respond">להשאיר תגובה</a> כאן בתחתית העמוד, ואפשר לעקוב אחרי הדיון אודות הפוסט הזה באמצעות '); comments_rss_link('פיד RSS'); echo ('. '); 
				}
				elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status))
				{
					// Neither Comments, nor Pings are open
					echo ('הפוסט הזה סגור כרגע לתגובות');
				}
				edit_post_link(' לערוך את הפוסט הזה.','',''); ?>
			</li>
		</ul>
	</li>
</ul>
<?php } ?>	

<?php get_sidebar(); ?>
</div>

<?php  get_footer();?>
