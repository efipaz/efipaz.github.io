<?php
/*
Template Name: About
*/
?>

<?php get_header(); ?>

<div id="content">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<div class="post">
<h2 class="pagetitle">קצת עלי</h2>

	<dl>
		<dt>אני:</dt>
			<dd><?php the_author(); ?></dd>
		<dt>עלי:</dt>
			<dd><?php the_author_description(); ?></dd>
	</dl>
	<?php endwhile; else: ?>
	
		<p>לא מצאתי שום דבר כזה.</p>
	
<?php endif; ?>
</div>
</div>	

<?php get_sidebar(); ?>

<?php get_footer(); ?>