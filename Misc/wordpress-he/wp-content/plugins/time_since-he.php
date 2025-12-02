<?php 
/* 
Plugin Name: כמה זמן עבר
Plugin URI: http://binarybonsai.com/wordpress/timesince
Description: מונה ומציג את הזמן שחלף מאז פרסום הפוסט או כתיבת התגובה
Author: מיכאל הילמן ודאנסטן אורכרד, התאמה לעברית על ידי רן יניב הרשטטיין
Author URI: http://binarybonsai.com
Version: 1.1

This plugin is based on code from Dunstan Orchard's Blog. Pluginiffied by Michael Heilemann:
http://www.1976design.com/blog/archive/2004/07/23/redesign-time-presentation/

adapted from original code by Natalie Downe
http://blog.natbat.co.uk/archive/2003/Jun/14/time_since

Notes by Michael Heilemann:
I am by _no_ means a PHP guru. In fact, I couldn't code my way out of a piece of wet cardboard.
But I really wanted to use Dunstan's code on Binary Bonsai, and this is the result. So please,
do not mock me for what is probably some very weird code.

*Instructions for use with WordPress 1.5:*
	
	Since Entry Publication:
	<?php if (function_exists('time_since_he')) { echo time_since_he(abs(strtotime($post->post_date_gmt . " GMT")), time()) ?> ago <? } else { the_time('F jS, Y') } ?>

<?php if (function_exists('time_since_he')) { echo ('לפני ' . time_since_he(abs(strtotime($post->post_date_gmt . " GMT")), time())) ?>

	Since Comment Publication:
	<?php if (function_exists('time_since_he')) { echo time_since_he(abs(strtotime($comment->comment_date_gmt . " GMT")), time()) ?> ago <? } else { the_time('F jS, Y') } ?>


The code needed looks a bit convoluted because this function is capable of more than
simply telling the time since an entry was published, but I'll leave that to more
skilled codemongers to figure out. Inputs must be unix timestamp (seconds)
$newer_date variable is optional

Please direct support questions to: http://www.flickr.com/groups/binarybonsai/
And gratitude to: http://www.1976design.com/blog/
And sour comments to: null

*/

function time_since_he($older_date, $newer_date = false)
	{
	// array of time period chunks
	$chunks = array(
	array(60 * 60 * 24 * 365 , 'שנים'),
	array(60 * 60 * 24 * 30 , 'חודשים'),
	array(60 * 60 * 24 * 7, 'שבועות'),
	array(60 * 60 * 24 , 'ימים'),
	array(60 * 60 , 'שעות'),
	array(60 , 'דקות'),
	);
	
	// $newer_date will equal false if we want to know the time elapsed between a date and the current time
	// $newer_date will have a value if we want to work out time elapsed between two known dates
	$newer_date = ($newer_date == false) ? (time()+(60*60*get_settings("gmt_offset"))) : $newer_date;
	
	// difference in seconds
	$since = $newer_date - $older_date;
	
	// we only want to output two chunks of time here, eg:
	// x years, xx months
	// x days, xx hours
	// so there's only two bits of calculation below:

	// step one: the first chunk
	for ($i = 0, $j = count($chunks); $i < $j; $i++)
		{
		$seconds = $chunks[$i][0];
		$name = $chunks[$i][1];

		// finding the biggest chunk (if the chunk fits, break)
		if (($count = floor($since / $seconds)) != 0)
			{
			break;
			}
		}

	// set output var
	$output = ($count == 1) ? '1 '.$name : "$count {$name}";

	// step two: the second chunk
	if ($i + 1 < $j)
		{
		$seconds2 = $chunks[$i + 1][0];
		$name2 = $chunks[$i + 1][1];
		
		if (($count2 = floor(($since - ($seconds * $count)) / $seconds2)) != 0)
			{
			// add to output var
			$output .= ($count2 == 1) ? ', 1 '.$name2 : ", $count2 {$name2}";
			}
		}
	
	return $output;
	}
?>