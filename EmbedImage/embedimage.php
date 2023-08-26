<?php if (!defined('PmWiki')) exit();

/*
    Embed Image adds support for inserting PNG/JPG images directly into page.
    - add (:embed base64-data  :) tag functionality

    Copyright 2023 Anomen (ludek_h@seznam.cz)
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published
    by the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.
*/

$RecipeInfo['EmbedImage']['Version'] = '2023-08-25';

Markup('embedimage','inline','/\(:img\s+(.*\S)\s*:\)/si',
    "mu_EmbedImage");

function mu_EmbedImage($m) {
  return Keep(embed_image($m[1]));
}

function embed_image($imageData)
{
  // todo sanitize

  if (substr($imageData, 0, 8) == 'iVBORw0K') {
    return '<img src="data:image/png;base64,' . $imageData . '" />';
  }
  if (substr($imageData, 0, 4) == '/9j/') {
    return '<img src="data:image/jpeg;base64,' . $imageData . '" />';
  }

  // todo svg?

  return '[Invalid image]';
}

