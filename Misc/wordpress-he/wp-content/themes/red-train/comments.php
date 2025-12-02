<div class="navigation">
	<div class="alignright"><?php previous_post('&laquo; %','','yes') ?></div>
	<div class="alignleft"><?php next_post(' % &raquo;','','yes') ?></div>
</div>

<div class="comments">

<?php if ( !empty($post->post_password) && $_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) : ?>
<p>הפוסט הזה מוגן. צריך להזין סיסמה כדי לקרוא את התגובות עליו.</p>
<?php return; endif; ?>

<h4 id="comments"><?php comments_number('אין תגובות',  'תגובה אחת', '% תגובות'); ?> 
<?php if ( comments_open() ) : ?>
	<a href="#postcomment" title="לכתוב תגובה"><strong>&raquo;</strong></a>
<?php endif; ?>
</h4>


<?php if ( $comments ) : ?>
<ol id="commentlist">

<?php foreach ($comments as $comment) : ?>
	<li id="comment-<?php comment_ID() ?>">
	<?php comment_text() ?>
	<p><cite><?php comment_type('תגובה', 'טראקבאק', 'פינגבאק'); ?> מ<?php comment_author_link() ?> &#8212; <?php comment_date() ?> בשעה <a href="#comment-<?php comment_ID() ?>"><?php comment_time() ?></a></cite> <?php edit_comment_link('(לערוך)', ' |'); ?></p>
	</li>

<?php endforeach; ?>

</ol>

<?php else : // If there are no comments yet ?>
	<p>אין תגובות עדיין</p>
<?php endif; ?>

<p><a href="<?php bloginfo('comments_rss2_url'); ?>" title="תגובות ב-RSS">RSS של התגובות לפוסט הזה.</a> 
<?php if ( pings_open() ) : ?>
	 | <a href="<?php trackback_url() ?>" rel="trackback" title="כתובת לשליחת טראקבאק מאתר אחר">כתובת טראקבאק</a>
<?php endif; ?>
</p>

<?php if ( comments_open() ) : ?>
<h4 id="postcomment">לכתוב תגובה</h4>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p>צריך <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">להכנס למערכת</a> בשביל לפרסם תגובות.</p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>

<p>שלום <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="להתחבר בשם אחר">לצאת &raquo;</a></p>

<?php else : ?>

<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" accesskey="a" />
<label for="author"><small><strong>שם</strong> <?php if ($req) echo ('(חובה)'); ?></small></label></p>

<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" accesskey="m" />
<label for="email"><small><strong>דואל</strong> 
<?php if ($req) echo ('(חובה)'); ?> (אף אחד לא יראה את זה)</small></label></p>

<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" accesskey="u" />
<label for="url"><small><strong>אתר</strong></small></label></p>

<?php endif; ?>

<p><small><strong>XHTML:</strong> אפשר להשתמש בתגים האלה: <code dir="ltr"><?php echo allowed_tags(); ?></code></small></p>

<p><textarea name="comment" id="comment" cols="55" rows="11" tabindex="4"></textarea></p>

<p><input name="submit" type="submit" id="submit" tabindex="5" value="לפרסם" accesskey="m" />

<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
</p>
<?php do_action('comment_form', $post->ID); ?>

</form>

<?php endif; // If registration required and not logged in ?>

<?php else : // Comments are closed ?>
<p><?php _e('Sorry, the comment form is closed at this time.'); ?></p>
<?php endif; ?>
</div>