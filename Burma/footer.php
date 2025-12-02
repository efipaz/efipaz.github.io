<?php
	$counter = 0;
	if(isset($_REQUEST['counter']))
	{
		$counter = $_REQUEST['counter'];
	}
	echo "
	<div id='wrapper'>
		<div align='center'>
			<table width='965' border='0' cellspacing='0' cellpadding='0'>
   				<tr align='center' valign='middle'>
   				";
   				if($counter == '1')
   				{
					echo "
						<td align='left' width='20%' valign='top'>
								<script type='text/javascript' language='javascript'>
									var sc_project=1692534;
									var sc_invisible=0;
									var sc_partition=16;
									var sc_security='272b18b1';
								</script>
								<script type='text/javascript' language='javascript' src='http://www.statcounter.com/counter/frames.js'></script>
								<noscript><img src='http://c17.statcounter.com/counter.php?sc_project=1692534&amp;java=0&amp;security=272b18b1&amp;invisible=0' alt='' border='0' height='14' width='39' align='middle'></noscript>
						</td>
					";
   				}
   				if($counter == '0')
   				{
   					echo "
   						<td align='left' width='30%' valign='top'><font size='2' >best viewed with 1024X768 resolution	</font></td>
   					";
   				}
   				$width = "40%";
   				if($counter == '1')
   				{
   					$width = "60%";
   				}
   				echo "
					<td align='center' width=".$width." valign='top'>
						<font size='2' >Copyright © 2006 Efi Paz & Amit Friedmann.</font>
					</td>
				";
				$width = "30%";
				if($counter == '1')
				{
					$width = "20%";
				}
				echo "
					<td align='right' width=".$width." valign='top'>
						<font size='2' >Created by <a href='mailto:diablo.blitz@gmail.com'>Amit</a>&nbsp;| <a href='http://www.amitfriedmann.com' target='_blank'> my page</a></font>
					</td>
				</tr>
			</table>
		</div>
	</div>
	";
?>