#!/bin/sh

TMPD=`mktemp -d`
DEST=`pwd`

##################################
echo AesCrypt ...

VERSION=2021-10-25
TMP=$TMPD/aescrypt
mkdir -p "$TMP/cookbook"  "$TMP/pub/aescrypt" "$TMP/pub/guiedit"
cp AesCrypt/aescrypt.php "$TMP/cookbook"
cp AesCrypt/*.js AesCrypt/*.txt AesCrypt/close.png AesCrypt/maskbg.png AesCrypt/showpass.png "$TMP/pub/aescrypt"
cp AesCrypt/aescrypt.png "$TMP/pub/guiedit"

tar -c -v -z -f aescrypt-$VERSION.tgz -C  "$TMP/" cookbook pub

( cd  "$TMP/" ; zip -v -9 -r "$DEST/aescrypt-$VERSION.zip" cookbook pub )


##################################
echo Geobox ...

VERSION=2024-08-30
TMP=$TMPD/geobox
mkdir -p "$TMP/cookbook"  "$TMP/pub/geobox"
cp Geobox/geobox.php "$TMP/cookbook"
cp Geobox/icons/*.png "$TMP/pub/geobox"

tar -c -v -z -f geobox-$VERSION.tgz -C  "$TMP/" cookbook pub

( cd  "$TMP/" ; zip -v -9 -r "$DEST/geobox-$VERSION.zip" cookbook pub )

##################################
echo CachedNumberOfArticles ...

VERSION=2021-10-25
TMP=$TMPD/cachednumberofarticles
mkdir -p "$TMP/cookbook"  "$TMP/wikilib.d"
cp CachedNumberOfArticles/noa.php "$TMP/cookbook"
cp CachedNumberOfArticles/Site.NumberOfArticles "$TMP/wikilib.d"

tar -c -v -z -f noa-$VERSION.tgz -C  "$TMP/" cookbook wikilib.d

( cd  "$TMP/" ; zip -v -9 -r "$DEST/noa-$VERSION.zip" cookbook wikilib.d )

##################################
echo FileList ...

VERSION=2021-10-26
TMP=$TMPD/filelist
mkdir -p "$TMP/cookbook" "$TMP/pub/images"
cp FileList/filelist.php "$TMP/cookbook"
cp FileList/dot3.png "$TMP/pub/images"

tar -c -v -z -f filelist-$VERSION.tgz -C  "$TMP/" cookbook pub

( cd  "$TMP/" ; zip -v -9 -r "$DEST/filelist-$VERSION.zip" cookbook pub )
