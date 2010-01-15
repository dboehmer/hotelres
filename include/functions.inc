<?php
/*
 *      include/functions.inc
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


?>
