<div id="footer">

	<p><small>
		<a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a>
		פועל על 
		<a href="http://wordpress.org" title="וורדפרס בעברית, גרסה <?php bloginfo('version'); ?>">וורדפרס <?php bloginfo('version'); ?></a><!--
		<?php 
			_e(' and delivered to you in '); 
			timer_stop(1); 
			_e(' seconds using '); 
			echo $wpdb->num_queries; 
			_e(' queries.');
		?>-->
		<br />
	עיצוב: 
		Connections מאת <a href="http://www.vanillamist.com/blog/">פטרישיה מולר</a>; התאמה לעברית מאת 
<a href="http://www.trans.co.il/wp_themes/">רן יניב הרטשטיין</a></p>. 
	</small></p>
	<?php wp_footer(); ?>
</div> <!-- End id="footer" -->
</div> <!-- End id="main" -->
</div> <!-- End id="rap" -->
</body> 
</html>
