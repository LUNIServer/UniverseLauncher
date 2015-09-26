<?php
header ('Content-Type: image/png');
/*$im = @imagecreatetruecolor(80, 80)
      or die('Cannot Initialize new GD image stream');

imagesavealpha($im, true);
$trans_colour = imagecolorallocatealpha($im, 0, 0, 0, 127);
imagefill($im, 0, 0, $trans_colour);
$text_color = imagecolorallocate($im, 233, 14, 91);



imagepolygon($im, array(
		10, 10,
		69, 10,
		69, 69,
		10, 69
	), 4, $text_color);*/
	
$id = $_GET['id'];

$i1 = substr($id, 0, 8);
$i2 = substr($id, 8, 8);
$i3 = substr($id, 16, 8);
$i4 = substr($id, 24);

$n1 = hexdec($i1);
$n2 = hexdec($i2);
$n3 = hexdec($i3);
$n4 = hexdec($i4);

$inum = 27;

$r1 = $n1 % $inum;
$r2 = $n2 % $inum;
$r3 = $n3 % $inum;
$r4 = $n4 % $inum;

$s = $r1 + $r2 + $r3 + $r4;
$sm = $s % $inum;

echo file_get_contents('avatar/' . $sm . '.png');

//imagestring($im, 3, 12, 14,  $i1, $text_color);
//imagestring($im, 3, 12, 27,  $i2, $text_color);
//imagestring($im, 3, 12, 40,  $i3, $text_color);
//imagestring($im, 3, 12, 53,  $i4, $text_color);

//imagestring($im, 5, 41 - 5 * strlen($sm), 32,  $sm, $text_color);

//imagepng($im);
//imagedestroy($im);
?>