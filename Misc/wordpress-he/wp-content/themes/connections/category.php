<?php get_header();?>	

<div id="main">


<div id="content">
	<?php if (have_posts()) { ?>
		<h3><?php echo single_cat_title(); ?></h3>
		<p class="archive-description">פוסטים בארכיון של הנושא '<?php echo single_cat_title(); ?>'</p>
		<br/>				
		<?php foreach ($posts as $post) : start_wp(); ?>				
			<div class="post">
				<?php require('post.php'); ?>
				<?php comments_template(); // Get wp-comments.php template ?>
			</div>
		<?php endforeach; ?>
		<p class="center"><?php posts_nav_link() ?></p>		
	<?php } else { ?>
	<p>לא מצאתי שום דבר כזה.</p>
	<?php } ?>
		
</div>


<div id="sidebar">
	<ul><li>
			<h2>ארכיון</h2>
	<ul><li>אלו פוסטים מארכיון הנושא &rsquo;<?php single_cat_title(''); ?>&lsquo;.</li></ul>
	</li></ul>
<?php get_sidebar(); ?>
</div>

<?php get_footer()?>
