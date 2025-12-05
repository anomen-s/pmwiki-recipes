>>recipeinfo<<
Summary: Create QR code.
Version: 2021-10-25
Prerequisites:
Status:
Maintainer: [[~Anomen]]
License: LGPL
Users: {$Users} ([[{$FullName}-Users|view]] / [[{$FullName}-Users?action=edit|edit]])
Categories: [[!Images]]
Discussion: [[{$Group}/{$Name}-Talk]]
>><<
!! Questions answered by this recipe
How to generate QR code.

[[#desc]]
!! Description
Recipe creates embedded image with QR code for given text.

[[#install]]
!!Installation
Download [[(Attach:)qrcode.php]] and [[(Attach:)phpqrcode.php]] lib.
Store them in cookbook/ and cookbook/phpqrcode/ respectively.

In config.php, add the following line:

[@
 include_once("$FarmD/cookbook/qrcode.php");
@]

You need GD Graphics Library. In Ubuntu it's package php-gd. Install using command:
 
 sudo apt install php-gd

In Gentoo you need dev-lang/php with gd USE-flag.

[[#config]]
!! Configuration
[@
 $QR_ECLEVEL=1; // error correction level (0..3, default 1)
@]

[[#usage]]
!!Usage
Use qr markup
[@
 (:qr some 'text' here :)

 (:qr sms:(049)012-345-678 :)

 (:qr geo:49.4536,14.34552 :)
 
@]


[[#relnotes]]
!! Change log / Release notes
* 2020-12-15 - initial release
* 2021-10-25 - update for PHP 8
* 2025-12-01 - fixed regexp to handle spaces and multi-line texts

[[#seealso]]
!! See also
: git repository : https://github.com/anomen-s/pmwiki-recipes/tree/master/QRCode

* http://phpqrcode.sourceforge.net/

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
