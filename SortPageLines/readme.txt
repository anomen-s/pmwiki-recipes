>>recipeinfo<<
Summary: Alphabetically sort lines in page.
Version: 2023-07-20
Prerequisites:
Status: 
Maintainer: [[~Anomen]]
Users: {{$FullName}-Users$Rating2} ([[{$FullName}-Users|View]] / [[{$FullName}-Users?action=edit|Edit]])
Categories: [[Links]]
Discussion: [[{$Name}-Talk]]
>><<
!! Questions answered by this recipe
How to alphabetically sort lines in page.

[[#desc]]
!! Description
Recipe adds two GUI buttons in edit form which allow user to alphabetically sort lines in page 
(either in descending or ascending order).

Duplicate and empty lines are removed.


[[#install]]
!!Installation
Download [[(Attach:)sortpagelines.php]].

In config.php, add the following line:

[@
 include_once("$FarmD/cookbook/sortpagelines.php");
@]

Put [[(Attach:)sort_asc.png]] and [[(Attach:)sort_desc.png]] to [@pub/guiedit@].

[[#usage]]
!!Usage

[[#config]]
!!Configuration
No configuration available.

[[#relnotes]]
!! Change log / Release notes
* 2011-08-24 - initial version

[[#seealso]]
!! See also
: git repo : https://github.com/anomen-s/pmwiki-recipes/tree/master/SortPageLines

[[#todo]]
!!ToDos
* replace buttons with icons

[[#contributors]]
!! Contributors
* [[~Anomen]] (original author)
  
[[#comments]]
!! Comments
See discussion at [[{$Name}-Talk]]
