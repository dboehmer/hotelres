<?php

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

	echo '<h2>Sample</h2>';

	echo '<table><tr><th>Tag</th>';
	for ($i=1; $i<=7; $i++)
		{
		echo "<th>$i.12.2009</th>";
		}


	echo '</tr><tr><th>Belegung</th>';
	for ($i=1; $i<=7; $i++)
		{
		echo "<td>" . ($i*3) . "%</td>";
		}

	echo '</tr></table>';
	
	}

include('include/footer.inc');

?>
