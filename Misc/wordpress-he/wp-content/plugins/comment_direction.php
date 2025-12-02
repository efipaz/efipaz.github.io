<?php
/*
Plugin Name: כיווניות תגובות
Plugin URI: http://www.dontsmile.info
Description: יישור אוטומטי לתגובות בהתאם לכיווניות של השפה הדומיננטית בהן. בבלוגים עם עיצוב מימין לשמאל, תגובות באנגלית תיושרנה כהלכה, משמאל לימין.
Author: תום סלע
Version: 1.0
Author URI: http://www.dontsmile.info
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
*  http://www.gnu.org/licenses/gpl.html
*
*/

class comment_direction
{
  function banner()
  {
    echo "<!--// comment_direction v0.1 plug-in by Tom Sella // http://www.dontsmile.info //-->";
  }

  function domina($comment_text)
  {
    $c_eng = $this->count_it($comment_text, '/\w+/u');
    $c_heb = $this->count_it($comment_text, '/[\x{05B0}-\x{05F4}]+/u');
    $c_arb = $this->count_it($comment_text, '/[\x{060C}-\x{06FE}]+/u');
    $dir = ($c_eng >= ($c_heb + $c_arb)) ? 'ltr' : 'rtl';
    $comment_text = "<div style='direction: {$dir};'><p>" . $comment_text . "</p></div>";
    return $comment_text;
  }

  function count_it($data, $match)
  {
    $i = 0;
    while (preg_match($match, $data, $x, PREG_OFFSET_CAPTURE))
    {
      $i += strlen($x[0][0]);
      $data = substr($data,$x[0][1] + strlen($x[0][0]));
    }
    return $i;
  }
  
  function comment_direction()
  {
    add_action('wp_head', array(&$this, 'banner'));
    add_action('comment_text', array(&$this, 'domina'));
  }
}

$countit = new comment_direction();
?>
