<?php

$PAGE_TITLE='Buchungen';
$PAGE_HEADLINE='Ein Zimmer buchen';

include('include/header.inc');

?>


<form action="booking.php" method="post">

<table>
<tr><th>Name:</th>
<th><input type="text" name="name"></th></tr>

<tr><th>E-Mail:</th>
<th><input type="text" name="email"></th></tr>
</table>

<input type="submit" value="Buchen">
</form>


<?php

include('include/footer.inc');
?>
