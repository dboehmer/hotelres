<?php
/*
 *      www/imprint.php
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


$PAGE_TITLE='Impressum';
$PAGE_HEADLINE='Impressum';

include('include/header.inc');




echo "<p>".t("Dieses Projekt wurde im Rahmen eines Software-Projekt für ein BA-Studium erstellt von")."</p>";
?>
<ul>
<li>Daniel Böhmer,</li>
<li>Patrick Nicolaus und</li>
<li><? echo t_replace("im %s. Semester", false, 6); ?> Tarek Alchanaa</li>
</ul>

<?php
echo '<p>'.t_replace("aus der Seminargruppe %s.", false, "IT2007").'</p>'; 

echo '<h3>'.t("Anschrift").'</h3>';
?>

<div class="vcard">
 <p class="fn">Staatliche Berufsakademie Leipzig</p>
 <div class="adr">
  <div class="street-address">Schönauer Straße 113a</div>
  <span class="postal-code">04207</span>
  <span class="locality">Leipzig</span>
  <br />
  <span class="region">Sachsen</span>,
  <span class="country-name">Deutschland</span>
 </div>
 <div class="tel">
  <p><strong><?php echo t("Telefon");?>:</strong> <span class="home">0341 / 42743-330</span></p>
 </div>
 <p><strong><?php echo t("E-Mail");?>:</strong> <a class="email" href="mailto:info@ba-leipzig.de">info@ba-leipzig.de</a></p>
</div>

<?php


include('include/footer.inc');
?>
