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
	
if ($_GET['room'] == 1)
	{
	echo '<h2>Raumbelegung Raum 1</h2>';
	
	
	}

else
	{
	
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
	
	$number_day = strftime("%w",mktime(0,0,0,$_POST['month'],1,$_POST['year']));
	$count_days = date("t",mktime(0,0,0,$_POST['month'],1,$_POST['year']));
	
	echo strftime("%B %Y",mktime(0,0,0,$_POST['month'],1,$_POST['year']));
	
	echo '<table><tr><th>'.t("Montag").'</th>
					 <th>'.t("Dienstag").'</th>
					 <th>'.t("Mittwoch").'</th>
					 <th>'.t("Donnerstag").'</th>
					 <th>'.t("Freitag").'</th>
					 <th>'.t("Samstag").'</th>
					 <th>'.t("Sonntag").'</th></tr><tr>';
		
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
			
			$count_all_rooms = db_count_all_rooms();	
				
	for ($i=1; $i<=$count_days; $i++)
	{
		$count_engaged_rooms = db_count_engaged_rooms(db_date_format($i.".".$_POST['month'].".".$_POST['year']),db_date_format($i.".".$_POST['month'].".".$_POST['year']));
		
		$utilization = number_format((($count_engaged_rooms * 100) / $count_all_rooms),2);
			
		echo '<td><a href="'.url_add_parameter($_SERVER['REQUEST_URI'],"show",db_date_format($i.".".$_POST['month'].".".$_POST['year'])).'">'.$i.'</a><br /><pre> '.'('.$utilization.'%)'.'</pre> </td>';
				
		if ($j % 7 == 0)
		{
			echo '</tr><tr>';
		}
		
		$j++;
	}

	echo '</tr></table>';
	
	}
	}
	
	if (! empty($_GET['show']))
	{
		$bookings = good_query_table('SELECT a.room, a.guest, a.begin, a.end, a.comment, a.persons, b.id, b.name as name, c.id, c.firstname, c.lastname as roomid, b.name FROM bookings as a inner join rooms as b on a.room = b.id left join guests as c on a.guest = c.id WHERE begin<="'.$_GET['show'].'" AND end>="'.$_GET['show'].'"');
		
		echo '<form><table>';
		echo '<tr><th>'.t("Raum").'</th>
				  <th>'.t("Vorname").'</th>
				  <th>'.t("Nachname").'</th>
				  <th>'.t("Personen").'</th>
				  <th>'.t("Beginn").'</th>
				  <th>'.t("Ende").'</th>
				  <th>'.t("Kommentar").'</th></tr>';
		
		foreach ($bookings as $booking)
            {
				echo '<tr><td>'.$booking['name'].'</td>';
				echo '<td>'.$booking['firstname'].'</td>';
				echo '<td>'.$booking['lastname'].'</td>';
				echo '<td>'.$booking['persons'].'</td>';
				echo '<td>'.$booking['begin'].'</td>';
				echo '<td>'.$booking['end'].'</td>';
				echo '<td>'.$booking['comment'].'</td></tr>';
			}
			
	echo '</table>';	
	echo '</form>';
	
}

include('include/footer.inc');

?>
