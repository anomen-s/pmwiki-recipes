<?php if (!defined('PmWiki')) exit();

/*
    QRCode script adds support for generating qr codes.
    - add (:qrcode text:) tag functionality

    Copyright 2020-2021 Anomen (ludek_h@seznam.cz)
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published
    by the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.
*/

$RecipeInfo['QRCode']['Version'] = '2025-12-01';

SDV($PHPQRCODE_PATH, dirname(__FILE__) . "/phpqrcode");
require_once($PHPQRCODE_PATH . "/phpqrcode.php");

SDV($QR_ECLEVEL, QR_ECLEVEL_M);

Markup('qrcode','<split','/\(:qr\s+(.*?)\s*:\)/si',
    "mu_QR");

function mu_QR($m) {
  return Keep(qr_code_gen($m[1]));
}


function qr_img_gen($text) {
    global $QR_ECLEVEL;
    $frame = QRcode::text($text, false, $QR_ECLEVEL);

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

    // Echo out a sample image
    return '<img title="' . $qtext . '" alt="' . $qtext . '" src="data:image/png;base64,' . $imageData . '" />';
}

