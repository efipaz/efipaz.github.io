<?php get_header(); ?>

	<div id="content">

	<?php if (have_posts()) : ?>
		
		<?php while (have_posts()) : the_post(); ?>
				
			<div class="post">
				<h2 class="postdate"><?php the_time('F j, Y') ?></h2>
				<h2 id="post-<?php the_ID(); ?>" class="posttitle"><a href="<?php the_permalink() ?>" rel="bookmark" title="קישור קבוע לפוסט: <?php the_title(); ?>"><?php the_title(); ?></a></h2>
				
				<div class="entry">
					<?php the_content('המשך &raquo;'); ?>
				</div>
		
				<p class="postmetadata">תחת הנושאים <?php the_category(', ') ?> | מאת <?php the_author() ?> <?php edit_post_link('לערוך','',' |'); ?>  <?php comments_popup_link('אין תגובות',  'תגובה אחת', '% תגובות'); ?></p> 
				
				<!--
				<?php trackback_rdf(); ?>
				-->
			</div>
	
		<?php endwhile; ?>

		<div class="navigation">
				<div class="alignright"><?php next_posts_link('&laquo; פוסטים ישנים יותר') ?></div>
				<div class="alignleft"><?php previous_posts_link('פוסטים חדשים יותר &raquo;') ?></div>
		</div>
		
	<?php else : ?>

		<h2 class="center">לא מצאתי</h2>
		<p class="center">לא מצאתי פה שום דבר כזה.</p>
		<?php include (TEMPLATEPATH . "/searchform.php"); ?>

	<?php endif; ?>

	</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
