<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>

<p>
List of patterns which are quaranteed to work in all versions of geobox.
</p>

<?php

function Markup($a=0, $b=0, $c=0, $d=0)
{
 return ""; // dummy

}
function SDV(&$v,$x) { if (!isset($v)) $v=$x; }
function SDVA(&$v,$x) { /*required for link list, not used here */ }

$Charset = "UTF-8";

define("PmWiki", "1");
include("geobox.php");

$c[] = "N50 E14";					$r[] = "50,14,PRE";
$c[] = "50° 14°";					$r[] = "50,14,PRE";
$c[] = "50° N 14° E";					$r[] = "50,14,POST";
$c[] = "N 50° E 14°";					$r[] = "50,14,PRE";
$c[] = "S 50° W 14°";					$r[] = "-50,-14,PRE";
$c[] = "50.0 14.0";					$r[] = "50,14,PRE";
$c[] = "50.230° 14.440°";				$r[] = "50.23,14.44,PRE";
$c[] = "50°35.440 14°22.890";				$r[] = "50.5906+7,14.3815,PRE";
$c[] = "50°35.4' 14°22'";				$r[] = "50.59,14.36+7,PRE";
$c[] = "50.3°35.4'44\" 14.1°22'22\"";			$r[] = "50.902+,14.4727+8,PRE";
$c[] = "N 50.3°35.4'44'' E14.1°22'22''";		$r[] = "50.902+,14.4727+8,PRE";
$c[] = " 50.3°35.4'44''N 14.1°22'22''W";		$r[] = "50.902+,-14.4727+8,POST";

foreach($c as $coord) 
{
 $res = geobox_parse_coords($coord);
 $resstr = "${res[0]},${res[1]},${res['result']}";
 echo "<div>Str: \"$coord\" ->  [$resstr] </div>\n";
 $rx =  array_shift($r);
 if (!preg_match ("/^$rx\$/", $resstr)) {
   echo "ERROR: not match to: $rx\n";
 }
}

?>
</body>
</html>
