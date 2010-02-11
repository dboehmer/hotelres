<?php
/*
 *      include/consts.inc
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
 * this file contains ONLY constant information which is
 * NOT INDIVIDUAL FOR DIFFERENT CUSTOMERS
 */

// language used for text pattern in the code
// (goal: port all of them to English one day)
$BUILTIN_LANGUAGE="Deutsch";


// list of languages we support with "name"=>array("locale1",...)
$AVAILBLE_LANGUAGES=array(
		"Deutsch" => array("de","de_DE","deu"),
		"English" => array("en","en_US","eng")
    );

?>
