<?php
/*
 *      schedule.php
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



$PAGE_TITLE='Belegungsplan';
$PAGE_HEADLINE='Belegungsplan';

include('include/header.inc');


if ($_GET['show'] == 1)
	{
	
	echo '<form><table>';
	
	echo '<tr><th>'.t("Name").':</th><td><input type="text" name="name" value="Christian Heller"></td></tr>';
	echo '<tr><th>'.t("Anschrift").':</th><td><textarea name="address">Schönauer Straße 113a
	Leipzig</textarea></td></tr>';
	echo '<tr><th>'.t("E-Mail").':</th><td><input type="text" name="email" value="christian.heller@ba-leipzig.de"></td></tr>';
	echo '<tr><th>'.t("Telefon").':</th><td><input type="text" name="phone" value="0341-1234567"></td></tr>';
    echo '<tr><th>'.t("Datum Einchecken").':</th>
            <td><input type="text" name="startdate"></td></tr>

            <tr><th>'. t("Datum Auschecken").':</th>
            <td><input type="text" name="enddate"></td></tr>

            <tr><th>'.t("Raum").':</th>
            <td><select name="room" size="1">';

    $rooms = good_query_table("SELECT id, name  FROM rooms",2);
    echo $rooms;
    foreach($rooms as $room)
        {
            echo '<option value="' . $room['id'] . '">' . $room['name'] . '</option>';
        }
    echo '</select></td></tr>';
    
	echo '</table>';
	
	echo '<input type="submit" value="'.t("Änderungen speichern").'">';
	
	echo '</form>';
	
	}
	
if ($_GET['room'] == 1)
	{
	echo '<h2>Raumbelegung Raum 1</h2>';
	
	
	}

else
	{
	
	echo '<p><a href="schedule.php?show=1">Show single booking edit form</a></p>';

?>
	<form action="schedule.php" method="post">
	
    <table>
		<tr><th><?php echo t("Monat");?>:</th>
		  <td><select name="month" size="1"> 
          	<option value="1"><?php echo t("Januar");?></option>
			<option value="2"><?php echo t("Februar");?></option>
			<option value="3"><?php echo t("März");?></option>
			<option value="4"><?php echo t("April");?></option>
			<option value="5"><?php echo t("Mai");?></option>
			<option value="6"><?php echo t("Juni");?></option>
			<option value="7"><?php echo t("Juli");?></option>
			<option value="8"><?php echo t("August");?></option>
			<option value="9"><?php echo t("September");?></option>
			<option value="10"><?php echo t("Oktober");?></option>
            <option value="11"><?php echo t("November");?></option>
			<option value="12"><?php echo t("Dezember");?></option>        
        </select></td>
        
        <th><?php echo t("Jahr");?>:</th>
		  <td><select name="year" size="1"> 
          	<option value="2010">2010</option>
			<option value="2011">2011</option>
			<option value="2012">2012</option>
			<option value="2013">2013</option>
        </select></td></tr>
    </table>
        
    <input type="submit" value="<?php echo t("Anzeigen");?>">

	</form>
    <br />
<?php
	if (!empty($_POST))
    {

	echo '<table><tr><th>'.t("Montag").'</th>
					 <th>'.t("Dienstag").'</th>
					 <th>'.t("Mittwoch").'</th>
					 <th>'.t("Donnerstag").'</th>
					 <th>'.t("Freitag").'</th>
					 <th>'.t("Samstag").'</th>
					 <th>'.t("Sonntag").'</th></tr><tr>';
					 
	setlocale(LC_TIME,"de_DE");
	$number_day = strftime("%w",mktime(0,0,0,$_POST['month'],1,$_POST['year']));
	$count_days = date("t",mktime(0,0,0,$_POST['month'],1,$_POST['year']));
		
	switch ($number_day)
    {
        case 1:
			$j = 1;
           	break;
		case 2:
           	echo '<td></td>';
			$j = 2;
            break;
		case 3:
            echo '<td></td><td></td>';
			$j = 3;
            break;
		case 4:
            echo '<td></td><td></td><td></td>';
			$j = 4;
            break;
		case 5:
            echo '<td></td><td></td><td></td><td></td>';
            $j = 5;
			break;
		case 6:
            echo '<td></td><td></td><td></td><td></td><td></td>';
            $j = 6;
			break;
		case 0:
            echo '<td></td><td></td><td></td><td></td><td></td><td></td>';
            $j = 7;
			break;
	}
			
	for ($i=1; $i<=$count_days; $i++)
	{
		echo '<td>'.$i.'</td>';
				
		if ($j % 7 == 0)
		{
			echo '</tr><tr>';
		}
		
		$j++;
	}

	echo '</tr></table>';
	
	}
	}

include('include/footer.inc');

?>
