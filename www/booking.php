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

if ($_POST['insert'] == 1)
    {	
		$insert_flag = 1;
		
		if ((empty($_POST['begin'])) OR (empty($_POST['end'])))
		{
			messages_add("<p>".t("Datum nicht eingegeben.")."</p>", "error");
			$insert_flag = 0;
		}// if
		else
		{
			if ((check_date($_POST['begin']) == 0) OR (check_date($_POST['end']) == 0))
			{
				messages_add("<p>".t("Datum nicht gültig.")."</p>", "error"); 
				$insert_flag = 0;
			}// if
			else
			{	
				if (strtotime($_POST['begin']) > strtotime($_POST['end']))
				{
					messages_add("<p>".t("Kein gültiger Zeitraum.")."</p>", "error"); 
					$insert_flag = 0;
				}// if
				else
				{				
					$bookings_rooms = good_query_table('SELECT a.room as roomid, b.name AS roomname, b.id FROM bookings as a RIGHT JOIN rooms AS b ON a.room = b.id WHERE begin<="'.db_date_format($_POST['end'],0).'" AND end>="'.db_date_format($_POST['begin'],0).'" GROUP BY roomid');								
					foreach($bookings_rooms as $rooms)
					{
						if ($rooms['roomid'] == $_POST['room'])
						{
							$insert_flag = 0;
							messages_add("<p>".t("Zimmer ".$rooms['roomname']." im Zeitraum vom ".$_POST['begin']." bis ".$_POST['end']." nicht verfügbar.")."</p>", "error");
							break;
						}// if
					}// foreach
				}// else
			}// else
		}// else
		
		if ($_POST['room'] == 0)
		{
			$insert_flag = 0;
			messages_add("<p>".t("Kein Zimmer ausgewählt.")."</p>", "error"); 
		}
		
		if ($insert_flag)
		{
		
		good_query("INSERT INTO guests (firstname,lastname,street,number,zip,city,country,phone,email) VALUES 
('".$_POST['firstname']."','".$_POST['lastname']."','".$_POST['street']."','".$_POST['number']."','".$_POST['zip']."','".$_POST['city']."','".$_POST['country']."','".$_POST['phone']."','".$_POST['email']."')",2);
		
		$guest_id = good_last();
		 
		$rooms_room = good_query_table("SELECT id, capacity FROM rooms WHERE id='".$_POST['room']."'");		
		good_query("INSERT INTO bookings (room,guest,persons,begin,end,comment) VALUES 
('".$rooms_room[0]['id']."','".$guest_id."','".$rooms_room[0]['capacity']."','".db_date_format($_POST['begin'],0)."','".db_date_format($_POST['end'],0)."','".$_POST['comment']."')",2);

	    messages_add("<p>".t("Zimmer gebucht.")."</p>");
		}
	else
	    {
		messages_add("<p>".t(" Zimmer wurde nicht gebucht.")."</p>", "error");
		}
    
	}

messages_show();
?>
    
<form action="booking.php" method="post">

<table>
	<td><table border="0">
	<tr><td><?php echo t("Vorname");?>:</td>
	<td><input type="text" name="firstname"></td></tr>

    <tr><td><?php echo t("Nachname");?>:</td>
    <td><input type="text" name="lastname"></td></tr>
    
    <tr><td><?php echo t("Strasse");?>:</td>
    <td><input type="text" name="street"></td></tr>

    <tr><td><?php echo t("Hausnummer");?>:</td>
    <td><input type="text" name="number"></td></tr>
    
    <tr><td><?php echo t("PLZ");?>:</td>
    <td><input type="text" name="zip"></td></tr>
    
    <tr><td><?php echo t("Wohnort");?>:</td>
    <td><input type="text" name="city"></td></tr>
    
    <tr><td><?php echo t("Land");?>:</td>
    <td><input type="text" name="country"></td></tr>
    
    <tr><td><?php echo t("Telefon");?>:</td>
    <td><input type="text" name="phone"></td></tr>
    
    <tr><td><?php echo t("E-Mail");?>:</td>
    <td><input type="text" name="email"></td></tr>
	</table></td>

	<td><table border="0">
    	<tr><td><table border="0">
    	<tr><td><?php echo t("Datum Einchecken");?>:</td>
        <td><input type="text" name="begin"></td></tr>
        
        <tr><td><?php echo t("Datum Auschecken");?>:</td>
        <td><input type="text" name="end"></td></tr>
		</table></td></tr>
        
        <tr><td><table border="0">
		<tr><td><?php echo t("Zimmer");?>:</td>
		<td><select name="room" size="1"> 
        
		<?php
		
		$rooms = good_query_table("SELECT id, name, capacity FROM rooms",2);
		
		if (count($rooms) > 0)
		{
			foreach($rooms as $room)
			{
				echo '<option value="' . $room['id'] . '">' . $room['name'] . "\n(\n" . $room['capacity'] . "\n" . t("Person(en)") . "\n)" . '</option>';
			}
        }
        else
        {
        	echo '<option value="0">-</option>';
        }
        ?>
        
        </select></td></tr>
        
        </table></td></tr>
        
        <tr><td><table border="0">

        <tr><td><?php echo t("Kommentar");?>:</td>
        <td><textarea name="comment" rows="5" cols="42"></textarea></td></tr>
        
        </table></td></tr>
    </table></td>
</table>

<input type="hidden" name="insert" value="1">

<input type="submit" value="<?php echo t("Buchen");?>">
<input type="reset" value="<?php echo t("Zurücksetzen");?>">

</form>

<?php

include('include/footer.inc');
?>
