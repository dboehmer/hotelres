<?php
/*
 *      www/include/functions.inc
 *      
 *      Copyright 2010 Daniel Böhmer <daniel.boehmer@it2007.ba-leipzig.de> and
 *                     Patrick Nicolaus <patrick.nicolaus@it2007.ba-leipzig.de>
 *      
 *      This file is part of Hotelres.
 * 
 *      Hotelres is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 2 of the License, or
 *      (at your option) any later version.
 *      
 *      Hotelres is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *      
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 */


function url_add_parameter($url, $parameter, $value)
	{
		// Pick the correct separator to use
		$separator = "?";
		if (strpos($url,"?")!==false)
		  $separator = "&";
		 
		// Find the location for the new parameter
		$insertPosition = strlen($url); 
		if (strpos($url,"#")!==false)
		  $insertPosition = strpos($url,"#");
		 
		// Build the new url
		$newUrl = substr_replace($url,"$separator$parameter=$value",$insertPosition,0);
		
		return($newUrl);
	}

function getInformationURL($id, $security_token) {
    return $GLOBALS['URL_PATH_EXTERNAL'] . "/guestinfo.php?id=$id&token=$security_token";
}

function array2htmlColor(array $rgb)
    {
        for ($i=0; $i<3; $i++)
            {
                $hex=dechex($rgb[$i]);
                
                if (strlen($hex)==1)
                    $hex = "0".$hex;
                
                $code .= $hex;
            }
        
        return "#".$code;
    }

function ints2htmlColor($r, $g, $b)
    {
        return array2htmlColor(array($r, $g, $b));
    }

function avgColor(array $rgb1, array $rgb2)
    {
        for ($i=0; $i<3; $i++)
            {
                $avg[$i] = round(($rgb1[$i] + $rgb2[$i]) / 2);
            }
        return $avg;
    }

function createSalt()
    {
        // create random string as combination of current timestamp and RNG value
        return sha1(mktime() . mt_rand());
    }
	
function own_date_format($format, $value, $add)
	{
		return strftime($format ,strtotime($value)+$add);
	}
	
function check_date($value)
	{
		$array_date = explode(".",$value);	
		return checkdate($array_date[1],$array_date[0],$array_date[2]);
	}
	
function db_room_engaged($begin, $end, $roomid)
	{
		$newRoomEngaged = good_query('SELECT room FROM bookings WHERE begin<="'.$begin.'" AND end>="'.$end.'" AND room="'.$roomid.'"');
			
		return good_num(&$newRoomEngaged);
	}
	
function db_count_engaged_rooms($begin, $end)
	{
		$newCountRooms = good_query('SELECT a.room, b.id, b.name FROM bookings as a inner join rooms as b on a.room = b.id WHERE begin<="'.$begin.'" AND end>="'.$end.'" GROUP BY b.name');
			
		return good_num(&$newCountRooms);
	}
	
function db_count_all_rooms()
	{
		$newCountAll = good_query('SELECT name FROM rooms');
		
		return good_num(&$newCountAll);
	}
?>
