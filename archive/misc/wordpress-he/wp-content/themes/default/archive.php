<?php get_header(); ?>

	<div id="content" class="narrowcolumn">

		<?php if (have_posts()) : ?>

		 <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
<?php /* If this is a category archive */ if (is_category()) { ?>				
		<h2 class="pagetitle">ארכיון פוסטים ששייכים לנושא '<?php echo single_cat_title(); ?>'</h2>
		
 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h2 class="pagetitle">ארכיון פוסטים שפורסמו ביום <?php the_time('d בF, Y'); ?></h2>
		
	 <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h2 class="pagetitle">ארכיון פוסטים שפורסמו בחודש <?php the_time('F Y'); ?></h2>

		<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h2 class="pagetitle">ארכיון פוסטים שפורסמו בשנת <?php the_time('Y'); ?></h2>
		
	  <?php /* If this is a search */ } elseif (is_search()) { ?>
		<h2 class="pagetitle">תוצאות החיפוש</h2>
		
	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h2 class="pagetitle">ארכיון פוסטים מאת</h2>

		<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h2 class="pagetitle">ארכיון</h2>

		<?php } ?>


		<div class="navigation">
			<div class="alignright"><?php next_posts_link('&laquo; פוסטים ישנים יותר') ?></div>
			<div class="alignleft"><?php previous_posts_link('פוסטים חדשים יותר &raquo;') ?></div>
		</div>

		<?php while (have_posts()) : the_post(); ?>
		<div class="post">
				<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="‫קישור קבוע לפוסט &rsquo;<?php the_title(); ?>&lsquo;"><?php the_title(); ?></a></h3>
				<small><?php the_time('l, d בF Y') ?></small>
				
				<div class="entry">
					<?php the_content() ?>
				</div>
		
				<p class="postmetadata">שייך לנושא <?php the_category(', ') ?> | <?php edit_post_link('לערוך', '', ' | '); ?>  <?php comments_popup_link('אין תגובות &#187;', 'תגובה אחת &#187;', '% תגובות &#187;'); ?></p> 

			</div>
	
		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignright"><?php next_posts_link('&laquo; פוסטים ישנים יותר') ?></div>
			<div class="alignleft"><?php previous_posts_link('פוסטים חדשים יותר &raquo;') ?></div>
		</div>
	
	<?php else : ?>

		<h2 class="center">לא מצאתי את מה שחיפשת.</h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<?php endif; ?>
		
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>