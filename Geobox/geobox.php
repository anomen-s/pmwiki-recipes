<?php if (!defined('PmWiki')) exit();

/*
    This script adds support for gps coordinates conversion and displaying at maps
    - add (:geo [args] coords :) tag functionality

    Copyright 2006-2021 Anomen (ludek_h@seznam.cz)
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published
    by the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.
    
    TODO:
    * GPX export (see sourceblock for howto)
*/


$RecipeInfo['Geobox']['Version'] = '2025-04-18';

Markup('geo','fulltext','/\(:geo\s+((?:[dmsDMS,.]+:\s+)?(?:[a-z]+=\S+\s+)*)?(.*?)\s*:\)/si',
    "geobox_markup");

SDV($GeoBoxDefaultFormat,'dm');

SDVA($GeoBoxLinks, array(
 'maps.google.com'=>'https://maps.google.com/?q=$N%20$E',
 'mapy.cz'=>'https://mapy.cz/?source=coor&id=$E,$N',
 'geocaching.com/maps'=>'http://www.geocaching.com/map/default.aspx?lat=$N&lng=$E',
 'geohack'=>'https://geohack.toolforge.org/geohack.php?params=$Nd_$LAT_$Ed_$LON_type:landmark_dim:10'
));

SDVA($GeoBoxIcons, array(
 'maps.google.com'=>'gmaps.png',
 'mapy.cz'=>'mapy.cz.png',
 'geocaching.com/maps'=>'geocaching.png',
 'geohack'=>'wikimedia.png'
));

function geobox_markup($m) {
  return geobox_maps(strtolower($m[1]), $m[2]);
}

function geobox_asint($m, $index) 
{
  $res = 0;
  if (!empty($m[$index])) {
    $res = strtr($m[$index], ',', '.');
  }
  return $res;
}

function geobox_p()
{
    global $Charset;
    if (strtolower($Charset) == 'utf-8') {
        $pat[0] = '°|˚|º|\*';
        $pat[1] = '\'|’|′';
        $pat[2] = '\'\'|\"|“|″|”|’’|';
    } else {
        $pat[0] = chr(0xB0) . '|\*';
        $pat[1] = '\'';
        $pat[2] = '\'\'|\"|';
    }
    return $pat;
}
function geobox_parse_coords($coords)
{
    $pat = geobox_p();
    $p0 = $pat[0];
    $p1 = $pat[1];
    $p2 = $pat[2];
    $re_num = "\d+(?:[.,]\d*)?";
    $re_coord="
	    ([-+]?${re_num})
	    \s*
	    (?:$p0||
		(?:
		    (?:$p0)
		    \s*
		    (${re_num})
		    \s*
		    (?:$p1| |
			(?:
			    (?:$p1)
			    \s*
			    (${re_num})
			    \s*
			    (?:$p2)
			)
		    )
		)
	    )?";
    $regex_pre = "(N|S|)\s*(${re_coord})\s*;?\s*([,;]?\s*E|[,;]?\s*W|)\s*(${re_coord})";
    $regex_post = "()(${re_coord})\s*(N|S)\s*[,;]?\s*(${re_coord})\s*(E|W)";
    $m[] = array();
    if (preg_match("/^\s*${regex_pre}\s*\$/xi", $coords, $m)) {
	$res['result'] = 'PRE';
	$res['pattern'] = $regex_pre;
	if(strlen($m[6]) > 1) {
	  $m[6] = substr($m[6], -1);
	}
    }
    else if (preg_match("/^\s*${regex_post}\s*\$/xi", $coords, $m)) {
	$res['result'] = 'POST';
	$res['pattern'] = $regex_post;
	$m[1]=$m[6];$m[6]=$m[11]; // move directions
    } 
    else  {
	$res['result'] = "";
    }    
    
    if (isset($m)) {
        $res[0] = abs(geobox_asint($m, 3)) + geobox_asint($m, 4)/60 + geobox_asint($m, 5)/(60*60);
        $res[1] = abs(geobox_asint($m, 8)) + geobox_asint($m, 9)/60 + geobox_asint($m, 10)/(60*60);

        if (geobox_asint($m, 3) < 0) { $res[0] = -$res[0]; }
        if (geobox_asint($m, 8) < 0) { $res[1] = -$res[1]; }

        if (strtoupper($m[1]) == 'S') { $res[0] = -$res[0]; }
        if (strtoupper($m[6]) == 'W') { $res[1] = -$res[1]; }
    }
        
    return $res;
}

function geobox_floor0($foo) 
{
    if($foo > 0) { return floor($foo); }
    else { return ceil($foo); }
}

function geobox_sign($foo) 
{
    return ($foo < 0) ? "-" : "";
}

function geobox_atan2($y, $x)
{
    if ($y == 0) {
      return ($x >= 0) ? 0 : pi();
    }
    return 2 * atan((sqrt($x*$x+$y*$y)-$x)/$y);
}
    


function geobox_convert_coords($c)
{
    $c['LAT'] = ($c[0] >= 0) ? "N" : "S";
    $c['LON'] = ($c[1] >= 0) ? "E" : "W";
    
    $c['NSig'] = geobox_sign($c[0]);
    $c['ESig'] = geobox_sign($c[1]);

    $c['N'] = sprintf("%'08.5f",$c[0]);
    $c['E'] = sprintf("%'08.5f",$c[1]);
    $c['W'] = sprintf("%'08.5f",-$c[1]);
    $c['S'] = sprintf("%'08.5f",-$c[0]);
    $c['Nd'] = sprintf("%'08.5f",abs($c[0]));
    $c['Ed'] = sprintf("%'08.5f",abs($c[1]));

    // convert to [Ndi]°[Nmi]'[Ns]" and  [Ndi]°[Nm]'
    $c['Ndi'] = sprintf("%'02.0f",floor($c['Nd']));
    $c['Ni']  = $c['NSig'] . $c['Ndi'];
    $c['Nm']  = sprintf("%'06.3f",($c['Nd']-$c['Ndi'])*60);
    $c['Nmi'] = sprintf("%'02.0f",floor($c['Nm']));
    $s = ($c['Nd']*60);
    $c['Ns']  = sprintf("%'06.3f",($s-floor($s))*60);
    $c['Nsi'] = sprintf("%'02.0f",floor($c['Ns']));

    $c['Edi'] = sprintf("%'03.0f",floor($c['Ed']));
    $c['Ei']  = $c['ESig'] . $c['Edi'];
    $c['Em']  = sprintf("%'06.3f",($c['Ed']-$c['Edi'])*60);
    $c['Emi'] = sprintf("%'02.0f",floor($c['Em']));
    $s = ($c['Ed']*60);
    $c['Es']  = sprintf("%'06.3f",($s-floor($s))*60);
    $c['Esi'] = sprintf("%'02.0f",floor($c['Es']));
   
    return $c;
}

/*
 * Parses parameters and returns them in array.
 * 
 * If parameter is specified by uniquely distinguishable substring of known
 * parameter (e.g.: dist=10), 
 * full parameter value is also returned (e.g.: distance=10).  
 */ 
function geobox_parse_params($param)
{
  $known_params = array('format', 'azimuth', 'distance');
  
  $params = array('param' => $param);
  
  $pairs = preg_split("/\s+/", $param, -1, PREG_SPLIT_NO_EMPTY);
  foreach ($pairs as $p) {
    $tokens=explode('=', $p);
    if (strpos($tokens[0],":") !== false) {
        $params['format'] = $tokens[0];
    } else {
      $params[$tokens[0]] = $tokens[1];
      foreach ($known_params as $k) {
        if (strpos($k, $tokens[0]) === 0) {
          $params[$k] = $tokens[1];
        } 
      }
    }   
  }
  
  return $params;
}

function geobox_build_link($link, $c)
{
  return preg_replace_callback(
        '/\\$([A-Za-z]+)/',
        function($m) use ($c) { return $c[$m[1]]; },
        $link);
}

function geobox_maps($param, $coords_param)
{
    global $GeoBoxDefaultFormat, $GeoBoxLinks, $GeoBoxIcons, $FarmPubDirUrl;

    $c = geobox_parse_coords($coords_param);
    
    if (empty($c['result'])) {
        return "[Invalid \"$coords_param\"]";
    }
    
    $params = geobox_parse_params($param);
    $cformat = $params['format'] ?? null;
    
    if (!empty($params['azimuth']) || !empty($params['distance'])) {
        if (is_numeric($params['azimuth']) && is_numeric($params['distance'])) {
            $c = geobox_projection($c[0], $c[1], $params['azimuth'], $params['distance']);
        } else {
            return "[Invalid azimuth \"${params['azimuth']}\" or distance \"${params['distance']}\"]";
        }
    }
    $c = geobox_convert_coords($c);

	if (empty($cformat)) { 
		$cformat = $GeoBoxDefaultFormat;
	}
	if (strpos($cformat, "s") !== false) {
		$COORDS=geobox_build_link('$NSig$Ndi&#176;$Nmi\'$Ns" $ESig$Edi&#176;$Emi\'$Es"', $c);// DMS
	}
	else if (strpos($cformat, "m") !== false) {
		$COORDS=geobox_build_link('$NSig$Ndi&#176;$Nm\' $ESig$Edi&#176;$Em\'', $c);// DM
	}
	else if (strpos($cformat, "g") !== false) {
		$COORDS=geobox_build_link('$LAT $Ndi&#176;$Nm $LON $Edi&#176;$Em', $c);// Geocaching / geocheck
	}
	else {
		$COORDS=geobox_build_link('$NSig$Nd&#176; $ESig$Ed&#176;', $c);//
	}

  $result = "$COORDS";

  if (is_array($GeoBoxLinks) && !empty($GeoBoxLinks)) {
    $result .= " - ";
    foreach ($GeoBoxLinks as $t=>$l) {
      $lnk = geobox_build_link(htmlspecialchars($l), $c);
      if (isset($GeoBoxIcons[$t])) {
        $result .= Keep(" <a href=\"$lnk\" target=\"_blank\"><img title=\"$t\" style=\"height:1.2em;vertical-align:middle\" src=\"$FarmPubDirUrl/geobox/${GeoBoxIcons[$t]}\" /></a>");
      } else {
        $result .= " [[$lnk | $t]]";
      }
    }
  }
  
  return $result;
}

/**
 *  Calculates coordinates of point given by starting coordinates, azimuth and distance (meters).
 *  All angles are in degrees.  
 */ 
function geobox_projection($latitude_deg, $longtitude_deg, $azimuth_deg, $distance) {

    //source: geocaching_tool2.xls
    $ro =  pi() / 180.0;
    $R = 1.0/6378000;
    $DR = $distance*$R;
    $azimuth = $azimuth_deg*$ro;
    $latitude = $latitude_deg*$ro;
    
    $fi2 = sin($latitude)*cos($DR)+cos($latitude)*sin($DR)*cos($azimuth);
    //echo "fi2=$fi2";
    $lat = asin($fi2);
    //echo "lat=$lat";
    
    $x = (cos($DR)-sin($latitude)*sin($lat))/(cos($latitude)*cos($lat));
    //echo "x=$x";
    $y = sin($DR)*sin($azimuth)/cos($lat);
    //echo "y=$y";
    $la2 = geobox_atan2($y, $x);
    //echo "la2=$la2";
    $lon = $longtitude_deg + $la2/$ro;
    //echo "lon=$lon";
          
    $ret = array();
    $ret[0] = $lat / $ro;
    $ret[1] = $lon;
    return $ret;
}

