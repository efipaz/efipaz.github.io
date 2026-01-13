<?php get_header()?>	
<div id="main">

<div id="content">

	<?php if ($posts) { ?>	
	<?php $post = $posts[0]; /* Hack. Set $post so that the_date() works. */ ?>
	<?php if (is_day()) { ?>
		<h3><?php the_time('l, F j , Y'); ?></h3>			
		<div class="post-info">ארכיון יומי</div>
	<?php } elseif (is_month()) { ?>
		<h3><?php the_time('F Y'); ?></h3>
		<div class="post-info">ארכיון חודשי</div>
	<?php } elseif (is_year()) { ?>
		<h3><?php the_time('Y'); ?></h3>
		<div class="post-info">ארכיון שנתי</div>
	<?php } ?>				
	<br/>				
	<?php foreach ($posts as $post) : start_wp(); ?>
		<?php require('post.php'); ?>
	<?php endforeach; ?>
	
	<div class="navigation">
			<div class="alignright"><?php next_posts_link('&laquo; פוסטים ישנים יותר') ?></div>
			<div class="alignleft"><?php previous_posts_link('פוסטים חדשים יותר &raquo;') ?></div>
	</div>
	
	<?php } else { ?>
		<p>לא מצאתי שום דבר כזה.</p>
	<?php } ?>
	
</div>
	
<div id="sidebar">
	<ul><li>
	<?php /* If this is a daily archive */ if (isset($_GET['day']) && !empty($_GET['day'])) { ?>
		<h2>ארכיון</h2>
		<ul><li>אלו פוסטים מהארכיון של האתר <a href="<?php bloginfo('url'); ?>"><?php echo bloginfo('name'); ?></a> מהיום <?php the_time('l, F j , Y'); ?>.</li></ul>
		
		<?php /* If this is a monthly archive */ } elseif ((isset($_GET['m']) && !empty($_GET['m'])) or (isset($_GET['monthnum']) && ! empty($_GET['monthnum']))) { ?>
		<h2>ארכיון</h2>
		<ul><li>אלו פוסטים מהארכיון של האתר <a href="<?php bloginfo('url'); ?>"><?php echo bloginfo('name'); ?></a> מהחודש <?php the_time('F, Y'); ?>.</li></ul>

		<?php /* If this is a yearly archive */ } elseif (isset($_GET['year']) && !empty($_GET['year'])) { ?>
		<h2>ארכיון</h2>
		<ul><li>אלו פוסטים מהארכיון של האתר <a href="<?php bloginfo('url'); ?>"><?php echo bloginfo('name'); ?></a> מהשנה <?php the_time('Y'); ?>.</li></ul>
		<?php } ?>			
	</li></ul>
	<?php get_sidebar(); ?>
	
</div>

<?php get_footer();?>