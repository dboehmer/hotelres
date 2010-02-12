<?php
/*
 *      www/include/config.inc
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


/*
 * this file contains ONLY configuration variables which indeed
 * ARE INDIVIDUAL FOR ANY SINGLE CUSTOMER
 */

// set $DEBUG=true for debugging mode:
$DEBUG=false;

// credentials for MySQL access
$MYSQL_SERVER="localhost";
$MYSQL_USERNAME="hotelres";
$MYSQL_PASSWORD="hotelres";
$MYSQL_DATABASE="hotelres";

// name of the accomodation and 1st-level headline
$HOTEL_NAME="Burj Al Arab";

// default language for visitors
$LANGUAGE="de";

// maximum time between two requests for keep being
// logged in (in secs); zero indicates no timeout
$MAX_IDLE_TIME=3600;

?>
