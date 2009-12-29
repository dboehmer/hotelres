<?php

$PAGE_TITLE='Buchungen';
$PAGE_HEADLINE='Ein Zimmer buchen';

include('include/header.inc');

?>


<form action="booking.php" method="post">

<table>
<tr><th><? echo t("Name");?>:</th>
<td><input type="text" name="name"></td></tr>

<tr><th><? echo t("Anschrift");?>:</th>
<td><textarea name="address"></textarea></td></tr>

<tr><th><? echo t("Telefon");?>:</th>
<td><input type="text" name="phone"></td></tr>

<tr><th><? echo t("E-Mail");?>:</th>
<td><input type="text" name="email"></td></tr>


<tr><th><? echo t("Datum Einchecken");?>:</th>
<td><input type="text" name="startdate"></td></tr>

<tr><th><? echo t("Datum Auschecken");?>:</th>
<td><input type="text" name="enddate"></td></tr>


<tr><th><? echo t("Raum");?>:</th>
<td><select name="room" size="1">

<?php
$rooms = good_query_table("SELECT id, name  FROM rooms",2);
echo $rooms;
foreach($rooms as $room)
	{
		echo '<option value="' . $room['id'] . '">' . $room['name'] . '</option>';
	}
?>

</select></td></tr>

</table>

<input type="submit" value="<? echo t("Buchen");?>">
</form>


<?php

include('include/footer.inc');
?>
