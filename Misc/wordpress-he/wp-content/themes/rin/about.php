<?php

/*

Template Name: About

*/

?>
<?php include "header.php"; ?>
 <div id="container">
  <div id="topcontent"></div>
  <div id="singlecontent">
   <div class="singlepages">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
     <?php the_content(); ?>
    <?php endwhile; endif; ?>
   </div>   
   <div id="bottomcontent"> </div>
  </div>
 </div>
<?php get_footer(); ?>

