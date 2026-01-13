<?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

        if (!empty($post->post_password)) { // if there's a password
            if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
				?>
				
				<p class="nocomments">הפוסט הזה מוגן. צריך להזין סיסמה כדי לפרסם תגובה.<p>
				
				<?php
				return;
            }
        }

		/* This variable is for alternating comment background */
		$oddcomment = 'alt';
?>

<!-- You can start editing here. -->

<?php if ($comments) : ?>
	<h3 id="comments"><?php comments_number('אין תגובות', 'תגובה אחת', '% תגובות' );?> לפוסט &#8221;<?php the_title(); ?>&#8220;</h3> 

	<ol class="commentlist">

	<?php foreach ($comments as $comment) : ?>

		<li class="<?php echo $oddcomment; ?>" id="comment-<?php comment_ID() ?>">
			<cite>מאת <?php comment_author_link() ?>:</cite>
			<?php if ($comment->comment_approved == '0') : ?>
			<em>התגובה שלך ממתינה לאישור.</em>
			<?php endif; ?>
			<br />

			<p class="commentmetadata"><a href="#comment-<?php comment_ID() ?>" title=""><?php comment_date('F j, Y') ?> at <?php comment_time() ?></a> <?php edit_comment_link('(לערוך)','',''); ?></p>

			<?php comment_text() ?>

		</li>

	<?php /* Changes every other comment to a different class */	
		if ('alt' == $oddcomment) $oddcomment = 'even';
		else $oddcomment = 'alt';
	?>

	<?php endforeach; /* end for each comment */ ?>

	</ol>

 <?php else : // this is displayed if there are no comments so far ?>

  <?php if ('open' == $post-> comment_status) : ?> 
		<!-- If comments are open, but there are no comments. -->
		
	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments">אין אפשר לפרסם תגובות כרגע.</p>
		
	<?php endif; ?>
<?php endif; ?>


<?php if ('open' == $post-> comment_status) : ?>

<h3 id="respond">לכתוב תגובה</h3>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p>צריך <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">להכנס למערכת</a> בשביל לפרסם תגובות.</p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform" name="commentform">

<?php if ( $user_ID ) : ?>

<p>שלום <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="להתחבר בשם אחר">לצאת &raquo;</a></p>

<?php else : ?>

<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" accesskey="a" />
<label for="author"><small><strong>שם</strong> <?php if ($req) echo ('(חובה)'); ?></small></label></p>

<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" accesskey="m" />
<label for="email"><small><strong>דואל</strong> <?php if ($req) echo ('(חובה)'); ?> (אף אחד לא יראה את זה)</small></label></p>

<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" accesskey="u" />
<label for="url"><small><strong>אתר</strong></small></label></p>

<?php endif; ?>

<!--<p><small><strong>XHTML:</strong> אפשר להשתמש בתגים האלה: <code dir="ltr"><?php echo allowed_tags(); ?></code></p>-->

<p><textarea name="comment" id="comment" cols="80" rows="10" tabindex="4" accesskey="c"></textarea></p>

<p><input name="submit" type="submit" id="submit" tabindex="5" value="לפרסם" accesskey="m" />
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
</p>
<?php do_action('comment_form', $post->ID); ?>

</form>

<?php endif; // If registration required and not logged in ?>

<?php endif; // if you delete this the sky will fall on your head ?>