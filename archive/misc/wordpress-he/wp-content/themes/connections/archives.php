<?php
/*
Template Name: ארכיון
*/
?>

<?php get_header()?>	

<div id="main">
	<div id="content">

	<!--- posts column content begin -->

	<?php if (have_posts()) { while (have_posts()) { the_post(); ?>

		<div class="page">

			<div class="page-info">
			<h2 class="page-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="קישור קבוע לעמוד: <?php the_title(); ?>"><?php the_title(); ?></a></h2>
				<?php /*Posted by <?php the_author(); ?>*/ ?><?php edit_post_link('(לערוך)'); ?>
			</div>
			<div class="page-content">
				<h2>ארכיון לפי חודשים</h2>
				<ul>
					<?php wp_get_archives('type=monthly'); ?>
				</ul>
				<h2>ארכיון לפי נושאים</h2>
				<ul>
					<?php wp_list_cats(); ?>
				</ul>
			</div>
		</div>	
	<?php } } ?>
	
	<!--- main content column content end -->
	</div>

<div id="sidebar">
<?php get_sidebar(); ?>
</div>

<?php get_footer();?>
