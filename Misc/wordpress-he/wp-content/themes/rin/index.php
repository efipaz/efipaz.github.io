<?php get_header(); ?>
 <div id="container" class="clearfix">
  <?php get_sidebar(); ?>
  <div id="topcontentdouble"></div>
   <div id="content">
     <div class="contentright">
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
       <div class="post">
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
        </div>
        <div class="meta">
         <div class="author">
	      <?php the_author() ?> @ <?php the_time() ?> <?php edit_post_link('(לערוך)'); ?>

         </div>
תחת הנושאים
 <?php the_category(', ') ?> 
        </div>
        <div class="feedback">
         <?php comments_popup_link('אין תגובות',  'תגובה אחת', '% תגובות'); ?>        </div>
		<?php wp_link_pages(); ?> 
        <!--<?php trackback_rdf(); ?>  -->
       </div> <!-- Closes the post div-->
       <?php comments_template(); // Get wp-comments.php template ?>
	   <?php endwhile; else: ?>
       לא מצאתי שום דבר כזה.
       <?php endif; ?>
		<div class="navigation">
							<div class="alignright"><?php next_posts_link('&laquo; פוסטים ישנים יותר') ?></div>
				<div class="alignleft"><?php previous_posts_link('פוסטים חדשים יותר &raquo;') ?></div>

		</div>
      </div> <!--Closes the contentright div-->
     </div> <!-- Closes the content div-->
     <div id="bottomcontentdouble">
    </div>
 </div> <!-- Closes the container div-->
<?php get_footer(); ?>