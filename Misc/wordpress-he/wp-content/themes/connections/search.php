<?php /* Don't remove this line. */ require('./wp-blog-header.php'); ?>

<?php get_header() ?>

<div id="main">
	<div id="content">	
	<?php if (have_posts()) { ?>	
		<?php $post = $posts[0]; /* Hack. Set $post so that the_date() works. */ ?>
		<h3>תוצאות חיפוש; echo '&#8220;<strong>'.$s.'</strong>&#8221;.'; ?></h3>			
		<div class="post-info">מצאת מה שחיפשת?</div>		
		<br/>				
		<?php while (have_posts()) { the_post(); ?>				
			<?php require('post.php'); ?>
		<?php } ?>
	<?php } else { ?>
		<h2 class="center">לא מצאתי</h2>
		<p><?php echo '&#8220;<strong>'.$s.'</strong>&#8221;.'; ?> לא מופיע בשום מקום בבלוג הזה.</p>
	<?php } ?>		
	</div>

<div id="sidebar">

<ul><li>
	<h2>ארכיון</h2>
	<ul><li>אלו תוצאות החיפוש <strong>&rdquo;<?php echo wp_specialchars($s); ?>&ldquo;</strong> בארכיון של הבלוג &rdquo;<a href="<?php echo bloginfo('home'); ?>/"><?php echo bloginfo('name'); ?></a>&ldquo;.
	אם לא הצלחת למצוא את מה שרצית, אולי אחד מהלינקים הבאים יעזרו לך יותר.</li></ul>
</li></ul>

<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
