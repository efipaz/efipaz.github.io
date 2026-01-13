<?php 
get_header();
?>
<?php get_sidebar(); ?>
<hr />
<div id="content">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<?php // Post dates off by default the_date('','<h2>','</h2>'); ?>
	<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>	
	<div class="meta">מאת
		<?php the_author() ?>, <?php the_time('F j, Y') ?>, תחת הנושאים <?php the_category(',') ?> <?php edit_post_link('לערוך'); ?></div>
	<div class="main">
		<?php the_content('(המשך...)'); ?>
	</div>
	<div class="comments">
		<?php wp_link_pages(); ?>
		<?php comments_popup_link('<strong>אין</strong> תגובות', 'תגובה <strong>אחת</strong>', '<strong>%</strong> תגובות'); ?>
	</div>
	
	<!--
	<?php trackback_rdf(); ?>
	-->


<?php comments_template(); ?>

<?php endwhile; else: ?>
<div class="warning">
	<p>לא מצאתי פה שום דבר כזה.</p>
</div>
<?php endif; ?>

<div class="navigation">
				<div class="alignright"><?php next_posts_link('&laquo; פוסטים ישנים יותר') ?></div>
				<div class="alignleft"><?php previous_posts_link('פוסטים חדשים יותר &raquo;') ?></div>
</div>

	</div>
<!-- End float clearing -->
</div>
<!-- End content -->
<?php get_footer(); ?>
