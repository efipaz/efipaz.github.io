<?php include "header.php"; ?>
 <div id="container">
  <div id="topcontent"></div>
  <div id="singlecontent">
   <div class="clearer"> </div>
   <div class="singlepost">
    <?php if (have_posts()) : ?>
     <h2 class="searchresult"><?php echo single_cat_title(); ?></h2>
     <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
     <div class="searchdetails">
      ארכיון הנושא '<?php echo single_cat_title(); ?>'
     </div>
      <?php while (have_posts()) : the_post(); ?>
	   <h2 class="searchresult">
        <a href="<?php the_permalink() ?>" rel="bookmark" title="קישור קבוע לפוסט: <?php the_title(); ?>">
   	     <?php the_title(); ?>
        </a>
       </h2>
       <div class="searchinfo">(<?php the_category(', ') ?>)</div>
       <div class="clearer"> </div>
       <?php the_excerpt() ?>
       <div class="searchinfo">
       </div>
      <?php endwhile; ?>
     <?php else : ?>
      לא מצאתי
    <?php endif; ?>
   </div> <!-- This closes the singlepost div-->
   
		<div class="navigation">
							<div class="alignright"><?php next_posts_link('&laquo; פוסטים ישנים יותר') ?></div>
				<div class="alignleft"><?php previous_posts_link('פוסטים חדשים יותר &raquo;') ?></div>

		</div>
   <div id="bottomcontent"> </div>
  </div> <!-- This closes the content div-->
 </div> <!-- This closes the container div-->
<?php get_footer(); ?>