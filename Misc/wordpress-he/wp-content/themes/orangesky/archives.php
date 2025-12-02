<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>

<div id="content">
<div class="post">
<h2 class="pagetitle">ארכיון</h2>

	<h2>ארכיון חודשי:</h2>
	<ul class="links">
	    <?php wp_get_archives('type=monthly'); ?>
	  </ul>
	
	<h2>ארכיון נושאי:</h2>
	<ul class="links">
	     <?php wp_list_cats(); ?>
	  </ul>
	
	  <?php include (TEMPLATEPATH . '/searchform.php'); ?>

</div>
</div>	

<?php get_sidebar(); ?>

<?php get_footer(); ?>