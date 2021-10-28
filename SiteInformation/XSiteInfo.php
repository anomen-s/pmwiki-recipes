<?php if (!defined('PmWiki')) exit();

//
// Copyright (C) Julian I. Kamil <julian.kamil@gmail.com>
// No warranty is provided.  Use at your own risk.
//
// Commercial support is available through ESV Media Group
// who can be reached at: http://www.ESV-i.com/.
//
// Name: XSiteInfo.php
// Author: Julian I. Kamil <julian.kamil@gmail.com>
// Created: 2005-10-03
// Description:
//     This is a plugin that displays site information.
//     Please see:
//         http://www.madhckr.com/project/PmWiki/XSiteInfo
//     for a live example and doumentation.
//
// $Id: XSiteInfo.php,v 1.1 2005/10/04 02:38:32 julian Exp $
//
// History:
//     2005-10-03	jik	Created.
//     2006-06-05	Steve	Wiki Version
//     2011-12-02	anomen	recipeinfo, html code
//     2021-10-28	anomen	PHP 8 compatibility
//

$RecipeInfo['XSiteInfo']['Version'] = "2021-10-28";

Markup('siteinfo', 'inline', '/\\(:siteinfo\\s*(.*?):\\)/', "mu_siteinfo");

function mu_siteinfo($m) {
  extract($GLOBALS['MarkupToHTML']);
  return Keep(XSiteInfoDisplay($pagename),'');
}

function XSiteInfoDisplay($pagename) {
    global $Version, $WikiTitle, $FarmD, $WikiDir, $ScriptUrl, $PubDirUrl,
	$UploadUrlFmt, $EnableUpload, $UploadMaxSize,
	$EnablePost, $EnablePathInfo, $SpaceWikiWords, $LinkWikiWords, $EnableDiag, 
	$Author, $AuthId, $Skin, $SkinVersion,
	$EnableStdConfig, $EnablePGCust, $EnableAuthorTracking, $EnableSimulEdit, $EnablePrefs, 
	$EnableSkinLayout, $EnableTransitions, $EnableStdMarkup, $EnableWikiTrails, $EnableStdWikiStyles, 
	$EnableMailPosts, $EnablePageList, $EnableVarMarkup, $EnableGUIButtons, $EnableForms;

    $flags = array(
	'EnableUpload', 'EnablePost', 'EnablePathInfo', 'EnableDiag', 
	'EnableStdConfig', 'EnablePGCust', 'EnableAuthorTracking', 'EnableSimulEdit', 'EnablePrefs', 
	'EnableSkinLayout', 'EnableTransitions', 'EnableStdMarkup', 'EnableWikiTrails', 'EnableStdWikiStyles', 
	'EnableMailPosts', 'EnablePageList', 'EnableVarMarkup', 'EnableGUIButtons', 'EnableForms'
	);

    foreach ($flags as $flag) if (empty(${$flag})) ${$flag} = FALSE;

    $boolean_code = array( 
	0 => '<input type="radio" disabled="disabled" /> Enabled <input type="radio" checked="checked" disabled="disabled" /> Disabled', 
	1 => '<input type="radio" checked="checked" disabled="disabled" /> Enabled <input type="radio" disabled="disabled" /> Disabled' 
	);

    $output = "
<table class='site-info'>
    <tr class='even'><th>          Wiki Version:</th><td>{$Version}</td></tr>
    <tr class='odd' ><th>            Wiki title:</th><td>{$WikiTitle}</td></tr>
    <tr class='even'><th>     Current directory:</th><td>".getcwd()."</td></tr>
    <tr class='odd' ><th>        Farm directory:</th><td>{$FarmD}</td></tr>
    <tr class='even'><th>        Wiki directory:</th><td>{$WikiDir->dirfmt}</td></tr>
    <tr class='odd' ><th>          Default skin:</th><td>{$Skin} {$SkinVersion}</td></tr>
    <tr class='even'><th>        Editing author:</th><td>{$Author}</td></tr>
    <tr class='odd' ><th>      Authenticated ID:</th><td>{$AuthId}</td></tr>
    <tr class='even'><th>  Public directory URL:</th><td>{$PubDirUrl}</td></tr>
    <tr class='odd' ><th>            Script URL:</th><td>{$ScriptUrl}</td></tr>
    <tr class='even'><th>            Upload URL:</th><td>{$UploadUrlFmt}</td></tr>
    <tr class='odd' ><th>   Maximum upload size:</th><td>{$UploadMaxSize} bytes</td></tr>
    <tr class='even'><th>                Upload:</th><td>{$boolean_code[$EnableUpload]}</td></tr>
    <tr class='odd' ><th>                  Post:</th><td>{$boolean_code[$EnablePost]}</td></tr>
    <tr class='even'><th>             Path info:</th><td>{$boolean_code[$EnablePathInfo]}</td></tr>
    <tr class='odd' ><th>       Link Wiki words:</th><td>{$boolean_code[$LinkWikiWords]}</td></tr>
    <tr class='even'><th>      Space Wiki words:</th><td>{$boolean_code[$SpaceWikiWords]}</td></tr>
    <tr class='odd' ><th>Standard configuration:</th><td>{$boolean_code[$EnableStdConfig]}</td></tr>
    <tr class='even'><th> Custom group and page:</th><td>{$boolean_code[$EnablePGCust]}</td></tr>
    <tr class='odd' ><th>       Author tracking:</th><td>{$boolean_code[$EnableAuthorTracking]}</td></tr>
    <tr class='even'><th>  Simultaneous editing:</th><td>{$boolean_code[$EnableSimulEdit]}</td></tr>
    <tr class='odd' ><th>           Preferences:</th><td>{$boolean_code[$EnablePrefs]}</td></tr>
    <tr class='even'><th>           Skin layout:</th><td>{$boolean_code[$EnableSkinLayout]}</td></tr>
    <tr class='odd' ><th>           Transitions:</th><td>{$boolean_code[$EnableTransitions]}</td></tr>
    <tr class='even'><th>       Standard markup:</th><td>{$boolean_code[$EnableStdMarkup]}</td></tr>
    <tr class='odd' ><th>           Wiki trails:</th><td>{$boolean_code[$EnableWikiTrails]}</td></tr>
    <tr class='even'><th>  Standard Wiki styles:</th><td>{$boolean_code[$EnableStdWikiStyles]}</td></tr>
    <tr class='odd' ><th>            Mail posts:</th><td>{$boolean_code[$EnableMailPosts]}</td></tr>
    <tr class='even'><th>             Page list:</th><td>{$boolean_code[$EnablePageList]}</td></tr>
    <tr class='odd' ><th>       Variable markup:</th><td>{$boolean_code[$EnableVarMarkup]}</td></tr>
    <tr class='even'><th>           GUI buttons:</th><td>{$boolean_code[$EnableGUIButtons]}</td></tr>
    <tr class='odd' ><th>                 Forms:</th><td>{$boolean_code[$EnableForms]}</td></tr>
    <tr class='even'><th>           Diagnostics:</th><td>{$boolean_code[$EnableDiag]}</td></tr>
</table>
";

    return $output;
}

// Style.

$HTMLStylesFmt['site-info'] = "
table.site-info { border: 1px solid #ccc; }
table.site-info tr th { font-weight: normal; text-align: right; border: 1px none #ccc; padding: 4px; color: #222; }
table.site-info tr td { border: 1px none #ccc; padding: 4px 8px 4px 8px; }
table.site-info tr.odd { background-color: #eee; }
";

