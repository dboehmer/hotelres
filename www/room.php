<?php
/*
 *      www/room.php
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


$PAGE_TITLE='Zimmerverwaltung';
$PAGE_HEADLINE='Zimmer hinzufügen und entfernen';

define("BATCH_CHAR", "#");

include('include/header.inc');

// intro paragraph
echo "<p>".t("Auf dieser Seite können Sie die Zimmer verwalten.")."</p>";

if ($_SESSION['rights'] != "admin")
    {
        echo "<strong>".t("Sie haben keine Administratorrechte und können keine Zimmer verwalten!")."</strong>";
    }
else
{
	if ($_GET['room'] > 0)
	{
		$bookings_roomcount = good_query_table('SELECT COUNT(room) as roomcount FROM bookings WHERE room="'.$_GET['room'].'"');
		
		if ($bookings_roomcount[0]['roomcount'] > 0)
		{
			messages_add("<p>".t("Zimmer konnte nicht entfernt werden. Es existieren noch Buchungen.")."</p>", "error");
		}
		else
		{
			good_query('DELETE FROM rooms WHERE id="'.$_GET['room'].'"');
			
			messages_add("<p>".t("Zimmer erfolgreich entfernt.")."</p>");
		}// else
			
		messages_show();
        
        
	}// if
	
	
	elseif ($_POST['insert'] == 1)
	{
		good_query('INSERT INTO rooms (name,capacity) VALUES ("'.$_POST['name'].'", "'.$_POST['capacity'].'")',2);
				
		?>
		
        <br />
		<form action="room.php">
		
		<?php echo t("Zimmer erfolgreich hinzugefügt.");?>
		
		</form>
        <br />
		
		<?php
		
		$_POST['insert'] = 0;
	}// if
    
    /* batch creation of rooms, e.g. "Room 001"--"Room 120" */
    elseif ($_POST['batchcreation'] == 1) {
        $capacity = $_POST['capacity'];
        $first = $_POST['first'];
        $last = $_POST['last'];
        $name = $_POST['name'];
        
        // change if range is given in wrong direction (e.g. 8 to 1 => 1 to 8)
        if ($last < $first) {
            list($high,$low) = array($low,$high);
        }
        
        
        if ($_POST['leadingzeros']) {
            // room 001 -- room 120
            $format = str_replace(BATCH_CHAR, "%0" . strlen($last) . "d", $name);
        }
        else {
            // room 1 -- room 120
            $format = str_replace(BATCH_CHAR, "%d", $name);
        }
        
        
        for ($i=$first; $i<=$last; $i++) {
            $room = sprintf($format, $i);
            
            // remember 1st room name for message
            if (!isset($firstroom)) $firstroom = $room;
            
            //messages_add("<p>".t("Erstelle Raum &quot;$room&quot;</p>"));
            good_query("INSERT INTO rooms (name, capacity) VALUES ('$room', '$capacity')", 2);
            
        }
        
        messages_add("<p>Räume &quot;$firstroom&quot; bis &quot;$room&quot; mit jeweils $capacity Personen erstellt.</p>");
        messages_show();
    }
		
	echo "<h3>".t("Verfügbare Zimmer")."</h3>";
	
	$rooms_rooms = good_query_table('SELECT id as roomid, name, capacity FROM rooms ORDER BY name ASC');
	
	echo '<form><table>';
	echo '<tr><th>'.t("Name").'</th>
			  <th>'.t("Personen").'</th>
			  <th>'.t("Entfernen").'</th></tr>';
			
	foreach ($rooms_rooms as $rooms)
	{
		echo '<td>'.$rooms['name'].'</td>';
		echo '<td>'.$rooms['capacity'].'</td>';
		
        // JavaScript code for question "Do you really want to delete?"
        $js = "return confirm('". t_replace("Möchten Sie das Zimmer &quot;%s&quot; wirklich löschen?", false, $rooms['name']) ."');";
        
		echo '<td><a onclick="'.$js.'" href="'.url_add_parameter($_SERVER['ORIG_PATH_INFO'].'?show=0',"room",$rooms['roomid']).'">'.t("Entfernen").'</a></td></tr>';
	}// foreach
			
	echo '</table>';	
	echo '</form>';

	echo "<br /><h3>".t("Zimmer hinzufügen")."</h3>";	
	
	?>
		
	<form action="room.php" method="post">
	
	<table border="0">
    <tr>
		<td><?php echo t("Zimmername");?>:</td>
		<td><input type="text" name="name"></td>
	</tr><tr>
		<td><?php echo t("Personenzahl");?>:</td>
		<td><input type="text" name="capacity"></td>
    </tr>
	</table>
	
	<input type="hidden" name="insert" value="1">
	
	<p><input type="submit" value="<?php echo t("Hinzufügen");?>">
	<input type="reset" value="<?php echo t("Zurücksetzen");?>"></p>
	
	</form>
    
    <? echo "<h3>" . t("Massenerstellung") . "</h3>";
    
    echo "<p>".t("Erstellen Sie eine Reihe von Räumen mit gleichem Namen und fortlaufenden Nummern.")."</p>"; ?>
    
    <form action="room.php" method="post">
    <input type="hidden" name="batchcreation" value="1" />
    
    <table>
        <tr>
            <td><? echo t("Zimmername"); ?>:</td>
            <td><input type="text" name="name" value="Zimmer #"> (<code><? echo htmlentities(BATCH_CHAR);?></code> wird durch die Nummer ersetzt)</td>
        </tr><tr>
            <td><? echo t("Erste Nummer"); ?>:</td>
            <td><input type="text" name="first" value="1"></td>
        </tr><tr>
            <td><? echo t("Letzte Nummer"); ?>:</td>
            <td><input type="text" name="last" value="100"></td>
        </tr><tr>
		<td><?php echo t("Personenzahl pro Zimmer");?>:</td>
		<td><input type="text" name="capacity"></td>
    </tr>
    </table>
    
    <p><input type="checkbox" name="leadingzeros"> führende Nullen verwenden (Beispiel: Zimmer 001&ndash;Zimmer 120)</p>
    
    <p><input type="submit" value="<? echo t("Alle erstellen");?>"></p>
    </form>
		
	<?php
}// else

include('include/footer.inc');
?>
