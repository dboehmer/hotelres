<?php
/*
 *      guestinfo.php
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


$PAGE_TITLE='Reservierungsinfo für Gäste';
$PAGE_HEADLINE='Ihre Reservierung';

include('include/header.inc');


$id = $_GET['id'];
$token = $_GET['token'];


if (1 != good_query_value("SELECT COUNT(id) FROM bookings WHERE id='$id' AND security_token='$token'")) {
    echo "<p>".t("Sie haben keine Berechtigung für diese Seite!")."</p>";
    include("include/footer.inc");
    exit;
}


$booking = good_query_assoc("SELECT b.*, g.*
                             FROM bookings AS b, guests AS g
                             WHERE b.id='$id' AND g.id=b.guest");

//var_dump($booking);





echo '<p>'.t("Dies sind die aktuell gespeicherten Informationen zu Ihrer Buchung.").'</p>

<p>'.t_replace("Sollten Sie einen Fehler entdecken oder sonstige Fragen haben, melden Sie ".
"sich gerne bei unserem Personal. Kontaktdaten finden Sie im %s.", false,
    '<a href="imprint.php">'.t("Impressum").'</a>');

echo '<table>';

echo '<tr><th>'.t("Name").'</th><td>'.$booking['firstname']." ".$booking['lastname'].'</td></tr>';
echo '<tr><th>'.t("Adresse").'</th><td>'.$booking['street']." ".$booking['number']."<br/>".$booking['zip']." ".$booking['city'].'</td></tr>';
echo '<tr><th>'.t("Land").'</th><td>'.$booking['country'].'</td></tr>';
echo '<tr><th>'.t("Telefon").'</th><td>'.$booking['phone'].'</td></tr>';
echo '<tr><th>'.t("E-Mail").'</th><td>'.$booking['email'].'</td></tr>';

echo '</table>';

echo '<p>'.t_replace("Sie haben gebucht vom %s zum %s.", false, 
    own_date_format("%d.%m.%Y",$booking['begin'],0),
    own_date_format("%d.%m.%Y",$booking['end'],60*60*24)).'</p>';


include('include/footer.inc');
?>
