<?php get_header(); ?>
 <div id="container" class="clearfix">
  <?php get_sidebar(); ?>
  <div id="topcontentdouble"></div>
   <div id="content">
     <div class="contentright">
      <div class="post">
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<?php the_content('(המשך...)'); ?>
	
				<?php link_pages('<p><strong>עמודים:</strong> ', '</p>', 'number'); ?>
      <?php endwhile; endif; ?>
      </div>  
      </div>
     </div>
     <div id="bottomcontentdouble">
    </div>
 </div> <!-- Closes the container div-->
<?php get_footer(); ?>
