<?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');
        if (!empty($post->post_password)) 
		{ // if there's a password
            if ($_COOKIE['wp-postpass_'.COOKIEHASH] != $post->post_password) 
			{		// and it doesn't match the cookie
?>
			<p class="nocomments">
				<p class="nocomments">הפוסט הזה מוגן. צריך להזין סיסמה כדי לפרסם תגובה.<p>
			</p>
<?php
				return;
            }
        }
		/* This variable is for alternating comment background */
		$oddcomment = 'alt';
?>

<!-- You can start editing here. -->
<hr />
<!-- Comments start here -->
<?php if (is_array($comments)) { ?>
	<?php if ( !empty($post->post_password) && $_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) { ?>
		<p>צריך להזין את הסיסמה שלך כדי לקרוא את התגובות.</p>
	<?php return; } ?>
	<h2 id="comments">
		<?php comments_number('אין תגובות', 'תגובה אחת', '% תגובות' );?>
		לפוסט &#8220; <?php the_title(); ?> &#8221;
	</h2>
	
	<!-- Begin Comments -->
	<h3>תגובות:</h3>
	<ol class="commentlist">
		<?php foreach ($comments as $comment) { ?>
		<?php if ($comment->comment_type != "trackback" && $comment->comment_type != "pingback" && !ereg("<pingback />", $comment->comment_content) && !ereg("<trackback />", $comment->comment_content)) { ?>
			<li class="<?php echo $oddcomment; ?>" id="comment-<?php comment_ID() ?>">
				<div class="commenter">מאת <cite><?php comment_author_link() ?></cite>
				
			    <?php if ($comment->comment_approved == '0') { ?>
					<em>התגובה שלך ממתינה לאישור</em>
			    <?php } ?>
				<br />
			    <small class="commentmetadata">
					<a href="#comment-<?php comment_ID() ?>" title="">
					    <?php comment_date('F j, Y') ?>
					    בשעה
					    <?php comment_time() ?>
				    </a>
				    לערוך
			    </small>
				</div>
			    <?php comment_text() ?>
			</li>
			<?php /* Changes every other comment to a different class */	
				if ('alt' == $oddcomment) $oddcomment = '';
				else $oddcomment = 'alt';
			?>
		<?php } ?>
	  <?php } /* end for each comment */ ?>
	</ol>
	<!-- End Comments -->
	<br />
<?php } else { // this is displayed if there are no comments so far ?>
	<?php if ('open' == $post-> comment_status) { ?>
		<!-- If comments are open, but there are no comments. -->
		<p class="nocomments">עדיין לא נכתבו תגובות על הפוסט הזה.</p>
	<?php } else { // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments">הפוסט הזה סגור לתגובות.</p>
	<?php } ?>
<?php } ?>

<?php if ('open' == $post-> comment_status) { ?>
	<h3 id="respond">להשאיר תגובה</h3>
	<?php if ( get_option('comment_registration') && !$user_ID ) { ?>
	<p>צריך<a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">להכנס למערכת </a> כדי לכתוב תגובה</p>
	<?php } else { ?>
		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
		<?php if ( $user_ID ) { ?>
			<p>שלום <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. להגיב <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="להגיב בשם אחר">בשם אחר &raquo;</a></p>
		<?php } else { ?>
			<p>
				<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
				<label for="author"><small>שם <?php if ($req) (חובה); ?>
				</small></label>
			</p>
			<p>
				<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
				<label for="email"><small>דואל (אף אחד לא יראה את זה)<?php if ($req) (חובה); ?>
				</small></label>
			</p>
			<p>
				<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
				<label for="url"><small>אתר</small></label>
			</p>
		<?php } ?>
			<p><small><strong>XHTML:</strong> אפשר להשתמש בתגים האלה: <bdo dir="ltr"><?php echo allowed_tags(); ?></bdo></small></p>
			<p>
				<textarea name="comment" id="comment" cols="90%" rows="10" tabindex="4"></textarea>
			</p>
			<p>
				<input name="submit" type="submit" id="submit" tabindex="5" value="להגיב" />
				<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
			</p>
			<?php do_action('comment_form', $post->ID); ?>
		</form>
	<?php } // If registration required and not logged in ?>
<?php } // if you delete this the sky will fall on your head ?>
<br />
<?php if (is_array($comments)) { ?>
	<!-- Begin Trackbacks -->
	<?php foreach ($comments as $comment) { ?>
		<?php if (($comment->comment_type == "trackback") || ($comment->comment_type == "pingback") || ereg("<pingback />", $comment->comment_content) || ereg("<trackback />", $comment->comment_content)) { ?>
			<?php if (!$runonce) { $runonce = true; ?>
			<h3 id="trackbacks">
				טראקבאקים ופינגבאקים
			</h3>
			<ol class="commentlist">
			<?php } ?>
			<li class="<?php echo $oddcomment; ?>" id="comment-<?php comment_ID() ?>">
				<?php if (($comment->comment_type == "trackback") || ereg("<trackback />", $comment->comment_content))
					echo ('<strong>טראקבאק מאת</strong>'); 
				elseif (($comment->comment_type == "pingback") || ereg("<pingback />", $comment->comment_content))
					echo ('<strong>פינגבאק מאת</strong>'); 
				?>
				<?php comment_author_link() ?>
			    <?php if ($comment->comment_approved == '0') { ?>
					<em>התגובה שלך ממתינה לאישור</em>
			    <?php } ?>
				<br />
				<small class="commentmetadata">
					<a href="#comment-<?php comment_ID() ?>" title="">
						<?php comment_date('F j, Y') ?>
						בשעה
						<?php comment_time() ?>
					</a>
				<?php edit_comment_link('לערוך','',''); ?>
				</small>
				<?php comment_text() ?>
			</li>
		<?php } ?>
		<?php /* Changes every other comment to a different class */	
			if ('alt' == $oddcomment) $oddcomment = '';
			else $oddcomment = 'alt';
		?>
	<?php } ?>
	<?php if ($runonce) { ?>
		</ol>
	<?php } ?>
	<!-- End Trackbacks -->
<?php } ?>
