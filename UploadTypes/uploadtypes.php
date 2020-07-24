<?php if (!defined('PmWiki')) exit();
/*
    This script adds common file types.

    Sources
    * /etc/mime.types
    * https://www.iana.org/assignments/media-types/media-types.xhtml
    * Wikipedia

    Copyright 2020 Anomen (ludek_h@seznam.cz)
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published
    by the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.
*/

$RecipeInfo['UploadTypes']['Version'] = '2020-07-25';

// wrong
$UploadExts['psd'] = 'image/vnd.adobe.photoshop';
$UploadExts['mdb'] = 'application/vnd.ms-access';

SDVA($UploadExts, array(

// archives
'bz2' => 'application/x-bzip2',
'rar' => 'application/x-rar-compressed',
'xz' => 'application/x-xz',
'iso' => 'application/x-iso9660-image',
'wad' => 'application/octet-stream',

// web...
'xml' => 'text/xml',
'gpx' => 'application/gpx+xml',
'der' => 'application/x-x509-ca-cert',
'pfx' => 'application/x-pkcs12',
'pem' => 'text/plain',
'opml' => 'text/x-opml',
'eml' => 'message/rfc822',
'pgp' => 'application/pgp-keys',
'gpg' => 'application/pgp-keys',
'csv' => 'text/csv',

// images
'dxf' => 'image/vnd.dxf',
'tga' => 'image/x-targa',
'pcx' => 'image/vnd.zbrush.pcx',

// audio
'mid' => 'audio/midi',

// office
'odb' => 'application/vnd.oasis.opendocument.database',
'ots' => 'application/vnd.oasis.opendocument.spreadsheet-template',
'odi' => 'application/vnd.oasis.opendocument.image',
'odc' => 'application/vnd.oasis.opendocument.chart',
'otg' => 'application/vnd.oasis.opendocument.graphics-template',
'otp' => 'application/vnd.oasis.opendocument.presentation-template',
'odf' => 'application/vnd.oasis.opendocument.formula',
'ott' => 'application/vnd.oasis.opendocument.text-template',
'oth' => 'application/vnd.oasis.opendocument.text-web',
'odm' => 'application/vnd.oasis.opendocument.text-master',

'docm' => 'application/vnd.ms-word.document.macroEnabled.12',
'dotm' => 'application/vnd.ms-word.template.macroEnabled.12',
'dotx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
'potm' => 'application/vnd.ms-powerpoint.template.macroEnabled.12',
'potx' => 'application/vnd.openxmlformats-officedocument.presentationml.template',
'ppsx' => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
'pptm' => 'application/vnd.ms-powerpoint.presentation.macroEnabled.12',
'sldx' => 'application/vnd.openxmlformats-officedocument.presentationml.slide',
'xlsb' => 'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
'xlsm' => 'application/vnd.ms-excel.sheet.macroEnabled.12',
'xltm' => 'application/vnd.ms-excel.template.macroEnabled.12',
'xltx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',

'dot' => 'application/msword',
'vsd' => 'application/vnd.visio',
'vst' => 'application/vnd.visio',
'mpp' => 'application/msproject',
'msg' => 'application/msoutlook',
'pps' => 'application/mspowerpoint',

// system
'policy' => 'text/plain',
'properties' => 'text/plain',
'sql' => 'text/plain',
'wsdl' => 'text/xml',
'reg' => 'text/plain',
'conf' => 'text/plain',
'cfg' => 'text/plain',
'ppk' => 'text/plain',
'klc' => 'application/octet-stream',

));
