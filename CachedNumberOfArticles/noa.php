<?php if (!defined('PmWiki')) exit();

/*
    CachedNumberOfArticles script adds support for printing number of pages in wiki
    - add (:numberofarticles:) tag functionality
    - this version uses WikiDir->ls() to obtin number of articles

    Copyright 2006-2011 Anomen (ludek_h@seznam.cz)
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published
    by the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.
*/

$RecipeInfo['CachedNumberOfArticles']['Version'] = '2021-10-25';


Markup('numberofarticles','inline','/\\(:numberofarticles(\s+refresh)?\s*:\\)/si',
    "mu_Noa");

$NOAFile = "$WorkDir/.noa";

function mu_Noa($m) {
  return Keep(noa_GetNumArticles($m[1]));
}

function noa_RefreshNumArticles()
{
   global $NOAFile;
   global $WikiDir;

   $count = count($WikiDir->ls());

   $f = fopen($NOAFile, 'w');
   fwrite($f, $count);
   fclose($f);

   return "<!--fresh-->$count\n";
}

function noa_GetNumArticles($refresh)
{
    global $NOAFile;
    $content = array();

    if (!empty($refresh)) {
	return noa_RefreshNumArticles();

    } else if (FALSE === ($content = @file($NOAFile))) {
	return noa_RefreshNumArticles();

    } else {      
	return implode('', $content);
    }
}

