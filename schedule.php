<?php

$PAGE_TITLE='Belegungsplan';
$PAGE_HEADLINE='Belegungsplan';

include('include/header.inc');


if ($_GET['show'] == 1)
	{
	
	echo '<form><table>';
	
	echo '<tr><td>Name:</td><td><input type="text" name="name" value="Christian Heller"></td></tr>';
	echo '<tr><td>Anschrift:</td><td><textarea name="address">Schönauer Straße 113a
	Leipzig</textarea></td></tr>';
	echo '<tr><td>E-Mail:</td><td><input type="text" name="email" value="christian.heller@ba-leipzig.de"></td></tr>';
	echo '<tr><td>Telefon:</td><td><input type="text" name="phone" value="0341-1234567"></td></tr>';
			 
	echo '</table>';
	
	echo '<input type="submit" value="Änderungen speichern">';
	
	echo '</form>';
	
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
