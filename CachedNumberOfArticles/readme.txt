>>recipeinfo<<
Summary: Count pages in wiki
Version: 2021-10-25
Prerequisites:
Status: Stable
Maintainer: [[profiles/Anomen]]
Categories: [[!Includes]]
Users: {{$FullName}-Users$Rating2} ([[{$FullName}-Users|View]] / [[{$FullName}-Users?action=edit|Edit]])
Discussion: [[{$Name}-Talk]]
>><<

!!Description

This recipe reports number of articles in wiki.
Value is obtained from cache unless optional ''refresh'' argument is specified.

!! Usage

!!!Installation

Copy Attach:noa.php into your cookbook dir.

Add to '''local/config.php''':

[@
  require_once($FarmD . '/cookbook/noa.php');
@]

!!! Markup usage

* Use @@(:numberofarticles:)@@ to display number of articles.
* Use @@(:numberofarticles refresh:)@@ to update counter and display correct number of articles.

!! Notes
* Number of articles is cached in @@$WorkDir/.noa@@.
* Pages in wikilib.d (i.e. default articles in groups ''Site'' and ''PmWiki'') are excluded.
* This recipe should work with [[Cookbook/PerGroupSubDirectories]].

!! Comments
(:if false:)
This space is for User-contributed commentary and notes.
Please include your name and a date along with your comment.
Optional alternative:  create a new page with a name like "ThisRecipe-Talk" (e.g. PmCalendar-Talk).
(:if exists {$Name}-Talk:)See Discussion at [[{$Name}-Talk]](:if:)

[[#seealso]]
!! See Also

* [[Cookbook/NumberOfArticles]]

: git repository : https://github.com/anomen-s/pmwiki-recipes/tree/master/CachedNumberOfArticles

!! Contributors
* [[~Anomen]]

