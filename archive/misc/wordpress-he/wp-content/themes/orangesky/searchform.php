<form method="get" id="searchform" name="searchform" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div><input type="text" value="<?php echo wp_specialchars($s, 1); ?>" name="s" id="s" tabindex="6" accesskey="s" />
<input type="submit" id="searchsubmit" value="חיפוש" tabindex="7" accesskey="b" />
</div>
</form>