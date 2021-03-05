--TEST--
Bug #73272 (imagescale() is not affected by, but affects imagesetinterpolation())
--SKIPIF--
<?php
if (!extension_loaded('gd')) die('skip gd extension not available');
?>
--FILE--
<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'func.inc';

$src = imagecreatetruecolor(100, 100);
imagefilledrectangle($src, 0,0, 99,99, 0xFFFFFF);
imageellipse($src, 49,49, 40,40, 0x000000);

imagesetinterpolation($src, IMG_NEAREST_NEIGHBOUR);
imagescale($src, 200, 200, IMG_BILINEAR_FIXED);
$dst = imagerotate($src, 60, 0xFFFFFF);

test_image_equals_file(__DIR__ . DIRECTORY_SEPARATOR . 'bug73272.png', $dst);
?>
===DONE===
--EXPECT--
The images are equal.
===DONE===