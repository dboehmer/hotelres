<?php
/*
 *      booking.php
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


$PAGE_TITLE='Buchungen';
$PAGE_HEADLINE='Ein Zimmer buchen';

include('include/header.inc');

?>


<form action="booking.php" method="post">

<table>
<tr><th><? echo t("Name");?>:</th>
<td><input type="text" name="name"></td></tr>

<tr><th><? echo t("Anschrift");?>:</th>
<td><textarea name="address"></textarea></td></tr>

<tr><th><? echo t("Telefon");?>:</th>
<td><input type="text" name="phone"></td></tr>

<tr><th><? echo t("E-Mail");?>:</th>
<td><input type="text" name="email"></td></tr>


<tr><th><? echo t("Datum Einchecken");?>:</th>
<td><input type="text" name="startdate"></td></tr>

<tr><th><? echo t("Datum Auschecken");?>:</th>
<td><input type="text" name="enddate"></td></tr>


<tr><th><? echo t("Raum");?>:</th>
<td><select name="room" size="1">

<?php
$rooms = good_query_table("SELECT id, name  FROM rooms",2);
echo $rooms;
foreach($rooms as $room)
	{
		echo '<option value="' . $room['id'] . '">' . $room['name'] . '</option>';
	}
?>

</select></td></tr>

</table>

<input type="submit" value="<? echo t("Buchen");?>">
</form>


<?php

include('include/footer.inc');
?>
