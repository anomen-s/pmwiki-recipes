<?php if (!defined('PmWiki')) exit();

/*
    QRCode script adds support for generating qr codes.
    - add (:qrcode text:) tag functionality

    Copyright 2020 Anomen (ludek_h@seznam.cz)
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published
    by the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.
*/

$RecipeInfo['QRCode']['Version'] = '2020-12-15';

SDV($PHPQRCODE_PATH, dirname(__FILE__) . "/phpqrcode");
include_once($PHPQRCODE_PATH . "/phpqrcode.php");

if (function_exists('Markup_e')) {
  Markup_e('qrcode','inline','/\(:qr\s+(.*\S)\s*:\)/',
    "Keep(qr_code_gen(\$m[1]))");
} else {
  Markup('qrcode','inline','/\(:qr\s+(.*\S)\s*:\)/e',
    "Keep(qr_code_gen('$1'))");
}

function qr_img_gen($text) {
    $frame = QRcode::text($text, false, QR_ECLEVEL_M);

    $h = count($frame);
    $w = strlen($frame[0]);
    $outerFrame = 2;

    $blockSize = 4;
    $imgW = $blockSize * ($w + 2 * $outerFrame);
    $imgH = $blockSize * ($h + 2 * $outerFrame);

    $base_image = imagecreate($imgW, $imgH);

    $col[0] = imagecolorallocate($base_image,255,255,255); // BG, white
    $col[1] = imagecolorallocate($base_image,0,0,0);     // FG, black
 
    imagefill($base_image, 0, 0, $col[0]);

    for($y=0; $y<$h; $y++) {
      for($x=0; $x<$w; $x++) {
          if ($frame[$y][$x] == '1') {
            imagefilledrectangle(
               $base_image,
               $blockSize*($x+$outerFrame),$blockSize*($y+$outerFrame),
               $blockSize*($x+$outerFrame+1)-1,$blockSize*($y+$outerFrame+1)-1,
               $col[1]);
          }
      }
    }
    ob_start();
    imagepng($base_image);
    $image_data = ob_get_contents();
    ob_end_clean();
    return $image_data;
}

function qr_code_gen($text)
{
    $imageData = base64_encode(qr_img_gen($text));

    $qtext = htmlspecialchars($text);
#   print_r($frame);
    // Echo out a sample image
    return '<img title="' . $qtext . '" alt="' . $qtext . '" src="data:image/png;base64,' . $imageData . '" />';
}

