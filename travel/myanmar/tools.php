<?php
$keykey = "ZAcfs23BgS44902D1a0";

function get_rnd_iv($iv_len)
{
   $iv = '';
   while ($iv_len-- > 0) {
       $iv .= chr(mt_rand() & 0xff);
   }
   return $iv;
}

function md5_encrypt($plain_text, $iv_len = 16)
{
   $plain_text .= "\x13";
   $n = strlen($plain_text);
   if ($n % 16) $plain_text .= str_repeat("\0", 16 - ($n % 16));
   $i = 0;
   $enc_text = get_rnd_iv($iv_len);
   $iv = substr($keykey ^ $enc_text, 0, 512);
   while ($i < $n) {
       $block = substr($plain_text, $i, 16) ^ pack('H*', md5($iv));
       $enc_text .= $block;
       $iv = substr($block . $iv, 0, 512) ^ $keykey;
       $i += 16;
   }
   return base64_encode($enc_text);
}

function md5_decrypt($enc_text, $iv_len = 16)
{
   $enc_text = base64_decode($enc_text);
   $n = strlen($enc_text);
   $i = $iv_len;
   $plain_text = '';
   $iv = substr($keykey ^ substr($enc_text, 0, $iv_len), 0, 512);
   while ($i < $n) {
       $block = substr($enc_text, $i, 16);
       $plain_text .= $block ^ pack('H*', md5($iv));
       $iv = substr($block . $iv, 0, 512) ^ $keykey;
       $i += 16;
   }
   return preg_replace('/\\x13\\x00*$/', '', $plain_text);
}

function get_size2price_array()
{
	$one = array('50', '40X60');
	$two = array('56', '50X75');
	$three = array('62', '60X90');
	$total = array($one, $two, $three);
	return $total;
}

function get_size_from_price($price)
{
	$total = get_size2price_array();
	foreach($total as $key => $val)
	{
		if($val[0] == $price)
		{
			return $val[1];
		}
	}
	return 'Error';
}
?>