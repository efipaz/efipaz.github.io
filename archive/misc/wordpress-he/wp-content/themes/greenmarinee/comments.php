<?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

        if (!empty($post->post_password)) { // if there's a password
            if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
				?>
				
				<p class="nocomments">הפוסט הזה מוגן. צריך להזין סיסמה כדי לקרוא אותו.<p>
				
				<?php
				return;
            }
        }

		/* This variable is for alternating comment background */
		$oddcomment = 'alt';
?>

<!-- You can start editing here. -->

<?php if ($comments) : ?>
	<h3 class="reply"><?php comments_number('אין תגובות', 'תגובה אחת', '% תגובות' );?> לפוסט '<?php the_title(); ?>'</h3> 
<p class="comment_meta">לקרוא את התגובות ב-<?php comments_rss_link('<abbr title="Really Simple Syndication">RSS</abbr>'); ?> 
<?php if ( pings_open() ) : ?> או לשלוח
	 <a href="<?php trackback_url() ?>" rel="trackback">טראקבאק</a> לפוסט '<?php the_title(); ?>'.
<?php endif; ?>
</p>
	<ol class="commentlist">

	<?php foreach ($comments as $comment) : ?>

		<li class="<?php echo $oddcomment; ?>" id="comment-<?php comment_ID() ?>">
			<div class="comment_author">מאת 
				<strong><?php comment_author_link() ?></strong>
			</div>
			<?php if ($comment->comment_approved == '0') : ?>
			<em>התגובה שלך ממתינה לאישור.</em>
			<?php endif; ?>
			<br />

			<p class="metadate"><?php comment_date('j F, Y') ?> בשעה <?php comment_time() ?></p>

			<?php comment_text() ?>

		</li>

	<?php /* Changes every other comment to a different class */	
		if ('alt' == $oddcomment) $oddcomment = '';
		else $oddcomment = 'alt';
	?>

	<?php endforeach; /* end for each comment */ ?>

	</ol>

 <?php else : // this is displayed if there are no comments so far ?>

  <?php if ('open' == $post-> comment_status) : ?> 
		<!-- If comments are open, but there are no comments. -->
		
	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments">הפוסט הזה סגור לתגובות.</p>
		
	<?php endif; ?>
<?php endif; ?>


<?php if ('open' == $post-> comment_status) : ?>

<h3 class="reply">להגיב</h3>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p>צריך <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">להכנס</a> כדי לכתוב תגובות.</p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>

<p>שלום <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="להתחבר בשם אחר">לצאת &raquo;</a></p>

<?php else : ?>
<div class="postinput">
<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
<label for="author"><small><strong>שם</strong> <?php if ($req) echo ('(חובה)'); ?></small></label></p>

<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
<label for="email"><small><strong>דואל</strong> <?php if ($req) echo ('(חובה)'); ?> (אף אחד לא יראה את זה) </small></label></p>

<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
<label for="url"><small><strong>אתר</strong></small></label></p>

<?php endif; ?>

<!--<p><small><strong>XHTML:</strong> אפשר להשתמש בתגים האלה: <code dir="ltr"><?php echo allowed_tags(); ?></code></small></p>-->

<!--<p><small><strong>MarkDown:</strong> אפשר להשתמש ב-MarkDown</small></p>-->


<p><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p>

<p><input name="submit" type="submit" id="submit" tabindex="5" value="לפרסם תגובה" title="כדאי לקרוא שוב את התגובה לפני הפרסום" />
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
</p>
<?php do_action('comment_form', $post->ID); ?>
</div>
</form>

<?php endif; // If registration required and not logged in ?>

<?php endif; // if you delete this the sky will fall on your head ?>