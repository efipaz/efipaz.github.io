
<?php get_header()?>	
archive.php
<div id="main">
	<div id="content">
	<!--- posts column content begin -->
		<?php if (have_posts()) { ?>

			<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
			<?php /* If this is a category archive */ if (is_category()) { ?>
			<h2><?php _e('Archive for the '); echo single_cat_title(); _e(' Category'); ?></h2>
			<div class="post-info"><?php _e('Category Archive'); ?></div>

	 	  	<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
			<h2><?php _e('Archive for '); the_time('F jS, Y'); ?></h2>
			<div class="post-info"><?php _e('Daily Archive'); ?></div>

		 	<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
			<h2><?php _e('Archive for '); the_time('F, Y'); ?></h2>
			<div class="post-info"><?php _e('Monthly Archive'); ?></div>

			<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
			<h2><?php _e('Archive for '); the_time('Y'); ?></h2>
			<div class="post-info"><?php _e('Yearly Archive'); ?></div>

		  	<?php /* If this is a search */ } elseif (is_search()) { ?>
			<h2><?php _e('Search Results'); ?></h2>

		  	<?php /* If this is an author archive */ } elseif (is_author()) { ?>
			<h2><?php _e('Author Archive'); ?></h2>

			<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
			<h2><?php _e('Blog Archives'); ?></h2>

		<?php } ?>
			<div class="left"><?php posts_nav_link('','','&laquo; Previous Entries') ?></div>
			<div class="right"><?php posts_nav_link('','Next Entries &raquo;','') ?></div>
			<div class="clear"></div>
		<?php while (have_posts()) { the_post(); ?>
		
			<!-- post date and title -->
			<h5><?php the_time('l, F jS, Y') ?></h5>
			<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a></h2>
			<h6><?php edit_post_link(); ?></h6>
			
			<!-- post -->
			<?php the_excerpt() ?>
			
			<!-- post meta -->
			<h5><?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?>
			- <?php _e("Posted in"); ?> <?php the_category(',') ?> by <strong><?php the_author_posts_link(); ?></strong></h5>
			<h6><?php edit_post_link(); ?></h6>
			<!--
			<?php trackback_rdf(); ?>
			-->

			<hr />
		<?php } ?>
			<div class="alignleft"><?php posts_nav_link('','','&laquo; Previous Entries') ?></div>
			<div class="alignright"><?php posts_nav_link('','Next Entries &raquo;','') ?></div>
			<div class="clear"></div>
	<?php } else { ?>
		<h2 class="center">לא מצאתי</h2>
		<p class="center">אין פה שום דבר כזה.</p>
	<?php } ?>

	<!--- main content column content end -->
	</div>

<div id="sidebar">

<ul><li>
	<h2>ארכיון</h2>
	<ul><li>אלו פוסטים מהארכיון של הבלוג <a href="<?php echo bloginfo('home'); ?>/"><?php echo bloginfo('name'); ?></a>.</li></ul>
</li></ul>

<?php get_sidebar(); ?>
</div>

<?php  get_footer();?>
