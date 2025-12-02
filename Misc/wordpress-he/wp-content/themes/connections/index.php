<?php get_header(); ?>

<div id="main">
	<div id="content">
	<!--- posts column content begin -->
		
		<?php if (have_posts()) { while (have_posts()) { the_post(); ?>
		
		<div class="post">
			<?php require('post.php'); ?>
			<?php comments_template(); // Get wp-comments.php template ?>
		</div>
		
		<?php } } else { ?>
		<h2>בעיה</h2>
		<p>לא מצאתי פה שום דבר כזה.</p>
		<?php } ?>

		<div class="navigation">
			<div class="alignright"><?php next_posts_link('&laquo; פוסטים ישנים יותר') ?></div>
			<div class="alignleft"><?php previous_posts_link('פוסטים חדשים יותר &raquo;') ?></div>
		</div>

	</div>


<div id="sidebar">
<?php get_sidebar(); ?>
</div>


<?php get_footer(); ?>
