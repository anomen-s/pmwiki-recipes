<?php if (!defined('PmWiki')) exit();

/*
    The noa script adds support for printing number of pages in wiki
    - add (:numberofarticles:) tag functionality
    - this version uses WikiDir->ls() to obtin numberer of articles

    Copyright 2006 Anomen (ludek_h@seznam.cz)
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published
    by the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.
*/

Markup('(:numberofarticles:)','>','/\\(:numberofarticles(\s+refresh)?\s*:\\)/e',
    "Keep(getNumArticles('$1'))");

$noafile = "$WorkDir/.noa";

function refreshNumArticles()
{
   global $noafile;
   global $WikiDir;

   $count = count($WikiDir->ls());

   $f = fopen($noafile, 'w');
   fwrite($f, $count);
   fclose($f);

   return "<!--fresh-->$count\n";
}

function getNumArticles($refresh)
{
    global $noafile;
    $content = array();

    if (!empty($refresh)) {
	return refreshNumArticles();

    } else if (FALSE === ($content = @file($noafile))) {
	return refreshNumArticles();

    } else {      
	return implode('', $content);
    }
}

?>