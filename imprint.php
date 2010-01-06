<?php

$PAGE_TITLE='Impressum';
$PAGE_HEADLINE='Impressum';

include('include/header.inc');




echo "<p>".t("Dieses Projekt wurde im Rahmen eines BA-Studiums erstellt von")."</p>";
?>
<ul>
<li>Daniel Böhmer</li>
<li>Patrick Nicolaus</li>
</ul>

<? 
echo "<p>".t_replace("aus der Seminargruppe %s.", false, "IT2007")."</p>"; ?>

<h3>Anschrift</h3>
<p>Staatliche Berufsakademie Leipzig<br/>Schönauer Straße 113a<br/>04207 Leipzig</p>

<?php


include('include/footer.inc');
?>
