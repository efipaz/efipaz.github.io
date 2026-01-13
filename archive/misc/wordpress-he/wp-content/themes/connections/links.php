<?php
/*
Template Name: קישורים
*/
?>

<?php get_header()?> 
<div id="main">
	<div id="content">
	<!--- posts column content begin -->
	
	<?php if (have_posts()) { while (have_posts()) { the_post(); ?>
		<div class="page">
			<div class="page-info">
				<h2 class="page-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="קישור קבוע לעמוד: <?php the_title(); ?>"><?php the_title(); ?></a> <?php edit_post_link('(לערוך)'); ?></h2>
			</div>
			<div class="page-content">
				<?php
					$cats = $wpdb->get_results("SELECT cat_id, cat_name FROM $wpdb->linkcategories");
					if ($cats) {
						foreach ($cats as $cat) {
							// Handle each category.
							// Display the category name
							echo '	<h3 id="linkcat-' . $cat->cat_ID . '">' . $cat->cat_name . "</h3>\n\t<ul>\n";
							// Call get_links() with all the appropriate params
							get_links($cat->cat_id,'<li>',"</li>","<br />", FALSE, 'name', TRUE, FALSE, -1, FALSE);
							// Close the last category
							echo "\n\t</ul>\n\n";
						}
					}
				?>
			</div>
		</div>	
	<?php } } ?>
	
	<!--- main content column content end -->
	</div>

<div id="sidebar">
	<?php get_sidebar(); ?>
</div>

<?php get_footer();?>
