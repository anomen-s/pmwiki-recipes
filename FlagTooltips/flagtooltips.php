<?php if (!defined('PmWiki')) exit();
/*
    FlagTooltips

    Copyright 2025 Anomen (ludek_h@seznam.cz)
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published
    by the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.
*/

$RecipeInfo['FlagTooltips']['Version'] = '2025-12-09';


SDV($HTMLStylesFmt['flagtooltips'], "
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
SDV($FlagTooltipsUseLocal, is_file("$FarmD/pub/flagtooltips/countries.json"));

$HTMLHeaderFmt['flagtooltips'] = "
<script type=\"text/javascript\" src=\"\$PubDirUrl/flagtooltips/flagtooltips.js\"></script>

<script type=\"text/javascript\">
// <![CDATA[
document.addEventListener('DOMContentLoaded', async (event) => {
  FlagTooltips.localURL = '\$FarmPubDirUrl/flagtooltips/countries.json';
  FlagTooltips.localMode = '$FlagTooltipsUseLocal';
  FlagTooltips.doProcess();
});
// ]]>
</script>
";

