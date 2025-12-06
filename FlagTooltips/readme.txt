>>recipeinfo<<
Summary: Show tool tips for flags in page.
Version: 2025-12-05
Prerequisites:
Status:
Maintainer: [[~Anomen]]
License: LGPL
Categories: [[!Markup]]
Users: {$Users} ([[{$FullName}-Users|view]] / [[{$FullName}-Users?action=edit|edit]])
Discussion: [[{$Group}/{$Name}-Talk]]
>><<
!! Questions answered by this recipe
It's possible to insert unicode characters which will make up flag of a given country.
This recipe shows tooltip with name of country.

[[#desc]]
!! Description
Recipe adds tooltip on all flags found in page text.

[[#install]]
!!Installation
Download [[(Attach:)flagtooltips.zip]].

You can also download up-to-date county list [[https://restcountries.com/v3.1/all?fields=name,cca2,idd]].
and store it as @@pub/flagtooltips/countries.json@@.

In config.php, add the following line:

[@
 include_once("$FarmD/cookbook/flagtooltips.php");
@]


[[#config]]
!! Configuration
[@
 $FlagTooltipsUseLocal = false; // You can force downloading of country list from restcountries.com each time.
@]

[[#usage]]
!!Usage

Automatic, just insert flags into the text.
You can use [[https://emojipedia.org/]] or similar service.

Example:
-> Attach:flagtooltips-screenshot.png"Example"


[[#todo]]
!! To do / some day / maybe
* load countrylist.json only if any flag is found on the page
* automatically fetch countrylist and cache it in wiki.d

[[#relnotes]]
!! Change log / Release notes
* 2025-12-05 - initial release

[[#seealso]]
!! See also
: git repository : https://github.com/anomen-s/pmwiki-recipes/tree/master/FlagTooltips
* https://restcountries.com/

[[#contributors]]
!! Contributors
* [[~Anomen]] (original author)
  
[[#comments]]
!! Comments
See discussion at [[{$Group}/{$Name}-Talk]]

[[#faq]]
>>faq display=none<<

Q:
A:
