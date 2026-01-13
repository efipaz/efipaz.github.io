<a name = "bottom"></a>
<div id="footer">
 <div id="menu">
  <form id="searchform" method="get" action="<?php echo $PHP_SELF; ?>">
   <input id="searchbutton" type="submit" name="submit" value="חיפוש" />
   <input type="text" name="s" id="search" size="15" />
  </form> 
 <div id="topimage"> 
  <a href="#">חזרה למעלה</a>  
 </div>
</div>
 <p class="credits"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a> &copy; 2005 <?php the_author() ?>. Rin מאת <a href="http://www.brokenkode.com/manji">חאלד אבו אלפא ויהושוע</a> והתאמה לעברית מאת <a href="http://www.trans.co.il">רן יניב הרטשטיין</a>.<br />
 אפשר לקבל <a href="<?php bloginfo('comments_rss2_url'); ?>" title="תגובות ב-RSS">תגובות ב-RSS&rlm;</a> וגם <a href="<?php bloginfo('rss2_url'); ?>" title="פוסטים ב-RSS">פוסטים ב-RSS&rlm;</a>. 
  תואם לתקנים <a href="http://validator.w3.org/check/referer">xhtml 1.0 transitional</a> /  
  <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a>. 
  פועל על <a href="http://www.trans.co.il/wp/" title="פועל על וורדפרס בעברית, מערכת בלוגים אישית">וורדפרס בעברית</a>.
 </p>
 <p class="wordpress"></p>
</div>
<?php do_action('wp_footer', ''); ?>
</body>
</html>