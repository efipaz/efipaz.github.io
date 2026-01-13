<?php get_header();?> 

<div id="main">

	<div id="content">
		<?php if (have_posts()) { while (have_posts()) { the_post(); ?>
		<div class="page">
		<div class="page-info"><h2 class="page-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="קישור קבוע לעמוד: <?php the_title(); ?>"><?php the_title(); ?></a> <?php edit_post_link('(לערוך)'); ?></h2></div>

			<div class="page-content">
				<?php the_content(); ?>
				<?php link_pages('<p class="center"><strong>עמודים:</strong> ', '</p>', 'number'); ?>
			</div>
		</div>
	  <?php } } ?>
	</div>

<div id="sidebar">
<?php get_sidebar(); ?>
</div>

<?php get_footer();?>
