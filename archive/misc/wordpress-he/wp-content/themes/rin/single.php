<?php include "header.php"; ?>
 <div id="container">
  <div id="topcontent"></div>
  <div id="singlecontent">
   <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="postnavigation">
     <div class="left">
      <?php next_post('% &#187;','','yes') ?>
     </div>
     <div class="right">
      <?php previous_post('&#171; %','','yes') ?>
     </div>
    </div>
    <div class="singlepost">
     <div class="title" id="post-<?php the_ID(); ?>">
      <a href="<?php the_permalink() ?>" rel="bookmark">
       <?php the_title(); ?>
      </a>
     </div>
     <h3><span class="posted"></span>
      <?php the_time('l j F Y',display); ?>  
     </h3>
     <div class="storycontent">
      <?php the_content('(המשך...)'); ?>
     </div> <br/><?php wp_link_pages(); ?> 
    </div>
    <?php comments_template(); ?>
    <?php endwhile; else: ?>
    <p>לא מצאתי שום דבר כזה.</p>
   <?php endif; ?>
   <div id="bottomcontent"></div>
  </div>
 </div>
<?php get_footer(); ?>