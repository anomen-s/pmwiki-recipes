<?php if (!defined('PmWiki')) exit();
/*
    FlagTitles

    Copyright 2025 Anomen (ludek_h@seznam.cz)
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published
    by the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.
*/

$RecipeInfo['FlagTitles']['Version'] = '2025-12-01';


SDV($HTMLStylesFmt['flagtitles'], "
.flag-tooltip {
  cursor: help;
  border-bottom: 1px dotted #888;
  text-decoration: none;
}
.flag-tooltip:hover {
  border-bottom-color: #000;
}
");

// by default use local countries.json if present
SDV($FlagTitlesUseLocal, is_file("$FarmD/pub/flagtitles/countries.json"));

$HTMLHeaderFmt['flagtitles'] = "
<script type=\"text/javascript\" src=\"\$PubDirUrl/flagtitles/flagtitles.js\"></script>

<script type=\"text/javascript\">
// <![CDATA[
document.addEventListener('DOMContentLoaded', () => {
  FlagTitles.localURL = '\$FarmPubDirUrl/flagtitles/countries.json';
  FlagTitles.localMode = '$FlagTitlesUseLocal';
  FlagTitles.process();
});
// ]]>
</script>
";

