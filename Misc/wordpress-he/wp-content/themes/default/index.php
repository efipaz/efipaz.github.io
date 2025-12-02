<?php get_header(); ?>

	<div id="content" class="narrowcolumn">

	<?php if (have_posts()) : ?>
		
		<?php while (have_posts()) : the_post(); ?>
				
			<div class="post" id="post-<?php the_ID(); ?>">
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
				<small><?php the_time('d בF Y'); ?> מאת <?php the_author(); ?> </small>

				<div class="entry">
					<?php the_content('המשך &raquo;'); ?>
				</div>
		
				<p class="postmetadata">שייך לנושא <?php the_category(', ') ?> <strong>|</strong>  <?php edit_post_link('לערוך','','<strong> |</strong>'); ?>  <?php comments_popup_link('אין תגובות &#187;', 'תגובה אחת &#187;', '% תגובות &#187;'); ?></p> 
				
			</div>
	
		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignright"><?php next_posts_link('&laquo; פוסטים ישנים יותר') ?></div>
			<div class="alignleft"><?php previous_posts_link('פוסטים חדשים יותר &raquo;') ?></div>
		</div>
		
	<?php else : ?>

		<h2 class="center">לא מצאתי</h2>
		<p class="center">לא מצאתי את מה שחיפשת.</p>
		<?php include (TEMPLATEPATH . "/searchform.php"); ?>

	<?php endif; ?>

	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
