				<p class="post-date"><?php the_time('l j M'); ?><br/><?php the_time('Y'); ?></p>
				
				<div class="post-info">
					<h2 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="קישור קבוע לפוסט: <?php the_title(); ?>"><?php the_title(); ?></a></h2>
					<p>מאת <?php the_author(); ?>, תחת הנושאים <?php the_category(', '); ?><?php edit_post_link(' (לערוך)'); ?>
					<br/>
					<?php comments_popup_link('אין תגובות', 'תגובה אחת', '[%] תגובות'); ?></p>
				</div>
				
				<div class="post-content">
					<?php the_content('(המשך...)'); ?>
					<p class="post-info">
						<?php wp_link_pages(); ?>											
					</p>
					<!--
						<?php trackback_rdf(); ?>
					-->
					<div class="post-footer">&nbsp;</div>
				</div>