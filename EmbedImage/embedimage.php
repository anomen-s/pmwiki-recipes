<?php if (!defined('PmWiki')) exit();

/*
    Embed Image adds support for inserting PNG/JPG images directly into page.
    - add (:embed base64-data  :) tag functionality

    todo:
      - sanitize input ?
      - svg/svgz ?

    Copyright 2023 Anomen (ludek_h@seznam.cz)
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published
    by the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.
*/

$RecipeInfo['EmbedImage']['Version'] = '2023-08-26';

Markup('embedimage','inline','/\(:img\s+((?:[twh]=\S+\s+)*)([a-zA-Z0-9\/\+\s]+=*)\s+:\)/si',
    "mu_EmbedImage");

function mu_EmbedImage($m) {
  return Keep(embed_image($m[1], $m[2]));
}

function embed_image_parse_params($param)
{
  $params = array('param' => $param);
  
  $pairs = preg_split("/\s+/", $param, -1, PREG_SPLIT_NO_EMPTY);
  foreach ($pairs as $p) {
    $tokens = explode('=', $p);
    $params[$tokens[0]] = $tokens[1];
  }
  return $params;
}

function embed_image($rawParams, $rawImageData)
{

  $params = embed_image_parse_params($rawParams);

  $attr = '';
  if (!empty($params['w'])) {
    $attr .= " width=\"{$params['w']}\"";
  }
  if (!empty($params['h'])) {
    $attr .= " height=\"{$params['h']}\"";
  }
  if (!empty($params['t'])) {
    $attr .= " title=\"{$params['t']}\"";
    $attr .= " alt=\"{$params['t']}\"";
  }

  // remove all whitespace
  $ws = array(' ' => '', '\t' => '', '\r' => '', '\n' => '');
  $imageData = strtr($rawImageData, $ws);

  // note: str_starts_with is not avail before PHP8
  
  if (substr($imageData, 0, 8) == 'iVBORw0K') {
    $mime = 'image/png';
  }
  elseif (substr($imageData, 0, 4) == '/9j/') {
    $mime = 'image/jpeg';
  }
  elseif (substr($imageData, 0, 8) == 'R0lGODlh') {
    // gif89
    $mime = 'image/gif';
  }
  elseif (substr($imageData, 0, 8) == 'R0lGODdh') {
    // gif87
    $mime = 'image/gif';
  }
  elseif (substr($imageData, 0, 4) == 'PD94') {
    $mime = 'image/svg+xml';
  }
  else {
    return '[Invalid image]';
  }

  return '<img '. $attr .' src="data:' . $mime . ';base64,' . $imageData . '" />';
}
