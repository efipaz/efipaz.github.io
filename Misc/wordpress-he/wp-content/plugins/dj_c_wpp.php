<?php
/*
Plugin Name: תיקון לריווח ניקוד dj_c
Plugin URI: http://www.dontsmile.info/?p=81
Description: תיקון בעית ריווח בדפדפנים מבוססי מוזילה, דוגמת פיירפוקס, כאשר הטקסט מנוקד, ומיושר לשני הצדדים. מידע נוסף ב-<a href='http://www.dontsmile.info/?p=81'>www.dontsmile.info</a>
Author: תום סלע
Version: 0.5b
Author URI: http://www.dontsmile.info
*/ 

/* dj_c.php - hebrew diacritic justification correction for mozilla and derivatives
 *           (see bug 209468 at https://bugzilla.mozilla.org/show_bug.cgi?id=209468)
 *
 * version 0.4b
 *
 * 1. include this file once in your php script , e.g. using require_once, require or include directives
 *
 * 2. whenever generating a block of hebrew text, with the possibility of containing
 *    diacritics, wrap the generating call diacritic_justification(),
 *    e.g. echo the_content() becomes echo diacritic_justification(the_content())
 *
 * copyright 2006 tom sella (i[at]dontsmile[dot]info)
 * released under gpl v2
 *
 *	This program is free software; you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License as published by
 *	the Free Software Foundation; either version 2 of the License, or
 *	(at your option) any later version.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU General Public License for more details.
 *
 *	You should have received a copy of the GNU General Public License
 *	along with this program; if not, write to the Free Software
 *	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
*/

$do_fix = is_moz();
$djs = '<span style="text-align: right;">';
$dje = '</span>';
// match: one or more base hebrew chars, followed by one or more diacritics, followed by any number of hebrew chars including diacritics
$match_heb_with_dia = '/([\x{05D0}-\x{05F2}]+[\x{05B0}-\x{05C3}]+[\x{05B0}-\x{05F2}]*)/u';
function is_moz()
{
  $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
  return (substr($ua, 0, 8) == 'mozilla/' && (!strpos($ua, 'msie') && !strpos($ua, 'opera')));
}

function diacritic_justification($data = '')
{
  global $do_fix;
  global $djs, $dje;
  global $match_heb_with_dia;
  $newdata = '';
  $intags = false;
  // this workround applies only to Mozilla based (e.g. Firefox) browsers
  if ($do_fix)
  {
    while (preg_match($match_heb_with_dia, $data, $x, PREG_OFFSET_CAPTURE))
    {
      // substring before match
      $s = substr($data, 0, $x[0][1]);
      // match data
      $w = $x[0][0];
      // check if last tag was closed
      if (strrpos($s, '>') != null)
      {
        $intags = false;
      }        
      // check if within html tags
      if ((strrpos($s, '<') >= strrpos($s, '>') && strrpos($s, '<') != null) || $intags)
      {
        $intags = true;
        // if so, do nothing
        $newdata .= $s . $w;
      }
      else
      {
        // otherwise, do something
        $newdata .= $s . $djs . $w . $dje;
      }
      // set up the next section for match
      $data = substr($data,$x[0][1] + strlen($x[0][0]));
    }
  }
  return $newdata . $data;
}

function head_banner()
{
  echo "<!--// בעיות ניקודתיות תוקנו על ידי dj_c // www.dontsmile.info // תום סלע //-->\n";
}

function title_fix()
{
  // i can't use the add_filter('the_title', ...), since the_title() is also called within
  // html tags, in a stage this script does not know the context, that would result
  // in a nested tag, breaking proper html.
  // instead, i add a stylesheet that targets the title in the header
  echo "<style type='text/css'>\n/* dj_c title diacritics fix */\nh2 { text-align: right; }\n.post h3 { text-align: right; }\n</style>\n";
}

if (function_exists('diacritic_justification'))
{
  // apply fix to the title - disabled, and for a good reason
  // 
  //add_filter('the_title', 'diacritic_justification');
  // apply fix to the content
  add_filter('the_content', 'diacritic_justification');
  // apply fix to the_excerpt
  add_filter('the_excerpt', 'diacritic_justification');
  // apply header info, for stats
  add_action('wp_head', 'head_banner');
  // apply fix for title
  if (is_moz())
  {
    add_action('wp_head', 'title_fix');
  }
}
?>
