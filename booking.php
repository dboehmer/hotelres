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

// do actions if according $_POST value is given
unset($msg); // delete any old messages from past actions

if (empty($_POST))
    {
       	echo $msg;
	}
else
    {
		good_query("INSERT INTO guests (firstname,lastname,street,number,zip,city,country,phone,email) VALUES 
('".$_POST['firstname']."','".$_POST['lastname']."','".$_POST['street']."','".$_POST['number']."','".$_POST['zip']."','".$_POST['city']."','".$_POST['country']."','".$_POST['phone']."','".$_POST['email']."')",2);
		
		$guest_id = good_last();
		 
		$rooms_room = good_query_table("SELECT id, capacity FROM rooms WHERE id='".$_POST['room']."'");		
		good_query("INSERT INTO bookings (room,guest,persons,begin,end,comment) VALUES 
('".$rooms_room[0]['id']."','".$guest_id."','".$rooms_room[0]['capacity']."','".db_date_format($_POST['begin'])."','".db_date_format($_POST['end'])."','".$_POST['comment']."')",2);

	    $msg.="<p>".t("Zimmer gebucht.")."</p>";
		echo $msg;
	}
?>

<form action="booking.php" method="post">

<table>
	<th><table border="0">
	<tr><th><?php echo t("Vorname");?>:</th>
	<td><input type="text" name="firstname"></td></tr>

    <tr><th><?php echo t("Nachname");?>:</th>
    <td><input type="text" name="lastname"></td></tr>
    
    <tr><th><?php echo t("Strasse");?>:</th>
    <td><input type="text" name="street"></td></tr>

    <tr><th><?php echo t("Hausnummer");?>:</th>
    <td><input type="text" name="number"></td></tr>
    
    <tr><th><?php echo t("PLZ");?>:</th>
    <td><input type="text" name="zip"></td></tr>
    
    <tr><th><?php echo t("Wohnort");?>:</th>
    <td><input type="text" name="city"></td></tr>
    
    <tr><th><?php echo t("Land");?>:</th>
    <td><input type="text" name="country"></td></tr>
    
    <tr><th><?php echo t("Telefon");?>:</th>
    <td><input type="text" name="phone"></td></tr>
    
    <tr><th><?php echo t("E-Mail");?>:</th>
    <td><input type="text" name="email"></td></tr>
	</table></th>

	<th><table border="0">
    	<tr><th><table border="0">
    	<tr><th><?php echo t("Datum Einchecken");?>:</th>
        <td><input type="text" name="begin"></td></tr>
        
        <tr><th><?php echo t("Datum Auschecken");?>:</th>
        <td><input type="text" name="end"></td></tr>
		</table></th></tr>
        
        <tr><th><table border="0">
		<tr><th><?php echo t("Raum");?>:</th>
		<td><select name="room" size="1"> 
        
		<?php
        $rooms = good_query_table("SELECT id, name, capacity  FROM rooms",2);
        foreach($rooms as $room)
            {
                echo '<option value="' . $room['id'] . '">' . $room['name'] . "\n(\n" . $room['capacity'] . "\n" . t("Person(en)") . "\n)" . '</option>';
            }
        ?>
        
        </select></td></tr>
        
        </table></th></tr>
        
        <tr><th><table border="0">

        <tr><th><?php echo t("Kommentar");?>:</th>
        <td><textarea name="comment" rows="5" cols="42"></textarea></td></tr>
        
        </table></th></tr>
    </table></th>
</table>

<input type="submit" value="<?php echo t("Buchen");?>">
<input type="reset" value="<?php echo t("Reset");?>">

</form>


<?php

include('include/footer.inc');
?>
