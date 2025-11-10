>>recipeinfo<<
Summary: Show tool tips for flags in page.
Version: 2025-11-09
Prerequisites:
Status:
Maintainer: [[~Anomen]]
License: LGPL
Users: {$Users} ([[{$FullName}-Users|view]] / [[{$FullName}-Users?action=edit|edit]])
Categories: [[Includes]]
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
Download [[(Attach:)flagtitles.php]] and [[(Attach:)flagtitles.js]].

Then download [[https://restcountries.com/v3.1/all?fields=name,cca2,idd]]
as @@countries.json@@.

Store PHP file in @@cookbook/@@ and the rest in @@pub/flagtitles/@@.

In config.php, add the following line:

[@
 include_once("$FarmD/cookbook/flagtitles.php");
@]


[[#config]]
!! Configuration
[@
 $FlagTitlesUseLocal = false; // You can force downloading of country list from restcountries.com each time.
@]

[[#usage]]
!!Usage

Automatic, just insert flags into the text.
You can use [[https://emojipedia.org/]] or similar service.
[@
I have visited 🇩🇪 and 🇵🇱.
@]


[[#relnotes]]
!! Change log / Release notes
* 2025-11-09 - initial release

!!ToDos
* load countrylist.json only if any flag is found
* fetch countrylist and cache it in wiki.d

[[#seealso]]
!! See also
: git repository : https://github.com/anomen-s/pmwiki-recipes/tree/master/QRCode
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
