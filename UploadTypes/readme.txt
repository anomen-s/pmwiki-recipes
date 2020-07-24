>>recipeinfo<<
Summary: Add common mime-types.
Version: 2020-07-25
Prerequisites: 
Status: 
Maintainer: [[~Anomen]]
Users: {{$FullName}-Users$Rating2} ([[{$FullName}-Users|View]] / [[{$FullName}-Users?action=edit|Edit]])
Categories: [[Uploads]]
Discussion: [[{$Name}-Talk]]
>><<
!! Questions answered by this recipe
How to allow uploads of various common file types.

[[#desc]]
!! Description
Recipe specifies common file types.

[[#install]]
!!Installation
Download [[(Attach:)uploadtypes.php]].

In config.php, add the following line:

[@
 include_once("$FarmD/cookbook/uploadtypes.php");
@]


[[#seealso]]
!! See also
: git repository : https://github.com/anomen-s/pmwiki-recipes/tree/master/UploadTypes

[[#contributors]]
!! Contributors
* [[~Anomen]] (original author)
  
[[#comments]]
!! Comments
See discussion at [[{$Name}-Talk]].

