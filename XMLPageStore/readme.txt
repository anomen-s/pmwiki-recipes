>>recipeinfo<<
Summary: Store pages as XML files
Version: 2021-10-28
Prerequisites: Requires at least PmWiki version: 2.2.0; last tested on PmWiki version: 2.2.134
Status: 
Maintainer:  [[~Anomen]]
Categories: [[!Administration]], [[!CustomPageStore]]
Users: {{$FullName}-Users$Rating2} ([[{$FullName}-Users|View]] / [[{$FullName}-Users?action=edit|Edit]])
Discussion: [[{$Name}-Talk]]
>><<
!! Questions answered by this recipe
Store pages as XML.

Advantages:
* pages easily editable in plain text editor
* better handled by versioning systems (text is no longer single long line)
* export/import pages using various tools with XML support

[[#desc]]
!! Description
The Attach:XMLPageStore.php script stores pmwiki pages into xml files in the ''wiki.d/'' directory.

[[#install]]
!! Installation
To use this script, simply place it in your ''cookbook'' directory
and add the following lines to ''local/config.php'':

[@
  $EnablePageStoreXML = 1;
  include_once("$FarmD/cookbook/XMLPageStore.php");
  $WikiDir = new XMLPageStore('wiki.d/{$FullName}');
@]

There's no need to convert or modify your existing pages;
''xmlpagestore.php'' can read existing  pages without any difficulty.
As pages are edited and saved, they will be then saved as XML files in ''wiki.d/''.
Please make sure the above cookbook script is loaded before other scripts.

If you want to convert all of your files at once append the following line to local/config.php:
[@
    ConvertXML();
@]


[[#config]]
!! Configuration
Use @@$EnablePageStoreXML@@ variable to enable/disable writing xml files.

[[#usage]]
!! Usage

[[#notes]]
!! Notes

[[#relnotes]]
!! Change log / Release notes
* 2011-04-22 - added to PmWiki Cookbook
* 2011-09-15 - minor fixes
* 2012-12-27 - added support for converting all pages
* 2021-10-27 - fix compatibility with PHP 8

[[#seealso]]
!! See also
: git repo : https://github.com/anomen-s/pmwiki-recipes/tree/master/XMLPageStore

[[#contributors]]
!! Contributors
* [[~Anomen]] - original script

[[#comments]]
!! Comments
See discussion at [[{$Name}-Talk]]

[[#faq]]
>>faq display=none<<

Q:
A:
