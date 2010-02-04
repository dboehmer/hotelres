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
    
    <input type="hidden" name="update" value="1">
            
	<input type="submit" value="<?php echo t("Anzeigen");?>">
</form>
<br />

<?php

if (! empty($_POST))
{	
	if ($_POST['update'] == 2)
	{
		good_query('UPDATE guests SET firstname="'.$_POST['firstname'].'", lastname="'.$_POST['lastname'].'", street="'.$_POST['street'].'", number="'.$_POST['number'].'", zip="'.$_POST['zip'].'", city="'.$_POST['city'].'", country="'.$_POST['country'].'", phone="'.$_POST['phone'].'", email="'.$_POST['email'].'" WHERE id="'.$_POST['guest'].'"');
		
		?>
		<br />
		<form action="schedule.php" method="get">
		
        <?php echo t("Daten erfolgreich aktualisiert.");?>
        
        <br /><br />
        <input type="hidden" name="show" value="<?php echo $_POST['date'];?>">
        <input type="submit" value="<?php echo t("weiter");?>">

		</form>
		<?php
    }
	else if ($_POST['update'] == 1)
	{
	$number_day = strftime("%w",mktime(0,0,0,$_POST['month'],1,$_POST['year']));
	$count_days = date("t",mktime(0,0,0,$_POST['month'],1,$_POST['year']));
	
	echo utf8_encode(strftime("%B %Y",mktime(0,0,0,$_POST['month'],1,$_POST['year'])));
	
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
	} //switch
			
			$count_all_rooms = db_count_all_rooms();	
				
	for ($i=1; $i<=$count_days; $i++)
	{
		$count_engaged_rooms = db_count_engaged_rooms(db_date_format($i.".".$_POST['month'].".".$_POST['year']),db_date_format($i.".".$_POST['month'].".".$_POST['year']));
		
		$utilization = number_format((($count_engaged_rooms * 100) / $count_all_rooms),2);
			
		echo '<td><a href="'.url_add_parameter($_SERVER['REQUEST_URI'],"show",db_date_format($i.".".$_POST['month'].".".$_POST['year'])).'">'.$i.'</a><br /><pre> '.'('.$utilization.'%)'.'</pre> </td>';
				
		if ($j % 7 == 0)
		{
			echo '</tr><tr>';
		}// if
		
		$j++;
	} //for

	echo '</tr></table>';
	} // else
}// if

if (! empty($_GET['delete']))
{
	$del_bookings = good_query_table('SELECT id as bookingid, guest as guestid FROM bookings WHERE id="'.$_GET['delete'].'"');
	
	good_query('DELETE FROM bookings WHERE id="'.$del_bookings[0]['bookingid'].'"');
	good_query('DELETE FROM guests WHERE id="'.$del_bookings[0]['guestid'].'"');
	
	?>
		<br />
		<form action="schedule.php" method="get">
		
        <?php echo t("Buchung erfolgreich storniert.");?>
        
        <br /><br />
        <input type="hidden" name="show" value="<?php echo $_GET['date'];?>">
        <input type="submit" value="<?php echo t("weiter");?>">

		</form>
	<?php
}

if (! empty($_GET['show']))
{
	echo 'Raumbelegung am '.default_date_format($_GET['show']);

	$bookings = good_query_table('SELECT a.id as bookingid, a.room, a.guest as guestid, a.begin, a.end, a.comment, a.persons, b.id, b.name as name, c.id, c.firstname, c.lastname, b.name FROM bookings as a right join rooms as b on a.room = b.id left join guests as c on a.guest = c.id WHERE begin<="'.$_GET['show'].'" AND end>="'.$_GET['show'].'" ORDER BY c.lastname ASC');
	
	echo '<form><table>';
	echo '<tr><th>'.t("").'</th>
			  <th>'.t("Raum").'</th>
			  <th>'.t("Vorname").'</th>
			  <th>'.t("Nachname").'</th>
			  <th>'.t("Personen").'</th>
			  <th>'.t("Beginn").'</th>
			  <th>'.t("Ende").'</th>
			  <th>'.t("Kommentar").'</th>
			  <th>'.t("").'</th></tr>';
			
	foreach ($bookings as $booking)
	{
		echo '<tr><td><a href="'.url_add_parameter($_SERVER['ORIG_PATH_INFO'].'?show='.$_GET['show'].'',"edit",$booking['guestid']).'">'.t("Bearbeiten").'</a></td>';
			
		echo '<td>'.$booking['name'].'</td>';
		echo '<td>'.$booking['firstname'].'</td>';
		echo '<td>'.$booking['lastname'].'</td>';
		echo '<td>'.$booking['persons'].'</td>';
		echo '<td>'.default_date_format($booking['begin']).'</td>';
		echo '<td>'.default_date_format($booking['end']).'</td>';
		echo '<td>'.$booking['comment'].'</td>';
		
		echo '<td><a href="'.url_add_parameter($_SERVER['ORIG_PATH_INFO'].'?date='.$_GET['show'].'',"delete",$booking['bookingid']).'">'.t("Stornieren").'</a></td></tr>';
	}// foreach
			
	echo '</table>';	
	echo '</form>';
}// if

if (! empty($_GET['edit']))
{

$guests_guest = good_query_table('SELECT id,firstname, lastname, street, number, zip, city, country, phone, email FROM guests WHERE id="'.$_GET['edit'].'"');

echo '<br />Kundendaten von '.$guests_guest[0]['firstname'].' '.$guests_guest[0]['lastname'].'';
?>

<br />
<form action="schedule.php" method="post">

<table>
	<th><table border="0">
	<tr><th><?php echo t("Vorname");?>:</th>
	<td><input type="text" name="firstname" value="<?php echo $guests_guest[0]['firstname']?>"></td></tr>

    <tr><th><?php echo t("Nachname");?>:</th>
    <td><input type="text" name="lastname" value="<?php echo $guests_guest[0]['lastname']?>"></td></tr>
    
    <tr><th><?php echo t("Strasse");?>:</th>
    <td><input type="text" name="street" value="<?php echo $guests_guest[0]['street']?>"></td></tr>

    <tr><th><?php echo t("Hausnummer");?>:</th>
    <td><input type="text" name="number"value="<?php echo $guests_guest[0]['number']?>"></td></tr>
    
    <tr><th><?php echo t("PLZ");?>:</th>
    <td><input type="text" name="zip" value="<?php echo $guests_guest[0]['zip']?>"></td></tr>
    
    <tr><th><?php echo t("Wohnort");?>:</th>
    <td><input type="text" name="city" value="<?php echo $guests_guest[0]['city']?>"></td></tr>
    
    <tr><th><?php echo t("Land");?>:</th>
    <td><input type="text" name="country" value="<?php echo $guests_guest[0]['country']?>"></td></tr>
    
    <tr><th><?php echo t("Telefon");?>:</th>
    <td><input type="text" name="phone" value="<?php echo $guests_guest[0]['phone']?>"></td></tr>
    
    <tr><th><?php echo t("E-Mail");?>:</th>
    <td><input type="text" name="email" value="<?php echo $guests_guest[0]['email']?>"></td></tr>
	</table></th>

	<th><table border="0">
    	<tr><th><?php echo t("Kommentar");?>:</th>
        <td><textarea name="comment" rows="5" cols="42" value="<?php echo $guests_guest[0]['comment']?>"></textarea></td></tr>
        
        </table></th></tr>
    </table></th>
</table>

<input type="hidden" name="update" value="2">
<input type="hidden" name="date" value="<?php echo $_GET['show'];?>">
<input type="hidden" name="guest" value="<?php echo $guests_guest[0]['id'];?>">
    
<input type="submit" value="<?php echo t("Aktualisieren");?>">

</form>

<?php

}// if edit

include('include/footer.inc');

?>
